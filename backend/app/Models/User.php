<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

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
    use HasApiTokens,
        HasFactory,
        Notifiable,
        FilterAvailableFields,
        LogApiError;

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The foreign key associated with the table.
     * @var string
     */
    protected $foreignKey = 'role_id';

    /**
     * The data type of the database table foreign key.
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The attributes that are mass assignable.
     * @var array<string>
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
        'role_id',
    ];

    /**
     * The statistical indicators.
     * @var array<string>
     */
    protected $statisticalIndicators = [
        'phone',
        'profile_image',
        'email_verified_at',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
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
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Eloquent relationship between users and roles.
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Eloquent relationship between users and accepted domains.
     */
    public function accepted_domains()
    {
        return $this->hasMany('App\Models\AcceptedDomain');
    }

    /**
     * Eloquent relationship between users and generals.
     */
    public function generals()
    {
        return $this->hasMany('App\Models\General');
    }

    /**
     * Eloquent relationship between users and notifications.
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * Eloquent relationship between users and contact responses.
     */
    public function contact_responses()
    {
        return $this->hasMany('App\Models\ContactResponse');
    }

    /**
     * Eloquent relationship between users and contact subjects.
     */
    public function contact_subjects()
    {
        return $this->hasMany('App\Models\ContactSubject');
    }

    /**
     * Eloquent relationship between users and newsletter campaigns.
     */
    public function newsletter_campaigns()
    {
        return $this->hasMany('App\Models\NewsletterCampaign');
    }

    /**
     * Eloquent relationship between users and contents.
     */
    public function contents()
    {
        return $this->hasMany('App\Models\Content');
    }

    /**
     * Eloquent relationship between users and medias.
     */
    public function medias()
    {
        return $this->hasMany('App\Models\Media');
    }

    /**
     * Eloquent relationship between users and tags.
     */
    public function tags()
    {
        return $this->hasMany('App\Models\Tags');
    }

    /**
     * Fetches the current authenticated user from the Auth facade,
     * excluding the password and email_verified_at fields.
     * @return \Illuminate\Support\Collection|boolean Returns a collection
     * of the authenticated user's attributes, excluding password and email_verified_at.
     * @throws \Exception|\Illuminate\Database\QueryException Returns an boolean if there was a problem fetching
     * the current authenticated user.
     */
    // TODO: Improve this when finishing with the login system
    // public function currentAuthUser()
    // {
    //     try {
    //         return collect(Auth::user())->except(['email_verified_at', 'password']);
    //     } catch (\Exception $exception) {
    //         $this->LogApiError($exception);
    //         return false;
    //     } catch (\Illuminate\Database\QueryException $exception) {
    //         $this->LogApiError($exception);
    //         return false;
    //     }
    // }

    /**
     * Get all the records from the database.
     * @param  array  $search
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of records.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchAllRecords($search = [], string|null $type = null)
    {
        try {
            $query = $this->select('id', 'full_name', 'nickname', 'email', 'created_at');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'role_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } elseif ($type === 'statistics') {
                return $this->select('*')->get();
            } else {
                return $query->get();
            }
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
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
        try {
            $query = $this->create([
                'full_name'     => $payload['full_name'],
                'first_name'    => $payload['first_name'],
                'last_name'     => $payload['last_name'],
                'nickname'      => $payload['nickname'],
                'email'         => $payload['email'],
                'phone'         => $payload['phone'],
                'password'      => $payload['password'],
                'profile_image' => $payload['profile_image'],
                'role_id'       => $payload['role_id'],
            ]);

            return $query;
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
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
    public function fetchSingleRecord($id, string|null $type = null)
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            if ($type === 'relation') {
                $query->with([
                    'role' => function ($query) {
                        $query->select('id', 'name', 'is_active')
                            ->where('is_active', true)
                            ->with([
                                'permissions' => function ($query) {
                                    $query->select('id', 'name', 'is_active', 'role_id')
                                        ->where('is_active', true);
                                }
                            ]);
                    }
                ]);

                return $query->get();
            } else {
                return $query->get();
            }
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Update an existing record.
     * @param array $payload An associative array of values to create a new record.
     * @return \App\Models\User|bool Returns a record object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function updateRecord($payload, $id)
    {
        try {
            $query = tap($this->find($id))->update([
                'full_name'     => $payload['full_name'],
                'first_name'    => $payload['first_name'],
                'last_name'     => $payload['last_name'],
                'role_id'       => $payload['role_id'],
            ]);

            return $query->fresh();
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
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
        try {
            $query = tap($this->find($id))->delete();

            return $query->fresh();
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields()
    {
        $fieldTypes = [
            'full_name'     => 'text',
            'first_name'    => 'text',
            'last_name'     => 'text',
            'nickname'      => 'text',
            'email'         => 'email',
            'phone'         => 'tel',
            'password'      => 'password',
            'profile_image' => 'file',
            'role_id'       => 'number',
        ];

        $excludedFields = ['role_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the statistical indicators for the model.
     * @return array An array containing the statistical indicators for the model.
     */
    public function getStatisticalIndicators()
    {
        return $this->statisticalIndicators;
    }
}
