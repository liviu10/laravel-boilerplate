<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Notification
 * @package App\Models

 * @property int $id
 * @property string $type
 * @property string $conditions
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 * @method getNotificationTypeOptions
 * @method getNotificationConditionOptions
 */
class Notification extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'notifications';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'type',
        'condition',
        'title',
        'content',
        'user_id',
    ];

    protected $resources = [
        'notifications.index',
        'notifications.create',
        'notifications.show',
        'notifications.update',
        'notifications.destroy',
    ];

    protected $notificationTypeOptions = [
        'SMS',
        'Email',
    ];

    protected $notificationConditionOptions = [
        'Read',
        'Create',
        'Show',
        'Update',
        'Delete',
        'Restore',
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'user_id' => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Fetch records from the database based on optional search criteria.
     * @param array $search An associative array of search criteria (field => value).
     * @param string|null $type The fetch type: 'paginate'for paginated results or null for a collection.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|bool
     * A paginated result, a collection, or `false` if an error occurs.
     */
    public function fetchAllRecords(array $search = [], string|null $type = null): LengthAwarePaginator|Collection|bool
    {
        try {
            $query = $this->select('*');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\Notification|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Notification|bool
    {
        try {
            $query = $this->create([
                'type'      => $payload['type'],
                'condition' => $payload['condition'],
                'title'     => $payload['title'],
                'content'   => $payload['content'],
                'user_id'   => $payload['user_id'],
            ]);

            return $query;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Fetch a single record from the database by its ID.
     * @param int $id The unique identifier of the record to fetch.
     * @param string|null $type The fetch type: 'relation' to include
     * related data or null for just the record.
     * @return \Illuminate\Support\Collection|bool The fetched record or
     * related data as a Collection, or `false` if an error occurs.
     */
    public function fetchSingleRecord(int $id, string|null $type = null): Collection|bool
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            if ($type === 'relation') {
                $query->with([
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

                return $query->get();
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Update a record in the database.
     * @param array $payload An associative array containing the updated record data.
     * @param int $id The unique identifier of the record to update.
     * @return \App\Models\Notification|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Notification|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'      => $payload['type'],
                'condition' => $payload['condition'],
                'title'     => $payload['title'],
                'content'   => $payload['content'],
                'user_id'   => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields(): array
    {
        $fieldTypes = [
            'type'      => 'text',
            'condition' => 'text',
            'title'     => 'text',
            'content'   => 'text',
            'user_id'   => 'number',
        ];

        $excludedFields = ['content', 'user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the notification type options.
     * @return array An array containing the notification type options.
     */
    public function getNotificationTypeOptions(): array
    {
        return $this->notificationTypeOptions;
    }

    /**
     * Get the notification condition options.
     * @return array An array containing the notification condition options.
     */
    public function getNotificationConditionOptions(): array
    {
        return $this->notificationConditionOptions;
    }

    /**
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}
