<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\QueryException;

/**
 * Class ConfigurationColumn
 * @package App\Models

 * @property int $id
 * @property string $align
 * @property string $field
 * @property string $header_style
 * @property string $label
 * @property string $name
 * @property string $position
 * @property string $style
 * @property int $configuration_resource_id
 * @property int $configuration_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method createRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 */
class ConfigurationColumn extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'set_configuration_columns';

    protected $foreignKey = 'configuration_resource_id';

    protected $foreignKeyType = 'int';

    protected $configurationTypeForeignKey = 'configuration_type_id';

    protected $configurationTypeForeignKeyType = 'int';

    protected $fillable = [
        'align',
        'field',
        'header_style',
        'label',
        'name',
        'position',
        'style',
        'configuration_resource_id',
        'configuration_type_id',
    ];

    protected $statisticalIndicators = [];

    protected $resources = [
        'configuration-types.create',
        'configuration-types.update',
        'configuration-types.destroy',
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
     * @return \App\Models\ConfigurationColumn|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationColumn|bool
    {
        try {
            $query = $this->create([
                'align'                     => $payload['align'],
                'field'                     => $payload['field'],
                'header_style'              => $payload['header_style'],
                'label'                     => $payload['label'],
                'name'                      => $payload['name'],
                'position'                  => $payload['position'],
                'style'                     => $payload['style'],
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
     * @return \App\Models\ConfigurationColumn|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationColumn|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'align'                     => $payload['align'],
                'field'                     => $payload['field'],
                'header_style'              => $payload['header_style'],
                'label'                     => $payload['label'],
                'name'                      => $payload['name'],
                'position'                  => $payload['position'],
                'style'                     => $payload['style'],
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
