<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'full_name',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 2,
            'key' => 'first_name',
            'type' => 'text',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 3,
            'key' => 'last_name',
            'type' => 'text',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 4,
            'key' => 'nickname',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 5,
            'key' => 'email',
            'type' => 'email',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => false,
        ],
        [
            'id' => 6,
            'key' => 'phone',
            'type' => 'tel',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 7,
            'key' => 'password',
            'type' => 'password',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 8,
            'key' => 'confirm_password',
            'type' => 'password',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 9,
            'key' => 'profile_image',
            'type' => 'file',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 10,
            'key' => 'created_at',
            'type' => 'datetime-local',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime:d.m.Y H:i',
        'password' => 'hashed',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function fetchAllRecords(array $search = []): Collection|Exception
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

            $query = $query->get();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

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
                'profile_image' => $this->getProfileImageUrl($payload),
            ]);
        } catch (Exception $exception) {
            dd($exception);
            return $exception;
        }
    }

    public function fetchSingleRecord(int $id): Collection|Exception
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): User|Exception
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
                'profile_image' => $this->getProfileImageUrl($payload),
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function partialUpdateRecord(array $payload, int $id): User|Exception
    {
        try {
            $query = $this->findOrFail($id);
            $query->update([
                'full_name' => $payload['full_name'],
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
            ]);

            return $query->refresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(int $id): User|Exception
    {
        try {
            $query = $this->find($id);
            $query->delete();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function getProfileImageUrl(array $input): string
    {
        $fullName = $input['first_name'] . ' ' . $input['last_name'];
        return vsprintf('https://www.gravatar.com/avatar/%s.jpg?s=200&d=%s', [
            md5(strtolower($input['email'])),
            $fullName ? urlencode('https://ui-avatars.com/api/' . $fullName) : 'mp'
        ]);
    }

    public function getInputs(): array
    {
        $inputs = $this->inputs;

        return $inputs;
    }

    public function generatePassword($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
