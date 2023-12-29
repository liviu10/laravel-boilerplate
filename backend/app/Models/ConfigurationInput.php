<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\QueryException;

/**
 * Class ConfigurationInput
 * @package App\Models

 * @property int $id
 * @property string $accept
 * @property string $field
 * @property bool $is_active
 * @property bool $is_filter
 * @property bool $is_model
 * @property string $key
 * @property string $name
 * @property string $position
 * @property string $type
 * @property int $configuration_resource_id
 * @property int $configuration_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method createRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 */
class ConfigurationInput extends BaseModel
{
    use HasFactory, LogApiError;

    protected $table = 'set_configuration_inputs';

    protected $foreignKey = 'configuration_resource_id';

    protected $foreignKeyType = 'int';

    protected $configurationTypeForeignKey = 'configuration_type_id';

    protected $configurationTypeForeignKeyType = 'int';

    protected $fillable = [
        'accept',
        'field',
        'is_active',
        'is_filter',
        'is_model',
        'key',
        'name',
        'position',
        'type',
        'configuration_resource_id',
        'configuration_type_id',
    ];

    protected $resources = [
        'configuration-inputs.create',
        'configuration-inputs.update',
        'configuration-inputs.destroy',
    ];

    protected $attributes = [
        'is_active' => false,
        'is_filter' => false,
        'is_model'  => false,
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'configuration_resource_id' => 'integer',
            'configuration_type_id'     => 'integer',
        ]);
    }

    public function configuration_resource()
    {
        return $this->belongsTo('App\Models\ConfigurationResource');
    }

    public function configuration_type()
    {
        return $this->belongsTo('App\Models\ConfigurationType');
    }

    public function configuration_options()
    {
        return $this->hasMany('App\Models\ConfigurationOption');
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\ConfigurationInput|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationInput|bool
    {
        try {
            $query = $this->create([
                'accept'                    => $payload['accept'],
                'field'                     => $payload['field'],
                'is_active'                 => $payload['is_active'],
                'is_filter'                 => $payload['is_filter'],
                'is_model'                  => $payload['is_model'],
                'key'                       => $payload['key'],
                'name'                      => $payload['name'],
                'position'                  => $payload['position'],
                'type'                      => $payload['type'],
                'configuration_resource_id' => $payload['configuration_resource_id'],
                'configuration_type_id'     => $payload['configuration_type_id'],
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
     * @return \App\Models\ConfigurationInput|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationInput|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'field'                     => $payload['field'],
                'is_active'                 => $payload['is_active'],
                'is_filter'                 => $payload['is_filter'],
                'is_model'                  => $payload['is_model'],
                'key'                       => $payload['key'],
                'name'                      => $payload['name'],
                'position'                  => $payload['position'],
                'type'                      => $payload['type'],
                'configuration_resource_id' => $payload['configuration_resource_id'],
                'configuration_type_id'     => $payload['configuration_type_id'],
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
