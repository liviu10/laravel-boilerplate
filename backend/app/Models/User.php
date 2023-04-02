<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\LogErrors;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property int $user_role_type_id
 * @property string $profile_image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\UserRoleType $user_role_type
 * @method fetchCurrentAuthUser
 * @method fetchAllUsers
 * @method registerUser
 * @method updateUserRole
 * @method updateUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogErrors;

    /**
     * The name of the database table associated with the model.
     * @var string
     */
    protected $table = 'users';

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
     * The name of the foreign key column in the associated database table.
     * @var string
     */
    protected $foreignKey = 'user_role_type_id';

    /**
     * The data type of the foreign key column in the associated database table.
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The list of attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'password',
        'user_role_type_id',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays and JSON serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user role type that this user belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_role_type()
    {
        return $this->belongsTo('App\Models\UserRoleType');
    }

    /**
     * Fetches the current authenticated user from the Auth facade,
     * excluding the password and email_verified_at fields.
     * @return \Illuminate\Support\Collection|boolean Returns a collection
     * of the authenticated user's attributes, excluding password and email_verified_at.
     * @throws \Exception|\Illuminate\Database\QueryException Returns an boolean if there was a problem fetching
     * the current authenticated user.
     */
    public function fetchCurrentAuthUser()
    {
        try
        {
            return collect(Auth::user())->except([ 'email_verified_at', 'password' ]);
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
     * Get all users with their user role type information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of users with their associated user role type.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchAllUsers()
    {
        try
        {
            return $this->select(
                'id',
                'full_name',
                'first_name',
                'last_name',
                'nickname',
                'email',
                'email_verified_at',
                'user_role_type_id'
            )->with([
                'user_role_type' => function ($query) {
                    $query->select(
                        'id',
                        'user_role_name'
                    );
                }
            ])->paginate(15);
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
     * Register a new user.
     * @param array $payload An associative array of values to register the user.
     * @return \App\Models\User|bool Returns a user object if the register was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during registration.
     */
    public function registerUser(array $payload)
    {
        try
        {
            $user = $this->create([
                'full_name'         => $payload['full_name'],
                'first_name'        => $payload['first_name'],
                'last_name'         => $payload['last_name'],
                'nickname'          => $payload['nickname'],
                'email'             => $payload['email'],
                'password'          => Hash::make($payload['password']),
                'user_role_type_id' => 5,
            ]);
            return $user;
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
     * Update the user role of a specific user.
     * @param array $payload An associative array of values to update the user role.
     * @param int $id The ID of the user to update.
     * @return bool Returns true if the update was successful,
     * or an boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the update.
     */
    public function updateUserRole(array $payload, int $id)
    {
        try
        {
            $this->find($id)->update([
                'user_role_type_id' => $payload['user_role_type_id'],
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

    /**
     * Update the user profile information.
     * @param array $payload An associative array of values to update the user.
     * @param int $id The ID of the user to update.
     * @return bool Returns true if the update was successful,
     * or an boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the update.
     */
    public function updateUser(array $payload, int $id)
    {
        try
        {
            $this->find($id)->update($payload);
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
