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
 * Class ConfigurationResource
 * @package App\Models

 * @property int $id
 * @property string $resource
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 */
class ConfigurationResource extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'set_configuration_resources';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'resource',
        'user_id',
    ];

    protected $statisticalIndicators = [
        'resource',
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
                'created_at',
                'updated_at'
            );

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
     * @return \App\Models\ConfigurationResource|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationResource|bool
    {
        try {
            $query = $this->create([
                'resource' => $payload['resource'],
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
                    'configuration_types' => function ($query) {
                        $query->select(
                            'id',
                            'name',
                            'is_active',
                            'configuration_resource_id',
                        )
                        ->where('is_active', true)
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
                                    'configuration_type_id',
                                );
                            },
                            'configuration_inputs' => function ($query) {
                                $query->select(
                                    'id',
                                    'field',
                                    'is_active',
                                    'is_filter',
                                    'is_model',
                                    'key',
                                    'name',
                                    'position',
                                    'type',
                                    'configuration_resource_id',
                                )
                                ->where('is_active', true)
                                ->with([
                                    'configuration_options' => function ($query) {
                                        $query->select(
                                            'id',
                                            'value',
                                            'label',
                                            'configuration_input_id',
                                        );
                                    }
                                ]);
                            },
                        ]);
                    },
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
     * @return \App\Models\ConfigurationResource|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationResource|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'resource' => $payload['resource'],
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
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields(): array
    {
        $fieldTypes = [
            'resource'  => 'text',
            'user_id'   => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
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
