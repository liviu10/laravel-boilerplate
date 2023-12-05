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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class General
 * @package App\Models

 * @property int $id
 * @property string $type
 * @property string $label
 * @property string $value
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 * @method getGeneralTypeOptions
 */
class General extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError, SoftDeletes;

    protected $table = 'set_generals';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'type',
        'label',
        'value',
        'user_id',
    ];

    protected $resources = [
        'generals.index',
        'generals.create',
        'generals.show',
        'generals.update',
        'generals.destroy',
    ];

    protected $generalTypeOptions = [
        'General',
        'Writing',
        'Reading',
        'Discussion',
        'Media',
        'Performance',
        'Notifications',
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
            $query = $this->all();

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'type') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } elseif ($type === 'restore') {
                return $query->onlyTrashed()->select('id', 'type', 'value', 'label')->get();
            } else {
                return $query;
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
     * @return \App\Models\General|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): General|bool
    {
        try {
            $query = $this->create([
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
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
     * @return \App\Models\General|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): General|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
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
            'type'    => 'text',
            'label'   => 'text',
            'value'   => 'text',
            'user_id' => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the general type options.
     * @return array An array containing the general type options.
     */
    public function getGeneralTypeOptions(): array
    {
        return $this->generalTypeOptions;
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
