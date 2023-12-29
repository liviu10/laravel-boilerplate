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
 * Class ResourceChildren
 * @package App\Models

 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $component
 * @property string $layout
 * @property string $title
 * @property string $caption
 * @property string $icon
 * @property boolean $is_active
 * @property boolean $requires_auth
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getResourceChildrenTypes
 */
class ResourceChildren extends BaseModel
{
    use HasFactory, LogApiError;

    protected $table = 'set_resource_children';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $resourceForeignKey = 'resource_id';

    protected $resourceForeignKeyType = 'int';

    protected $fillable = [
        'type',
        'path',
        'name',
        'component',
        'layout',
        'title',
        'caption',
        'icon',
        'is_active',
        'requires_auth',
        'user_id',
        'resource_id',
    ];

    protected $resources = [
        'resources.create',
        'resources.update',
        'resources.destroy',
    ];

    protected $attributes = [
        'is_active'     => false,
        'requires_auth' => false,
    ];

    protected $resourceTypeOptions = [
        'Menu', 'API'
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'requires_auth' => 'boolean',
            'user_id'       => 'integer',
            'resource_id'   => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\ResourceChildren|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ResourceChildren|bool
    {
        try {
            $query = $this->create([
                'type'          => $payload['type'],
                'path'          => $payload['path'],
                'name'          => $payload['name'],
                'component'     => $payload['component'],
                'layout'        => $payload['layout'],
                'title'         => $payload['title'],
                'caption'       => $payload['caption'],
                'icon'          => $payload['icon'],
                'is_active'     => $payload['is_active'],
                'requires_auth' => $payload['requires_auth'],
                'user_id'       => $payload['user_id'],
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
     * @return \App\Models\ResourceChildren|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ResourceChildren|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'          => $payload['type'],
                'path'          => $payload['path'],
                'name'          => $payload['name'],
                'component'     => $payload['component'],
                'layout'        => $payload['layout'],
                'title'         => $payload['title'],
                'caption'       => $payload['caption'],
                'icon'          => $payload['icon'],
                'is_active'     => $payload['is_active'],
                'requires_auth' => $payload['requires_auth'],
                'user_id'       => $payload['user_id'],
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
     * Get the resource types.
     * @return array An array containing the resource types.
     */
    public function getResourceChildrenTypeOptions(): array
    {
        return $this->resourceTypeOptions;
    }

    /**
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResourceChildren(): array
    {
        return $this->resources;
    }
}
