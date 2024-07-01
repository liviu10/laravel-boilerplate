<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Comment
 * @package App\Models
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_type_id',
        'comment_status_id',
        'content_id',
        'full_name',
        'email',
        'message',
        'notify_new_comments',
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
        'comment_type_id' => 'integer',
        'comment_status_id' => 'integer',
        'notify_new_comments' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'notify_new_comments' => false,
    ];

    public function comment_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\CommentType');
    }

    public function comment_status(): BelongsTo
    {
        return $this->belongsTo('App\Models\CommentStatus', 'comment_status_id');
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
                'comment_type_id',
                'comment_status_id',
                'content_id',
                'full_name',
                'user_id',
            )
                ->with([
                    'comment_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'comment_status' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'comment_type_id' || $field === 'comment_status_id' || $field === 'content_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Comment|Exception
    {
        try {
            return $this->create([
                'comment_type_id' => $payload['comment_type_id'],
                'comment_status_id' => $payload['comment_status_id'],
                'content_id' => $payload['content_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'message' => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
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
                    'comment_type' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'comment_status' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): Comment|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'comment_type_id' => $payload['comment_type_id'],
                'comment_status_id' => $payload['comment_status_id'],
                'content_id' => $payload['content_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'message' => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): Comment|Exception
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
