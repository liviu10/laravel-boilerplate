<?php

namespace App\Models\Admin\Settings;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ApiLogError;

/**
 * Class User
 * @package App\Models\Admin\Settings
 *
 * @property int $id
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property string $email
 * @property string $phone
 * @property string $email_verified_at
 * @property string $password
 * @property string $profile_image
 * @property int $user_role_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchCurrentAuthUser
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ApiLogError;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The foreign key associated with the table.
     *
     * @var string
     */
    protected $foreignKey = 'user_role_type_id';

    /**
     * The data type of the database table foreign key.
     *
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'phone',
        'password',
        'profile_image',
        'user_role_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_role_type_id' => 'integer',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Eloquent relationship between users and user role types.
     *
     */
    public function user_role_type()
    {
        return $this->belongsTo('App\Models\Admin\Settings\UserRoleType');
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
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
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
    public function fetchAllRecords()
    {
        try
        {
            return $this->select('id', 'full_name', 'nickname', 'email')->paginate(15);
        }
        catch (\Exception $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
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
    public function createRecord($payload)
    {
        try
        {
            $this->create([
                'full_name'         => $payload['full_name'],
                'first_name'        => $payload['first_name'],
                'last_name'         => $payload['last_name'],
                'nickname'          => $payload['nickname'],
                'email'             => $payload['email'],
                'phone'             => $payload['phone'],
                'password'          => bcrypt($payload['password']),
                'profile_image'     => $payload['profile_image'],
                'user_role_type_id' => $payload['user_role_type_id'],
            ]);

            return True;
        }
        catch (\Exception $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
    }

    /**
     * Get user details with their user role type information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of users with their associated user role type.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchSingleRecord($id)
    {
        try
        {
            return $this->select('*')
                        ->where('id', '=', $id)
                        ->with([
                            'user_role_type' => function ($query) {
                                $query->select('id', 'user_role_name', 'is_active')->where('is_active', true);
                            }
                        ])
                        ->get();
        }
        catch (\Exception $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
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
    public function updateRecord($payload, $id)
    {
        try
        {
            $this->find($id)->update([
                'full_name'         => $payload['full_name'],
                'first_name'        => $payload['first_name'],
                'last_name'         => $payload['last_name'],
                'nickname'          => $payload['nickname'],
                'email'             => $payload['email'],
                'phone'             => $payload['phone'],
                'password'          => bcrypt($payload['password']),
                'profile_image'     => $payload['profile_image'],
                'user_role_type_id' => $payload['user_role_type_id'],
            ]);

            return True;
        }
        catch (\Exception $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
    }

    /**
     * Deletes a user from the database.
     * @param int $id The ID of the user to delete.
     * @return bool Whether the user was successfully deleted.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during deletion.
     */
    public function deleteRecord(int $id)
    {
        try
        {
            $this->find($id)->delete();

            return true;
        }
        catch (\Exception $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
            return false;
        }
    }
}
