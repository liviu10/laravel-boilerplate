<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogErrors;

/**
 * Class UserRoleType
 * @package App\Models
 *
 * @property int $id
 * @property string $user_role_name
 * @property string|null $user_role_description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method fetchAllUserRoleTypes
 * @method fetchAllUserRoleTypeNames
 * @method saveUserRole
 * @method updateUserRole
 */
class UserRoleType extends Model
{
    use HasFactory, LogErrors;

    /**
     * The name of the database table associated with the model.
     * @var string
     */
    protected $table = 'user_role_types';

    /**
     * The name of the primary key column in the associated database table.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the primary key column in the associated database table.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The list of attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_role_name',
        'user_role_description',
        'is_active',
    ];

    /**
     * The default attribute values for the model.
     * @var array
     */
    protected $attributes = [
        'is_active' => false,
    ];

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the users that belong to this user role type.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get all user role types information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of user role types with their associated information.
     * If an error occurs during retrieval, an boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the retrieval.
     */
    public function fetchAllUserRoleTypes()
    {
        try
        {
            return $this->select(
                'id',
                'user_role_name',
                'user_role_description',
                'is_active',
                'created_at',
                'updated_at'
            )->paginate(15);
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }

    /**
     * Get all user role type names information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of user role type names with their associated information.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the retrieval.
     */
    public function fetchAllUserRoleTypeNames()
    {
        try
        {
            return $this->select(
                'id',
                'user_role_name'
            )->where('is_active', true)->get();
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }

    /**
     * Create a new user role.
     * @param array $payload An associative array of values to create a new user role.
     * @return \App\Models\UserRoleType|bool Returns a user role object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during registration.
     */
    // public function saveUserRole(array $payload)
    // {
    //     try
    //     {
    //         $userRole = $this->create([
    //             'user_role_name'        => $payload['user_role_name'],
    //             'user_role_description' => $payload['user_role_description'],
    //             'is_active'             => $payload['is_active'],
    //         ]);
    //         return $userRole;
    //     }
    //     catch (\Exception $exception)
    //     {
    //         $this->logError($exception);
    //         return false;
    //     }
    //     catch (\Illuminate\Database\QueryException $exception)
    //     {
    //         $this->logQueryError($exception);
    //         return false;
    //     }
    // }

    /**
     * Update the user role.
     * @param array $payload An associative array of values to update the user role.
     * @param int $id The ID of the user role to update.
     * @return bool Returns true if the update was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the update.
     */
    public function updateUserRole(array $payload, int $id)
    {
        try
        {
            $this->find($id)->update([
                'user_role_name'        => $payload['user_role_name'],
                'user_role_description' => $payload['user_role_description'],
                'is_active'             => $payload['is_active'],
            ]);
            return True;
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }
}
