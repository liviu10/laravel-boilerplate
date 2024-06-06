<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Carbon\Carbon;

/**
 * Class GoogleMaps
 * @package App\Models
 */
class GoogleMaps extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'address',
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
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'description',
                'address',
                'user_id',
            )
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'full_name', 'email');
                    }
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
                $item->makeHidden('user_id');
            });

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): GoogleMaps|Exception
    {
        try {
            return $this->create([
                'description' => $payload['description'],
                'address' => $payload['address'],
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
                    'user' => function ($query) {
                        $query->select('id', 'full_name', 'email');
                    }
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): GoogleMaps|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'description' => $payload['description'],
                'address' => $payload['address'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): GoogleMaps|Exception
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
