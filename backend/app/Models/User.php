<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
 * @method fetchAllUsers
 * @method updateUserRole
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * Get all users with their user role type information.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAllUsers()
    {
        return $this->with([
            'user_role_type' => function ($query) {
                $query->select('*');
            }
        ])->get();
    }

    public function updateUserRole($payload, $id)
    {
        $this->find($id)->update([
            'user_role_type_id' => $payload['user_role_type_id'],
        ]);

        return True;
    }
}
