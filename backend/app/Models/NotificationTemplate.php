<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ApiHandleFilter;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class NotificationTemplate
 * @package App\Models
 *
 * @property int $id
 * @property int $notification_type_id
 * @property int $notification_condition_id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NotificationTemplate extends Model
{
    use ApiHandleFilter;

    protected $fillable = [
        'notification_type_id',
        'notification_condition_id',
        'title',
        'content',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'notification_type_id' => 'integer',
        'notification_condition_id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function notification_type(): BelongsTo
    {
        return $this->belongsTo('App\Models\NotificationType');
    }

    public function notification_condition(): BelongsTo
    {
        return $this->belongsTo('App\Models\NotificationCondition');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function general(): MorphOne
    {
        return $this->morphOne(General::class, 'generalable');
    }

    /**
     * Get all the records from the database.
     *
     * @param array $search
     * @return Collection|LengthAwarePaginator|Exception
     * @throws Exception
     */
    public function fetchAllRecords(array $search = []): Collection|LengthAwarePaginator|Exception
    {
        try {
            $query = $this->select(
                'id',
                'notification_type_id',
                'notification_condition_id',
                'title',
                'user_id'
            );

            $this->handleApiFilter($query, $search);

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Create a new record.
     *
     * @param array $payload
     * @return User|Exception
     * @throws Exception
     */
    public function createRecord(array $payload): User|Exception
    {
        try {
            return $this->create([
                'notification_type_id' => $payload['notification_type_id'],
                'notification_condition_id' => $payload['notification_condition_id'],
                'title' => $payload['title'],
                'content' => $payload['content'],
                'user_id' => $payload['user_id'],
            ]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Get record details from the database.
     *
     * @param string $id
     * @param string|null $type
     * @return Collection|Exception
     * @throws Exception
     */
    public function fetchSingleRecord(string $id, string|null $type = null): Collection|Exception
    {
        try {
            $query = $this->select('*')
                ->where('id', '=', $id)
                ->with([
                    'notification_type_id' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'notification_condition_id' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'user_id' => function ($query) {
                        $query->select('id', 'full_name');
                    },
                ]);;

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Update an existing record.
     *
     * @param array $payload
     * @param string $id
     * @return User|Exception
     * @throws Exception
     */
    public function updateRecord(array $payload, string $id): User|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'notification_type_id' => $payload['notification_type_id'],
                'notification_condition_id' => $payload['notification_condition_id'],
                'title' => $payload['title'],
                'content' => $payload['content'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Deletes a record from the database.
     *
     * @param string $id
     * @return bool|Exception
     * @throws Exception
     */
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
