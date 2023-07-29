<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiLogError;

/**
 * Class RoleAndPermission
 * @package App\Models\Admin\Settings

 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property string $text_color
 * @property string $slug
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class RoleAndPermission extends Model
{
    use HasFactory, ApiLogError;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles_and_permissions';

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
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name',
        'description',
        'bg_color',
        'text_color',
        'slug',
        'is_active',
    ];

    /**
    * The attributes that are mass assignable.
    *
    * @var string
    */
    protected $attributes = [
        'is_active' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'         => 'integer',
        'is_active'  => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent relationship between roles and permissions and users.
     *
     */
    public function users()
    {
        return $this->hasMany('App\Models\Admin\Settings\User');
    }

    /**
     * Fetches all records from the database.
     * @return \Illuminate\Database\Eloquent\Collection|bool
     * The collection of records on success, or false on failure.
     */
    public function fetchAllRecords()
    {
        try
        {
            return $this->select('id', 'name', 'slug')->paginate(15);
        }
        catch (\Illuminate\Database\QueryException $mysqlError)
        {
            $this->handleApiLogError($mysqlError);
            return False;
        }
    }

    /**
     * Create a new record.
     * @param array $payload An associative array of values to create a new record.
     * @return \App\Models\RoleAndPermission|bool Returns a user object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function createRecord($payload)
    {
        try
        {
            $this->create([
                'name'         => $payload['name'],
                'description'  => $payload['description'],
                'bg_color'     => $payload['bg_color'],
                'text_color'   => $payload['text_color'],
                'slug'         => $payload['slug'],
                'is_active'    => $payload['is_active'],
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
     * SQL query to fetch a single record from the database.
     * @param  int  $id
     * @return  Collection|Bool
     */
    public function fetchSingleRecord($id)
    {
        try
        {
            return $this->select('*')
                        ->where('id', '=', $id)
                        ->get();
        }
        catch (\Illuminate\Database\QueryException $mysqlError)
        {
            $this->handleApiLogError($mysqlError);
            return False;
        }
    }

    /**
     * Update the record.
     * @param array $payload An associative array of values to update the record.
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
                'name'         => $payload['name'],
                'description'  => $payload['description'],
                'bg_color'     => $payload['bg_color'],
                'text_color'   => $payload['text_color'],
                'slug'         => $payload['slug'],
                'is_active'    => $payload['is_active'],
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
     * Deletes a record from the database.
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

    /**
     * Get the filters that can be applied to the records.
     * The method returns an array of filter options
     * that can be used to filter the records.
     * @return array An array of filter options.
     */
    public function getFilters()
    {
        $availableFilters = [
            [
                'id' => 1,
                'key' => 'id',
                'name' => 'Filter by ID',
                'type' => 'number'
            ],
            [
                'id' => 2,
                'key' => 'name',
                'name' => 'Filter by name',
                'type' => 'text'
            ],
            [
                'id' => 3,
                'key' => 'slug',
                'name' => 'Filter by slug',
                'type' => 'text'
            ]
        ];

        return $availableFilters;
    }
}
