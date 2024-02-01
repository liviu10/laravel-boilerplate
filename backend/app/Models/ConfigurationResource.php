<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ConfigurationResource
 * @package App\Models

 * @property int $id
 * @property string $resource
 * @property string $key
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class ConfigurationResource extends BaseModel
{
    use HasFactory, LogApiError, SoftDeletes;

    protected $table = 'set_configuration_resources';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'resource',
        'key',
        'user_id',
    ];

    protected $resources = [
        'configuration-resources.index',
        'configuration-resources.create',
        'configuration-resources.show',
        'configuration-resources.update',
        'configuration-resources.destroy',
    ];

    protected function getCastAttributes(): array
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

    public function configuration_types()
    {
        return $this->hasMany('App\Models\ConfigurationType');
    }

    public function configuration_columns()
    {
        return $this->hasMany('App\Models\ConfigurationColumn');
    }

    public function configuration_inputs()
    {
        return $this->hasMany('App\Models\ConfigurationInput');
    }

    public function configuration_options()
    {
        return $this->hasMany('App\Models\ConfigurationOption');
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
            $query = $this->select(
                'id',
                'resource',
                'key',
                'created_at',
                'updated_at'
            );

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
                        $query->where($field, '=', $value);
                    } else {
                        if ($field === 'key') {
                            $query->where($field, 'LIKE', $value);
                        } else {
                            $query->where($field, 'LIKE', '%' . $value . '%');
                        }
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } elseif ($type === 'restore') {
                return $query->onlyTrashed()->select('id', 'resource')->get();
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
     * @return \App\Models\ConfigurationResource|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationResource|bool
    {
        try {
            $query = $this->create([
                'resource' => $payload['resource'],
                'key'      => $payload['key'],
                'user_id'  => $payload['user_id'],
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
     * @return \Illuminate\Support\Collection|bool The fetched record or
     * related data as a Collection, or `false` if an error occurs.
     */
    public function fetchSingleRecord(int $id): Collection|bool
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            return $query->get();
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
     * @return \App\Models\ConfigurationResource|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationResource|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'resource' => $payload['resource'],
                'key'      => $payload['key'],
                'user_id'  => $payload['user_id'],
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
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * Fetches the configuration resource ID based on the given ID.
     * @param int $id The ID to retrieve the configuration resource ID.
     * @return \Illuminate\Support\Collection|bool Returns a collection containing the configuration resource ID if successful,
     * or `false` if an exception occurs during the query.
     */
    public function fetchConfigurationResourceId(int $id): Collection|bool
    {
        try {
            $query = $this->select('id')->where('id', '=', $id);

            return $query->get();
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }
}
