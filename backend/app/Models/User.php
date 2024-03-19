<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ApiHandleFilter;

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
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        ApiHandleFilter;

    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'phone',
        'password',
        'profile_image',
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

    public function notification_types(): HasMany
    {
        return $this->hasMany('App\Models\NotificationType');
    }

    public function notification_conditions(): HasMany
    {
        return $this->hasMany('App\Models\NotificationCondition');
    }

    public function notification_templates(): HasMany
    {
        return $this->hasMany('App\Models\NotificationTemplate');
    }

    public function general(): MorphOne
    {
        return $this->morphOne(General::class, 'generalable');
    }

    /**
     * Get all the records from the database.
     *
     * @param array $search
     * @return Collection|LengthAwarePaginator|Exception
     * @throws Exception
     */
    public function fetchAllRecords(array $search = []): Collection|LengthAwarePaginator|Exception
    {
        try {
            $query = $this->select(
                'id',
                'full_name',
                'nickname',
                'email',
                'created_at',
            );

            $this->handleApiFilter($query, $search);

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Create a new record.
     *
     * @param array $payload
     * @return User|Exception
     * @throws Exception
     */
    public function createRecord(array $payload): User|Exception
    {
        try {
            return $this->create([
                'full_name' => $payload['full_name'],
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'nickname' => $payload['nickname'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
                'password' => $payload['password'],
                'profile_image' => $payload['profile_image'],
            ]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Get record details from the database.
     *
     * @param string $id
     * @param string|null $type
     * @return Collection|Exception
     * @throws Exception
     */
    public function fetchSingleRecord(string $id, string|null $type = null): Collection|Exception
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Update an existing record.
     *
     * @param array $payload
     * @param string $id
     * @return User|Exception
     * @throws Exception
     */
    public function updateRecord(array $payload, string $id): User|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'full_name' => $payload['full_name'],
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'nickname' => $payload['nickname'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
                'password' => $payload['password'],
                'profile_image' => $payload['profile_image'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Deletes a record from the database.
     *
     * @param string $id
     * @return bool|Exception
     * @throws Exception
     */
    public function deleteRecord(string $id): bool|Exception
    {
        try {
            $this->find($id)->delete();

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
