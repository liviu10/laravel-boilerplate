<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Content
 * @package App\Models
 */
class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_visibility_id',
        'content_url',
        'title',
        'content_type_id',
        'description',
        'content',
        'allow_comments',
        'allow_share',
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
        'content_visibility_id' => 'integer',
        'content_type_id' => 'integer',
        'allow_comments' => 'boolean',
        'allow_share' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'allow_comments' => false,
        'allow_share' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function content_visibility(): BelongsTo
    {
        return $this->belongsTo('App\Models\ContentVisibility');
    }

    public function content_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\ContentType');
    }

    public function content_social_media(): HasMany
    {
        return $this->hasMany('App\Models\ContentSocialMedia');
    }

    public function tags(): HasMany
    {
        return $this->hasMany('App\Models\Tag');
    }

    public function media(): HasMany
    {
        return $this->hasMany('App\Models\Media');
    }

    public function comments(): HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function appreciations(): HasMany
    {
        return $this->hasMany('App\Models\Appreciation');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'content_visibility_id',
                'content_url',
                'title',
                'content_type_id',
                'user_id',
            )
                ->with([
                    'content_visibility' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'content_visibility_id'
                        || $field === 'content_type_id' || $field === 'user_id') {
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

    public function createRecord(array $payload): Content|Exception
    {
        try {
            return $this->create([
                'content_visibility_id' => $payload['content_visibility_id'],
                'content_url' => $payload['content_url'],
                'title' => $payload['title'],
                'content_type_id' => $payload['content_type_id'],
                'description' => $payload['description'],
                'content' => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'allow_share' => $payload['allow_share'],
                'is_active' => $payload['is_active'],
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
                    'content_visibility' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content_social_media' => function ($query) {
                        $query->select('id', 'platform_name', 'full_share_url');
                    },
                    'tags' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    },
                    'media' => function ($query) {
                        $query->select(
                            'id',
                            'media_type_id',
                            'content_id',
                            'internal_path',
                            'external_path'
                        )->with([
                            'media_type' => function ($query) {
                                $query->select('id', 'label');
                            }
                        ]);
                    },
                    'comments' => function ($query) {
                        $query->select(
                            'id',
                            'comment_type_id',
                            'comment_statuses_id',
                            'content_id',
                            'full_name',
                            'email',
                            'message',
                            'notify_new_comments',
                        )->with([
                            'comment_type' => function ($query) {
                                $query->select('id', 'label');
                            },
                            'comment_status' => function ($query) {
                                $query->select('id', 'label');
                            }
                        ]);
                    },
                    'appreciations' => function ($query) {
                        $query->select(
                            'id',
                            'content_id',
                            'user_id',
                            'likes',
                            'dislikes',
                            'rating',
                        );
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

    public function updateRecord(array $payload, int $id): Content|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'content_visibility_id' => $payload['content_visibility_id'],
                'content_url' => $payload['content_url'],
                'title' => $payload['title'],
                'content_type_id' => $payload['content_type_id'],
                'description' => $payload['description'],
                'content' => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'allow_share' => $payload['allow_share'],
                'is_active' => $payload['is_active'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): Content|Exception
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
