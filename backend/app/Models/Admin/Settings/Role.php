<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Settings\Field;
use App\Models\Admin\Settings\Sort;
use App\Traits\ApiLogError;

/**
 * Class Role
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
class Role extends Model
{
    use HasFactory, ApiLogError;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
        'name'        => 'text',
        'description' => 'text',
        'bg_color'    => 'text',
        'text_color'  => 'text',
        'slug'        => 'text',
        'is_active'   => 'boolean',
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
     * Eloquent polymorphic relationship between users and fields.
     *
     */
    public function field()
    {
        return $this->morphOne(Field::class, 'fieldable');
    }

    /**
     * Eloquent polymorphic relationship between users and sorts.
     *
     */
    public function sort()
    {
        return $this->morphOne(Sort::class, 'sortable');
    }

    /**
     * Eloquent relationship between roles and users.
     *
     */
    public function users()
    {
        return $this->hasMany('App\Models\Admin\Settings\User');
    }

    /**
     * Eloquent relationship between roles and permissions.
     *
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\Admin\Settings\Permission');
    }

    /**
     * Fetches all records from the database.
     * @param  array  $search
     * @return \Illuminate\Database\Eloquent\Collection|bool
     * The collection of records on success, or false on failure.
     */
    public function fetchAllRecords($search)
    {
        try
        {
            $query = $this->select('id', 'name', 'slug', 'is_active');

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
        catch (\Illuminate\Database\QueryException $mysqlError)
        {
            $this->handleApiLogError($mysqlError);
            return False;
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
     * @return \App\Models\Role|bool Returns a user object if the creation was successful,
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
                        ->with('permissions')
                        ->get();
        }
        catch (\Illuminate\Database\QueryException $mysqlError)
        {
            $this->handleApiLogError($mysqlError);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->handleApiLogError($exception);
            return false;
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

    public function getFields()
    {
        return $this->fillable;
    }
}
