<?php

namespace App\Models\Admin\Communication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiLogError;
use App\Traits\ApiDataModel;
use App\Traits\ApiFilters;

/**
 * Class ContactMessage
 * @package App\Models\Admin\Communication

 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $message
 * @property boolean $privacy_policy
 * @property int $user_id
 * @property int $contact_subject_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class ContactMessage extends Model
{
    use HasFactory, ApiLogError, ApiDataModel, ApiFilters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_messages';

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
     * The foreign key associated with the table.
     *
     * @var string
     */
    protected $foreignKey = 'contact_subject_id';

    /**
     * The data type of the database table foreign key.
     *
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'full_name'          => 'string',
        'email'              => 'string',
        'phone'              => 'string',
        'message'            => 'string',
        'privacy_policy'     => 'boolean',
        'contact_subject_id' => 'number',
    ];

    /**
     * The model filters.
     *
     * @var array<string, string>
     */
    protected $filters = [
        'id'                 => 'number',
        'full_name'          => 'text',
        'email'              => 'text',
        'phone'              => 'text',
        'privacy_policy'     => 'boolean',
        'contact_subject_id' => 'number',
    ];


    /**
    * The attributes that are mass assignable.
    *
    * @var string
    */
    protected $attributes = [
        'privacy_policy' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'                 => 'integer',
        'privacy_policy'     => 'boolean',
        'created_at'         => 'datetime:d.m.Y H:i',
        'updated_at'         => 'datetime:d.m.Y H:i',
        'contact_subject_id' => 'integer',
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
     * Eloquent relationship between contact messages and contact subjects.
     *
     */
    public function contact_subject()
    {
        return $this->belongsTo('App\Models\Admin\Communication\ContactSubject');
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
            return $this->select(
                'id', 'full_name', 'email', 'phone', 'contact_subject_id'
            )
            ->with([
                'contact_subject' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->paginate(15);
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
                'full_name'          => $payload['full_name'],
                'email'              => $payload['email'],
                'phone'              => $payload['phone'],
                'message'            => $payload['message'],
                'privacy_policy'     => $payload['privacy_policy'],
                'contact_subject_id' => $payload['contact_subject_id'],
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
                        ->with([
                            'contact_subject' => function ($query) {
                                $query->select('id', 'name');
                            }
                        ])
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
                'full_name'          => $payload['full_name'],
                'email'              => $payload['email'],
                'phone'              => $payload['phone'],
                'message'            => $payload['message'],
                'privacy_policy'     => $payload['privacy_policy'],
                'contact_subject_id' => $payload['contact_subject_id'],
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

    public function getDataModel()
    {
        $dataModelOptions = [
            'full_name' => [
                'name'        => 'Full name',
                'is_required' => true
            ],
            'email' => [
                'name'        => 'Email address',
                'is_required' => true
            ],
            'phone' => [
                'name'        => 'Phone number',
                'is_required' => true
            ],
            'message' => [
                'name'        => 'Message',
                'is_required' => true
            ],
            'privacy_policy' => [
                'name'        => 'Privacy policy',
                'is_required' => true
            ],
            'contact_subject_id' => [
                'name'        => 'Contact subject',
                'is_required' => true
            ],
        ];

        return $this->handleApiDataModel($this->fillable, $dataModelOptions);
    }

    /**
     * Get the filters that can be applied to the records.
     * The method returns an array of filter options
     * that can be used to filter the records.
     * @return array An array of filter options.
     */
    public function getFilters()
    {
        $filterNames = [
            'id'                 => 'Filter by ID',
            'full_name'          => 'Filter by full name',
            'email'              => 'Filter by email',
            'phone'              => 'Filter by phone',
            'privacy_policy'     => 'Filter by privacy policy',
            'contact_subject_id' => 'Filter by privacy policy',
        ];

        return $this->handleApiFilters($this->filters, $filterNames);
    }
}
