<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ConfigurationType
 * @package App\Models

 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property int $configuration_resource_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method createRecord
 * @method updateRecord
 * @method deleteRecord
 */
class ConfigurationType extends BaseModel
{
    use HasFactory, LogApiError;

    protected $table = 'set_configuration_types';

    protected $foreignKey = 'configuration_resource_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'name',
        'is_active',
        'configuration_resource_id',
    ];

    protected $resources = [
        'configuration-types.create',
        'configuration-types.show',
        'configuration-types.update',
        'configuration-types.destroy',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'configuration_resource_id' => 'integer',
        ]);
    }

    public function configuration_resource()
    {
        return $this->belongsTo('App\Models\ConfigurationResource');
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
                'name',
                'is_active'
            );

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'is_active' || $field === 'configuration_resource_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'restore') {
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
     * @return \App\Models\ConfigurationType|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationType|bool
    {
        try {
            $query = $this->create([
                'name'                      => $payload['name'],
                'is_active'                 => $payload['is_active'],
                'configuration_resource_id' => $payload['configuration_resource_id'],
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
     * Fetch a record from the database by its ID.
     * @param int $id The unique identifier of the record to fetch.
     * @return \Illuminate\Support\Collection|bool The fetched record or
     * related data as a Collection, or `false` if an error occurs.
     */
    public function fetchSingleRecord(int $id): Collection|bool
    {
        try {
            $query = $this->select('*')->where('id', '=', $id)
                ->with([
                    'configuration_columns' => function ($query) {
                        $query->select(
                            'id',
                            'align',
                            'field',
                            'header_style',
                            'label',
                            'name',
                            'position',
                            'style',
                            'configuration_type_id'
                        );
                    },
                    'configuration_inputs' => function ($query) {
                        $query->select(
                            'id',
                            'accept',
                            'field',
                            'is_active',
                            'is_filter',
                            'is_model',
                            'key',
                            'name',
                            'position',
                            'type',
                            'configuration_type_id'
                        );
                    }
                ]);

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
     * @return \App\Models\ConfigurationType|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationType|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'name'                      => $payload['name'],
                'is_active'                 => $payload['is_active'],
                'configuration_resource_id' => $payload['configuration_resource_id'],
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
}
