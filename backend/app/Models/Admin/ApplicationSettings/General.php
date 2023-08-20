<?php

namespace App\Models\Admin\ApplicationSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

/**
 * Class General
 * @package App\Models\Admin\ApplicationSettings

 * @property int $id
 * @property string $type
 * @property string $label
 * @property string $value
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method updateRecord
 * @method deleteRecord
 */
class General extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'generals';

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
    protected $foreignKey = 'user_id';

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
        'type',
        'label',
        'value',
        'user_id',
    ];

    /**
     * The general type options.
     * @var array<string>
     */
    protected $generalTypeOptions = [
        'General',
        'Writing',
        'Reading',
        'Discussion',
        'Media',
        'Performance',
        'Notifications',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'         => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'user_id'    => 'integer',
    ];

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent relationship between accepted domains and users.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Admin\Settings\User');
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
            $query = $this->select('*');

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
            $this->LogApiError($mysqlError);
            return False;
        }
    }

    /**
     * Create a new record.
     * @param array $payload An associative array of values to create a new record.
     * @return \App\Models\General|bool Returns a user object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function createRecord($payload)
    {
        try
        {
            $this->create([
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
            ]);

            return True;
        }
        catch (\Exception $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->LogApiError($exception);
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
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
            ]);

            return True;
        }
        catch (\Exception $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->LogApiError($exception);
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
            $this->LogApiError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
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
            'type'    => 'text',
            'label'   => 'text',
            'value'   => 'text',
            'user_id' => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the general type options.
     * @return array An array containing the general type options.
     */
    public function getGeneralTypeOptions()
    {
        return $this->generalTypeOptions;
    }
}
