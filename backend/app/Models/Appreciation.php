<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

/**
 * Class Appreciation
 * @package App\Models

 * @property int $id
 * @property int $likes
 * @property int $dislikes
 * @property int $rating
 * @property int $content_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class Appreciation extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The model name.
     * @var string
     */
    protected $modelName = 'Appreciation';

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'appreciations';

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
     * The attributes that are mass assignable.
     * @var array<string>
     */
    protected $fillable = [
        'likes',
        'dislikes',
        'rating',
        'content_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'         => 'integer',
        'likes'      => 'integer',
        'dislikes'   => 'integer',
        'rating'     => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'content_id' => 'integer',
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
     * @return \App\Models\ContactMe|bool Returns a user object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function createRecord($payload)
    {
        try
        {
            $this->create([
                'likes'      => $payload['likes'],
                'dislikes'   => $payload['dislikes'],
                'rating'     => $payload['rating'],
                'content_id' => $payload['content_id'],
                'user_id'    => $payload['user_id'],
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
            $this->LogApiError($mysqlError);
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
                'likes'      => $payload['likes'],
                'dislikes'   => $payload['dislikes'],
                'rating'     => $payload['rating'],
                'content_id' => $payload['content_id'],
                'user_id'    => $payload['user_id'],
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
            'likes'      => 'number',
            'dislikes'   => 'number',
            'rating'     => 'number',
            'content_id' => 'number',
            'user_id'    => 'number',
        ];

        $excludedFields = ['content_id', 'user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    public function fetchAllRecordDetails()
    {
        try {
            return $this->select('*')->get()->toArray();
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }
}
