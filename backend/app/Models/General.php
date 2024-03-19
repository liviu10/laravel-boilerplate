<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\ApiHandleFilter;

/**
 * Class General
 * @package App\Models
 *
 * @property int $id
 * @property string generalable_id
 * @property string generalable_type
 * @property string value
 * @property string label
 * @property string key
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class General extends Model
{
    use ApiHandleFilter;

    protected $fillable = [
        'generalable_id',
        'generalable_type',
        'value',
        'label',
        'key',
    ];

    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function generalable()
    {
        return $this->morphTo();
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
            $query = $this->select(
                'id',
                'generalable_id',
                'generalable_type',
                'value',
                'label',
                'key'
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
     * @return NotificationCondition|Exception
     * @throws Exception
     */
    public function createRecord(array $payload): General|Exception
    {
        try {
            return $this->create([
                'generalable_id' => $payload['generalable_id'],
                'generalable_type' => $payload['generalable_type'],
                'value' => $payload['value'],
                'label' => $payload['label'],
                'key' => $payload['key'],
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
    public function updateRecord(array $payload, string $id): General|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'generalable_id' => $payload['generalable_id'],
                'generalable_type' => $payload['generalable_type'],
                'value' => $payload['value'],
                'label' => $payload['label'],
                'key' => $payload['key'],
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
        abort(405);
    }

    /**
     * Handle fetch model names operation.
     *
     * @return array
     */
    public function fetchModelNames(): array
    {
        return [];
    }
}
