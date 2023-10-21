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
 * Class Permission
 * @package App\Models

 * @property int $id
 * @property string $name
 * @property string $description
 * @property boolean $is_active
 * @property boolean $need_approval
 * @property int $role_id
 * @property int $reports_to_role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class Permission extends BaseModel
{
    use HasFactory, LogApiError;

    protected $table = 'set_permissions';

    protected $foreignKey = 'role_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'need_approval',
        'role_id',
        'reports_to_role_id',
    ];

    protected $attributes = [
        'is_active' => false,
        'need_approval' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'role_id' => 'integer',
            'reports_to_role_id' => 'integer',
        ]);
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
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
                'is_active',
                'need_approval'
            );

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
     * @return \App\Models\Permission|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Permission|bool
    {
        try {
            $query = $this->create([
                'name'               => $payload['name'],
                'description'        => $payload['description'],
                'is_active'          => $payload['is_active'],
                'need_approval'      => $payload['need_approval'],
                'reports_to_role_id' => $payload['reports_to_role_id'],
                'role_id'            => $payload['role_id'],
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
                    'role' => function ($query) {
                        $query->select('id', 'name');
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
     * @return \App\Models\Permission|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Permission|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'name'               => $payload['name'],
                'description'        => $payload['description'],
                'is_active'          => $payload['is_active'],
                'need_approval'      => $payload['need_approval'],
                'reports_to_role_id' => $payload['reports_to_role_id'],
                'role_id'            => $payload['role_id'],
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
     * Check if a user with a given role has a specific permission.
     * @param string $permissionName The name of the permission to check.
     * @param int|null $roleId The ID of the role to check for permission (nullable).
     * @return \Illuminate\Support\Collection|bool Returns true if the user has the permission, false otherwise.
     */
    public function checkPermission(string $permissionName, int|null $roleId): Collection|bool
    {
        try {
            $result = $this->select('id', 'name', 'is_active', 'need_approval', 'role_id', 'reports_to_role_id')
                ->where('name', $permissionName)
                ->where('role_id', $roleId)
                ->with([
                    'role' => function ($query) {
                        $query->select('id', 'name');
                    }
                ])
                ->get();

            return $result;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }
}
