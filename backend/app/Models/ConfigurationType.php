<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\QueryException;

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
 * @method getFields
 */
class ConfigurationType extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'set_configuration_types';

    protected $foreignKey = 'configuration_resource_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'name',
        'is_active',
        'configuration_resource_id',
    ];

    protected $statisticalIndicators = [];

    protected $resources = [
        'configuration-types.create',
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
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields(): array
    {
        $fieldTypes = [
            'resource'  => 'text',
            'configuration_resource_id'   => 'number',
        ];

        $excludedFields = ['configuration_resource_id'];

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