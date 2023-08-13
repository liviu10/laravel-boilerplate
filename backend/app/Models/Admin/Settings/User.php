<?php

namespace App\Models\Admin\Settings;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ApiLogError;
use App\Traits\ApiDataModel;
use App\Traits\ApiFilters;

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
 * @property int $role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchCurrentAuthUser
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFilters
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ApiLogError, ApiDataModel, ApiFilters;

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
    protected $foreignKey = 'role_id';

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
        'full_name'      => 'text',
        'first_name'     => 'text',
        'last_name'      => 'text',
        'nickname'       => 'text',
        'email'          => 'email',
        'phone'          => 'tel',
        'password'       => 'password',
        'profile_image'  => 'file',
        'role_id'        => 'number',
    ];

    /**
     * The model filters.
     *
     * @var array<string, string>
     */
    protected $filters = [
        'id'         => 'number',
        'full_name'  => 'text',
        'nickname'   => 'text',
        'email'      => 'text',
        'created_at' => 'date',
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
        'id'                => 'integer',
        'email_verified_at' => 'datetime:d.m.Y H:i',
        'created_at'        => 'datetime:d.m.Y H:i',
        'updated_at'        => 'datetime:d.m.Y H:i',
        'role_id'           => 'integer',
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
     * Eloquent relationship between users and roles.
     *
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Admin\Settings\Role');
    }

    /**
     * Eloquent relationship between users and accepted domains.
     *
     */
    public function accepted_domains()
    {
        return $this->hasMany('App\Models\Admin\ApplicationSettings\AcceptedDomain');
    }

    /**
     * Eloquent relationship between users and contact subjects.
     *
     */
    public function contact_subjects()
    {
        return $this->hasMany('App\Models\Admin\Communication\ContactSubjects');
    }

    /**
     * Fetches the current authenticated user from the Auth facade,
     * excluding the password and email_verified_at fields.
     * @return \Illuminate\Support\Collection|boolean Returns a collection
     * of the authenticated user's attributes, excluding password and email_verified_at.
     * @throws \Exception|\Illuminate\Database\QueryException Returns an boolean if there was a problem fetching
     * the current authenticated user.
     */
    public function currentAuthUser()
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
     * Get all the records from the database.
     * @param  array  $search
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of records.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchAllRecords($search)
    {
        try
        {
            $query = $this->select('id', 'full_name', 'nickname', 'email', 'created_at');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            return $query->paginate(15);
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
     * Create a new record.
     * @param array $payload An associative array of values to create a new record.
     * @return \App\Models\User|bool Returns a record object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function createRecord($payload)
    {
        try
        {
            $this->create([
                'full_name'     => $payload['full_name'],
                'first_name'    => $payload['first_name'],
                'last_name'     => $payload['last_name'],
                'nickname'      => $payload['nickname'],
                'email'         => $payload['email'],
                'phone'         => $payload['phone'],
                'password'      => bcrypt($payload['password']),
                'profile_image' => $payload['profile_image'],
                'role_id'       => $payload['roles_id'],
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
     * Get record details from the database.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of record with their associated relation.
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
                            'role' => function ($query) {
                                $query->select('id', 'name', 'is_active')
                                    ->where('is_active', true)
                                    ->with('permissions');
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
     * Update an existing record.
     * @param array $payload An associative array of values to update the record.
     * @param int $id The ID of the record to update.
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
                'full_name'     => $payload['full_name'],
                'first_name'    => $payload['first_name'],
                'last_name'     => $payload['last_name'],
                'nickname'      => $payload['nickname'],
                'email'         => $payload['email'],
                'phone'         => $payload['phone'],
                'password'      => bcrypt($payload['password']),
                'profile_image' => $payload['profile_image'],
                'role_id'       => $payload['roles_id'],
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
     * Deletes a a record from the database.
     * @param int $id The ID of the record to delete.
     * @return bool Whether the record was successfully deleted.
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

    public function getDataModel()
    {
        $dataModelOptions = [
            'first_name' => [
                'name'        => 'First name',
                'is_required' => true
            ],
            'last_name' => [
                'name'        => 'Last name',
                'is_required' => true
            ],
            'nickname' => [
                'name'        => 'Nickname',
                'is_required' => true
            ],
            'email' => [
                'name'        => 'Email address',
                'is_required' => true
            ],
            'phone' => [
                'name'        => 'Phone number',
                'is_required' => true
            ],
            'password' => [
                'name'        => 'Password',
                'is_required' => true
            ],
            'profile_image' => [
                'name'        => 'Profile image',
                'is_required' => true
            ],
        ];

        return $this->handleApiDataModel($this->fillable, $dataModelOptions);
    }

    /**
     * Get the filters that can be applied to the records.
     * The method returns an array of filter options
     * that can be used to filter the records.
     * @return array An array of filter options.
     */
    public function getFilters()
    {
        $filterNames = [
            'id'         => 'Filter by ID',
            'full_name'  => 'Filter by full name',
            'nickname'   => 'Filter by nickname',
            'email'      => 'Filter by email',
            'created_at' => 'Filter by joined date',
        ];

        return $this->handleApiFilters($this->filters, $filterNames);
    }
}
