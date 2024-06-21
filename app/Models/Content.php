<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Class Content
 * @package App\Models
 */
class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_visibility_id',
        'scheduled_on',
        'content_url',
        'content_slug',
        'title',
        'content_type_id',
        'content_category_id',
        'description',
        'content',
        'allow_comments',
        'allow_share',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'content_category_id',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 2,
            'key' => 'content_visibility_id',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 3,
            'key' => 'scheduled_on',
            'type' => 'datetime-local',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 4,
            'key' => 'title',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 5,
            'key' => 'content_type_id',
            'type' => 'select',
            'is_filter' => true,
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
        [
            'id' => 7,
            'key' => 'content',
            'type' => 'textarea',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 8,
            'key' => 'allow_comments',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 9,
            'key' => 'allow_share',
            'type' => 'select',
            'is_filter' => true,
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
        'content_visibility_id' => 'integer',
        'scheduled_on' => 'datetime:d.m.Y',
        'content_type_id' => 'integer',
        'content_category_id' => 'integer',
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

    public function content_category(): BelongsTo
    {
        return $this->belongsTo('App\Models\ContentCategory');
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
                'scheduled_on',
                'content_url',
                'title',
                'content_type_id',
                'content_category_id',
            )
                ->with([
                    'content_category' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content_visibility' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'content_category_id' || $field === 'content_visibility_id'
                        || $field === 'content_type_id' || $field === 'user_id') {
                        $query->where($field, '=', $value);
                    } else if ($field === 'scheduled_on') {
                        $query->where($field, '>=', Carbon::parse($value)->startOfDay())
                            ->where($field, '<=', Carbon::parse($value)->endOfDay());
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();
            $query->each(function ($item) {
                $item->makeHidden('content_category_id');
                $item->makeHidden('content_visibility_id');
                $item->makeHidden('content_type_id');
                $item->makeHidden('user_id');
            });

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Content|Exception
    {
        try {
            return $this->create([
                'content_visibility_id' => $payload['content_visibility_id'],
                'scheduled_on' => $payload['scheduled_on'],
                'content_url' => $payload['content_url'],
                'content_slug' => $payload['content_slug'],
                'title' => $payload['title'],
                'content_type_id' => $payload['content_type_id'],
                'content_category_id' => $payload['content_category_id'],
                'description' => $payload['description'],
                'content' => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'allow_share' => $payload['allow_share'],
                'user_id' => $payload['user_id'],
            ]);
        } catch (Exception $exception) {
            dd($exception);
            return $exception;
        }
    }

    public function fetchSingleRecord(int $id): Collection|Exception
    {
        try {
            return $this->select('*')
                ->where('id', '=', $id)
                ->with([
                    'content_category' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
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
                            'comment_status_id',
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
                'scheduled_on' => $payload['scheduled_on'],
                'content_url' => $payload['content_url'],
                'content_slug' => $payload['content_slug'],
                'title' => $payload['title'],
                'content_type_id' => $payload['content_type_id'],
                'content_category_id' => $payload['content_category_id'],
                'description' => $payload['description'],
                'content' => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'allow_share' => $payload['allow_share'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function partialUpdateRecord(array $payload, int $id): Content|Exception
    {
        try {
            $query = $this->findOrFail($id);
            $query->update([
                'content_visibility_id' => $payload['content_visibility_id'],
                'scheduled_on' => $payload['scheduled_on'],
            ]);

            return $query->refresh();
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

    public function getInputs(): array
    {
        $inputs = $this->inputs;
        foreach ($inputs as &$input) {
            if ($input['key'] === 'content_category_id') {
                $input['options'] = $this->content_category()
                    ->getRelated()
                    ->get(['id', 'value', 'label'])
                    ->toArray();
            }
            elseif ($input['key'] === 'content_visibility_id') {
                $input['options'] = $this->content_visibility()
                    ->getRelated()
                    ->get(['id', 'value', 'label'])
                    ->toArray();
            }
            elseif ($input['key'] === 'content_type_id') {
                $input['options'] = $this->content_type()
                    ->getRelated()
                    ->get(['id', 'value', 'label'])
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
