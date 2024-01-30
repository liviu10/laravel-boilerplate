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
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Resource
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
 * @property int $position
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getResourceTypes
 */
class Resource extends BaseModel
{
    use HasFactory, LogApiError, SoftDeletes;

    protected $table = 'set_resources';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

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
        'position',
        'user_id',
    ];

    protected $resources = [
        'resources.index',
        'resources.create',
        'resources.show',
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
            'position'      => 'integer',
            'user_id'       => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function resource_children()
    {
        return $this->hasMany('App\Models\ResourceChildren');
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
            if ($search && count($search)) {
                if (isset($search['type'])) {
                    if ($search['type'] === 'Menu' || $search['type'] === 'paginate') {
                        $query = $this->select(
                            'id',
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
                            'position',
                        )
                        ->where('type', $search['type'])
                        ->orderBy('position', 'ASC')
                        ->with([
                            'resource_children' => function ($query) {
                                $query->select('*')->orderBy('position', 'ASC');
                            }
                        ]);

                        $this->dynamicFilters($query, $search);
                    } else if ($search['type'] === 'API') {
                        $query = $this->select(
                            'id',
                            'type',
                            'path',
                            'is_active',
                            'requires_auth',
                        )
                        ->where('type', $search['type']);

                        if (isset($search['path'])) {
                            $query->where('path', $search['path']);
                        }
                    } else if ($search['type'] === 'restore') {
                        $query = $this->select(
                            'id',
                            'type',
                            'title',
                        )
                        ->onlyTrashed();
                    }
                } else {
                    $query = $this->select(
                        'id',
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
                        'position',
                    );

                    $this->dynamicFilters($query, $search);
                }
            } else {
                $query = $this->select(
                    'id',
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
                    'position',
                );
            }

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
     * Apply dynamic filters to the given query builder based on the provided search criteria.
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param array $search The search criteria to apply as filters.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder instance.
     */
    private function dynamicFilters(Builder $query, array $search): Builder {
        // TODO: Move this function to a trait so that it can be used in different models
        foreach ($search as $field => $value) {
            if ($field === 'id') {
                $query->where($field, $value);
            } else if ($field === 'is_active' || $field === 'requires_auth') {
                if ($value === true || $value === 'true' || $value === '1' || $value === 1) {
                    $query->where($field, true);
                } else {
                    $query->where($field, false);
                }
            } else {
                if ($field === 'path') {
                    $value = preg_replace('/\/(create|show|edit)(\/\d+)?/', '', $value);
                    $query->where($field, 'LIKE', $value);
                } else {
                    $query->where($field, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return $query;
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\Resource|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Resource|bool
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
                'position'      => $payload['position'],
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
     * @return \App\Models\Resource|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Resource|bool
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
                'position'      => $payload['position'],
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
    public function getResourceTypeOptions(): array
    {
        return $this->resourceTypeOptions;
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
