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
 * Class Role
 * @package App\Models

 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property string $text_color
 * @property string $slug
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 * @method fetchUserRoles
 * @method fetchClientRole
 */
class Role extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'bg_color',
        'text_color',
        'slug',
        'is_active',
    ];

    protected $statisticalIndicators = [
        'is_active',
    ];

    protected $resources = [
        'roles.index',
        'roles.create',
        'roles.show',
        'roles.update',
        'roles.destroy',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission');
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
            $query = $this->select('id', 'name', 'slug', 'is_active');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'is_active') {
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
     * @return \App\Models\Role|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Role|bool
    {
        try {
            $query = $this->create([
                'name'         => $payload['name'],
                'description'  => $payload['description'],
                'bg_color'     => $payload['bg_color'],
                'text_color'   => $payload['text_color'],
                'slug'         => $payload['slug'],
                'is_active'    => $payload['is_active'],
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
                    'permissions' => function ($query) {
                        $query->select('id', 'name', 'role_id')
                            ->where('is_active', true);
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
     * @return \App\Models\Role|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Role|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'name'         => $payload['name'],
                'description'  => $payload['description'],
                'bg_color'     => $payload['bg_color'],
                'text_color'   => $payload['text_color'],
                'slug'         => $payload['slug'],
                'is_active'    => $payload['is_active'],
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
            'name'        => 'text',
            'description' => 'text',
            'bg_color'    => 'text',
            'text_color'  => 'text',
            'slug'        => 'text',
            'is_active'   => 'boolean',
        ];

        return $this->handleFilterAvailableFields($fieldTypes);
    }

    /**
     * Fetches user roles from the database.
     * This function retrieves user roles by querying the database and returning
     * an array containing role information.
     * @return array|bool An array containing role data if successful, or `false` on failure.
     */
    public function fetchUserRoles(): array
    {
        try {
            $query = $this->select('id', 'name', 'slug')->get()->toArray();

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
     * Fetches a specific client role from the database.
     * This function retrieves a client role with a specified ID from the database
     * and returns it as an array containing role information.
     * @return array|bool An array containing role data if successful, or `false` on failure.
     */
    public function fetchSubscriberRole(): array
    {
        try {
            $query = $this->select('id')
                    ->where('id', 6)
                    ->get()
                    ->pluck('id')
                    ->toArray()[0];

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
     * Fetches a specific role from the database.
     * This function retrieves a role with a specified ID from the database
     * and returns it as an array containing role information.
     * @return array|bool An array containing role data if successful, or `false` on failure.
     */
    public function fetchSingleRole(int $id): array
    {
        try {
            $query = $this->select('id', 'name')
                ->where('id', $id)
                ->get()
                ->toArray()[0];

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
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}
