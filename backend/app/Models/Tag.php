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
                'content_id' => function ($query) {
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

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): Content|Exception
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
                    'content_id' => function ($query) {
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

    public function updateRecord(array $payload, int $id): Content|Exception
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
