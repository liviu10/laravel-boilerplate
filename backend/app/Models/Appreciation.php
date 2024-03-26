<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class Appreciation
 * @package App\Models
 */
class Appreciation extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'user_id',
        'likes',
        'dislikes',
        'rating',
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
        'likes' => 'integer',
        'dislikes' => 'integer',
        'rating' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

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
                'user_id',
                'likes',
                'dislikes',
                'rating',
            )
                ->with([
                    'content' => function ($query) {
                        $query->select('id', 'title');
                    },
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    $query->where($field, '=', $value);
                }
            }

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Appreciation|Exception
    {
        try {
            return $this->create([
                'content_id' => $payload['content_id'],
                'user_id' => $payload['user_id'],
                'likes' => $payload['likes'],
                'dislikes' => $payload['dislikes'],
                'rating' => $payload['rating'],
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
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): Appreciation|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'content_id' => $payload['content_id'],
                'user_id' => $payload['user_id'],
                'likes' => $payload['likes'],
                'dislikes' => $payload['dislikes'],
                'rating' => $payload['rating'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): bool|Exception
    {
        try {
            $this->find($id)->delete();

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
