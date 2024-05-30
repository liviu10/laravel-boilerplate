<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Content
 * @package App\Models
 */
class ContentSocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'platform_name',
        'full_share_url',
        'user_id',
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
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
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
                'content_id',
                'platform_name',
                'full_share_url',
                'user_id',
            )
                ->with([
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

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): ContentSocialMedia|Exception
    {
        try {
            return $this->create([
                'content_id' => $payload['content_id'],
                'platform_name' => $payload['platform_name'],
                'full_share_url' => $payload['full_share_url'],
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
                        $query->select(
                            'id',
                            'content_visibility_id',
                            'title',
                            'content_type_id'
                        )->with([
                            'content_visibility' => function ($query) {
                                $query->select('id', 'content_id', 'label');
                            },
                            'content_type' => function ($query) {
                                $query->select('id', 'content_id', 'label');
                            }
                        ]);
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

    public function updateRecord(array $payload, int $id): ContentSocialMedia|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'content_id' => $payload['content_id'],
                'platform_name' => $payload['platform_name'],
                'full_share_url' => $payload['full_share_url'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): ContentSocialMedia|Exception
    {
        try {
            $query = $this->find($id);
            $query->delete();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
