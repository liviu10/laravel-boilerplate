<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class MediaType
 * @package App\Models
 */
class MediaType extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'label',
        'is_active',
        'user_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function media(): HasMany
    {
        return $this->hasMany('App\Models\Media');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select('id', 'value', 'label')->where('is_active', true);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
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

    public function createRecord(array $payload): MediaType|Exception
    {
        try {
            return $this->create([
                'value' => $payload['value'],
                'label' => $payload['label'],
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
                    'media' => function ($query) {
                        $query->select(
                            'id',
                            'content_id',
                            'internal_path',
                            'external_path'
                        )->with([
                            'content' => function ($query) {
                                $query->select('id', 'title');
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

    public function updateRecord(array $payload, int $id): MediaType|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'value' => $payload['value'],
                'label' => $payload['label'],
                'is_active' => $payload['is_active'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): MediaType|Exception
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
