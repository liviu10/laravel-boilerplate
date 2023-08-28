<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use App\Traits\GetModelIdAndName;
use App\Traits\GetStatisticalIndicators;

/**
 * Class Comment
 * @package App\Models

 * @property int $id
 * @property string $type
 * @property string $status
 * @property string $full_name
 * @property string $email
 * @property string $message
 * @property boolean $notify_new_comments
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
class Comment extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError,
    GetModelIdAndName, GetStatisticalIndicators;

    /**
     * The model id.
     * @var int
     */
    protected $modelId = 3;

    /**
     * The model name.
     * @var string
     */
    protected $modelName = 'Comment';

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'comments';

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
        'type',
        'status',
        'full_name',
        'email',
        'message',
        'notify_new_comments',
        'content_id',
        'user_id',
    ];

    /**
     * The statistical indicators.
     * @var array<string>
     */
    protected $indicators = [
        'number_of_comments_by_type',
        'number_of_comments_by_status',
        'number_of_comments_by_type_and_content',
        'number_of_comments_by_status_and_content',
        'number_of_comments_by_type_and_status',
    ];

    /**
     * The comment type options.
     * @var array<string>
     */
    protected $commentTypeOptions = [
        'Comment', 'Reply'
    ];

    /**
     * The comment status options.
     * @var array<string>
     */
    protected $commentStatusOptions = [
        'Pending', 'Approved', 'Spam', 'Trash'
    ];

    /**
    * The attributes that are mass assignable.
    * @var string
    */
    protected $attributes = [
        'notify_new_comments' => false,
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'                  => 'integer',
        'notify_new_comments' => 'boolean',
        'created_at'          => 'datetime:d.m.Y H:i',
        'updated_at'          => 'datetime:d.m.Y H:i',
        'content_id'          => 'integer',
        'user_id'             => 'integer',
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
     * Eloquent polymorphic relationship between comments and reports.
     *
     */
    public function report()
    {
        return $this->morphOne(Report::class, 'reportable');
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
                'type'                => $payload['type'],
                'status'              => $payload['status'],
                'full_name'           => $payload['full_name'],
                'email'               => $payload['email'],
                'message'             => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
                'content_id'          => $payload['content_id'],
                'user_id'             => $payload['user_id'],
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
                'type'                => $payload['type'],
                'status'              => $payload['status'],
                'full_name'           => $payload['full_name'],
                'email'               => $payload['email'],
                'message'             => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
                'content_id'          => $payload['content_id'],
                'user_id'             => $payload['user_id'],
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
            'type'                => 'select',
            'status'              => 'select',
            'full_name'           => 'text',
            'email'               => 'text',
            'message'             => 'text',
            'notify_new_comments' => 'boolean',
            'content_id'          => 'number',
            'user_id'             => 'number',
        ];

        $excludedFields = ['content_id', 'user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the comment type options.
     * @return array An array containing the comment type options.
     */
    public function getCommentTypeOptions()
    {
        return $this->commentTypeOptions;
    }

    /**
     * Get the content status options.
     * @return array An array containing the content status options.
     */
    public function getCommentStatusOptions()
    {
        return $this->commentStatusOptions;
    }

    public function getModelIdAndName()
    {
        $modelId = $this->modelId;
        $modelName = __NAMESPACE__ . '\\' . basename($this->modelName);

        return $this->handleModelIdAndName($modelId, $modelName);
    }

    public function getStatisticalIndicators()
    {
        $statisticalIndicators = $this->indicators;

        return $this->handleStatisticalIndicators($statisticalIndicators);
    }
}
