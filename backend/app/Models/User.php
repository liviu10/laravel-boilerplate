<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory,
        HasApiTokens,
        HasProfilePhoto,
        HasTeams,
        Notifiable,
        TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * @return Collection|Exception
     * @throws Exception
     */
    public function fetchSingleRecord(string $id): Collection|Exception
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
