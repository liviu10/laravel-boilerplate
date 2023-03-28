<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereUserRoleDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereUserRoleIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoleType whereUserRoleName($value)
 * @mixin \Eloquent
 * @method fetchAllUserRoleTypes
 */
class UserRoleType extends Model
{
    use HasFactory;

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
     * Returns a collection of users with their associated user role type.
     * If an error occurs during retrieval, an boolean will be returned.
     */
    public function fetchAllUserRoleTypes()
    {
        try
        {
            return $this->select(
                'id',
                'user_role_name',
                'user_role_description',
                'is_active'
            )->get();
        }
        catch (\Exception $exception)
        {
            $logError = [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
            Log::error($logError);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $logError = [
                'query'    => $exception->getSql(),
                'message'  => $exception->getMessage(),
                'bindings' => $exception->getBindings()
            ];
            Log::error($logError);
            return false;
        }
    }
}
