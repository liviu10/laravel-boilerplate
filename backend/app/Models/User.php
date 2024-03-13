<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LogApi;
use App\Traits\HasGravatar;

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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        LogApi;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $foreignKey = 'role_id';

    protected $foreignKeyType = 'int';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'datetime:d.m.Y H:i',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

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
                    if ($field === 'id') {
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
            $this->LogApi($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApi($exception);
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
                'full_name' => $payload['full_name'],
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'nickname' => $payload['nickname'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
                'password' => $payload['password'],
                'profile_image' => $payload['profile_image'],
            ]);

            return $query;
        } catch (\Exception $exception) {
            $this->LogApi($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApi($exception);
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
                return $query->get();
            } else {
                return $query->get();
            }
        } catch (\Exception $exception) {
            $this->LogApi($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApi($exception);
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
                'full_name' => $payload['full_name'],
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
            ]);

            return $query->fresh();
        } catch (\Exception $exception) {
            $this->LogApi($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApi($exception);
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
            $this->LogApi($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApi($exception);
            return false;
        }
    }
}
