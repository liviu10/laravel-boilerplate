<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'name',
        'description',
        'slug',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'content_id',
            'type' => 'select',
        ],
        [
            'id' => 2,
            'key' => 'name',
            'type' => 'text',
        ],
        [
            'id' => 3,
            'key' => 'description',
            'type' => 'text',
        ],
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'content_id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo('App\Models\Content');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'content_id',
                'name',
                'slug',
                'user_id',
            )
                ->with([
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'content_id' || $field === 'user_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();
            $query->each(function ($item) {
                $item->makeHidden('content_id');
                $item->makeHidden('user_id');
            });

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Tag|Exception
    {
        try {
            return $this->create([
                'content_id' => $payload['content_id'],
                'name' => $payload['name'],
                'description' => $payload['description'],
                'slug' => $payload['slug'],
                'user_id' => $payload['user_id'],
            ]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function fetchSingleRecord(int $id): Collection|Exception
    {
        try {
            return $this->select('*')
                ->where('id', '=', $id)
                ->with([
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): Tag|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'content_id' => $payload['content_id'],
                'name' => $payload['name'],
                'description' => $payload['description'],
                'slug' => $payload['slug'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): Tag|Exception
    {
        try {
            $query = $this->find($id);
            $query->delete();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function getInputs(): array
    {
        $inputs = $this->inputs;
        foreach ($inputs as &$input) {
            if ($input['key'] === 'content_id') {
                $input['options'] = $this->content()
                    ->getRelated()
                    ->get(['id', 'title'])
                    ->map(function ($item) {
                        return [
                            'value' => $item['id'],
                            'label' => $item['name']
                        ];
                    })
                    ->toArray();
            }
            elseif ($input['key'] === 'allow_comments' || $input['key'] === 'allow_share') {
                $input['options'] = [
                    [
                        'id' => 1,
                        'value' => 0,
                        'label' => __('No'),
                    ],
                    [
                        'id' => 2,
                        'value' => 1,
                        'label' => __('Yes'),
                    ],
                ];
            }
        }

        return $inputs;
    }
}
