<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ApiHandleFilter;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class NotificationCondition
 * @package App\Models
 *
 * @property int $id
 * @property string name
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NotificationCondition extends Model
{
    use ApiHandleFilter;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function notification_templates(): HasMany
    {
        return $this->hasMany('App\Models\NotificationTemplate');
    }

    public function general(): MorphOne
    {
        return $this->morphOne(General::class, 'generalable');
    }

    /**
     * Get all the records from the database.
     *
     * @param array $search
     * @return Collection|Exception
     * @throws Exception
     */
    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select('id', 'name');

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
     * @return NotificationCondition|Exception
     * @throws Exception
     */
    public function createRecord(array $payload): NotificationCondition|Exception
    {
        try {
            return $this->create([
                'name' => $payload['name'],
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
            $query = $this->select('*')->where('id', '=', $id);

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
     * @return NotificationCondition|Exception
     * @throws Exception
     */
    public function updateRecord(array $payload, string $id): NotificationCondition|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'name' => $payload['name'],
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
