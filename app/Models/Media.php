<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Media
 * @package App\Models
 */
class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_type_id',
        'content_id',
        'internal_path',
        'external_path',
        'title',
        'caption',
        'alt_text',
        'description',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'media_type_id',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 2,
            'key' => 'content_id',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 3,
            'key' => 'title',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 4,
            'key' => 'caption',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 5,
            'key' => 'alt_text',
            'type' => 'text',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 6,
            'key' => 'description',
            'type' => 'text',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => true,
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
        'media_type_id' => 'integer',
        'content_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function media_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\MediaType');
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
                'media_type_id',
                'content_id',
                'internal_path',
                'title',
                'caption',
                'alt_text',
            )
                ->with([
                    'media_type' => function ($query) {
                        $query->select('id', 'label');
                    },
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'media_type_id' || $field === 'content_id' || $field === 'user_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();
            $query->each(function ($item) {
                $item->makeHidden('media_type_id');
                $item->makeHidden('content_id');
                $item->makeHidden('user_id');
            });

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Media|Exception
    {
        try {
            return $this->create([
                'media_type_id' => $payload['media_type_id'],
                'content_id' => $payload['content_id'],
                'internal_path' => $payload['internal_path'],
                'external_path' => $payload['external_path'],
                'title' => $payload['title'],
                'caption' => $payload['caption'],
                'alt_text' => $payload['alt_text'],
                'description' => $payload['description'],
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
                    'media_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
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

    public function updateRecord(array $payload, int $id): Media|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'media_type_id' => $payload['media_type_id'],
                'content_id' => $payload['content_id'],
                'internal_path' => $payload['internal_path'],
                'external_path' => $payload['external_path'],
                'title' => $payload['title'],
                'caption' => $payload['caption'],
                'alt_text' => $payload['alt_text'],
                'description' => $payload['description'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): Media|Exception
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
            if ($input['key'] === 'media_type_id') {
                $input['options'] = $this->media_type()->getRelated()->get(['value', 'label'])->toArray();
            }
            elseif ($input['key'] === 'content_id') {
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
        }

        return $inputs;
    }
}
