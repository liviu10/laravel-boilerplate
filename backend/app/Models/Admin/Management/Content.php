<?php

namespace App\Models\Admin\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

/**
 * Class Content
 * @package App\Models\Admin\Management

 * @property int $id
 * @property string $visibility
 * @property string $content_url
 * @property string $title
 * @property string $content_type
 * @property string $description
 * @property string $content
 * @property boolean $allow_comments
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class Content extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'contents';

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
        'visibility',
        'content_url',
        'title',
        'content_type',
        'description',
        'content',
        'allow_comments',
        'user_id',
    ];

    /**
     * The visibility options.
     * @var array<string>
     */
    protected $visibilityOptions = [
        'Public', 'Private', 'Draft'
    ];

    /**
     * The content type options.
     * @var array<string>
     */
    protected $contentTypeOptions = [
        'Page', 'Article'
    ];

    /**
    * The attributes that are mass assignable.
    * @var string
    */
    protected $attributes = [
        'allow_comments' => false,
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'             => 'integer',
        'allow_comments' => 'boolean',
        'created_at'     => 'datetime:d.m.Y H:i',
        'updated_at'     => 'datetime:d.m.Y H:i',
        'user_id'        => 'integer',
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
     * Eloquent relationship between contact me messages and users.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Admin\Settings\User');
    }

    /**
     * Eloquent relationship between contents and tags.
     */
    public function tags()
    {
        return $this->hasMany('App\Models\Admin\Management\Tag');
    }

    /**
     * Eloquent relationship between contents and medias.
     */
    public function medias()
    {
        return $this->hasMany('App\Models\Admin\Management\Media');
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
            return $this->select('id', 'visibility', 'content_url', 'title', 'content_type')->paginate(15);
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
                'visibility'     => $payload['visibility'],
                'content_url'    => $payload['content_url'],
                'title'          => $payload['title'],
                'content_type'   => $payload['content_type'],
                'description'    => $payload['description'],
                'content'        => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'user_id'        => $payload['user_id'],
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
                        ->with([
                            'tags' => function ($query) {
                                $query->select('*');
                            },
                            'medias' => function ($query) {
                                $query->select('*');
                            },
                            'user' => function ($query) {
                                $query->select('id', 'full_name');
                            }
                        ])
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
                'visibility'     => $payload['visibility'],
                'content_url'    => $payload['content_url'],
                'title'          => $payload['title'],
                'content_type'   => $payload['content_type'],
                'description'    => $payload['description'],
                'content'        => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'user_id'        => $payload['user_id'],
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
            'visibility'     => 'select',
            'content_url'    => 'text',
            'title'          => 'text',
            'content_type'   => 'select',
            'description'    => 'date',
            'content'        => 'number',
            'allow_comments' => 'boolean',
            'user_id'        => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the visibility options.
     * @return array An array containing the visibility options.
     */
    public function getVisibilityOptions()
    {
        return $this->visibilityOptions;
    }

    /**
     * Get the content type options.
     * @return array An array containing the content type options.
     */
    public function getContentTypeOptions()
    {
        return $this->contentTypeOptions;
    }
}
