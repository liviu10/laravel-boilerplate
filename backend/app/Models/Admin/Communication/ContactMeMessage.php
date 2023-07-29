<?php

namespace App\Models\Admin\Communication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiLogError;

/**
 * Class ContactMe
 * @package App\Models\Admin\Communication

 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $message
 * @property boolean $privacy_policy
 * @property int $user_id
 * @property int $contact_me_subject_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class ContactMeMessage extends Model
{
    use HasFactory, ApiLogError;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_me_messages';

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
    protected $foreignKey = 'user_id';

    /**
     * The data type of the database table foreign key.
     *
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The foreign key associated with the table.
     *
     * @var string
     */
    protected $foreignKeyContactMeSubject = 'contact_me_subject_id';

    /**
     * The data type of the database table foreign key.
     *
     * @var string
     */
    protected $foreignKeyTypeContactMeSubject = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'full_name',
        'email',
        'message',
        'privacy_policy',
        'user_id',
        'contact_me_subject_id',
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
        'id'                    => 'integer',
        'privacy_policy'        => 'boolean',
        'created_at'            => 'datetime:d.m.Y H:i',
        'updated_at'            => 'datetime:d.m.Y H:i',
        'user_id'               => 'integer',
        'contact_me_subject_id' => 'integer',
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
     * Eloquent relationship between contact me messages and users.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Admin\Settings\User');
    }

    /**
     * Eloquent relationship between contact me messages and contact me subjects.
     *
     */
    public function contact_me_subject()
    {
        return $this->belongsTo('App\Models\Admin\Communication\ContactMeSubject');
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
                'id', 'full_name', 'email', 'contact_me_subject_id'
            )
            ->with([
                'contact_me_subject' => function ($query) {
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
                'full_name'             => $payload['full_name'],
                'email'                 => $payload['email'],
                'message'               => $payload['message'],
                'privacy_policy'        => $payload['privacy_policy'],
                'user_id'               => $payload['user_id'],
                'contact_me_subject_id' => $payload['contact_me_subject_id'],
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
                            'contact_me_subject' => function ($query) {
                                $query->select('id', 'name');
                            },
                            'user' => function ($query) {
                                $query->select('id', 'full_name');
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
                'full_name'             => $payload['full_name'],
                'email'                 => $payload['email'],
                'message'               => $payload['message'],
                'privacy_policy'        => $payload['privacy_policy'],
                'user_id'               => $payload['user_id'],
                'contact_me_subject_id' => $payload['contact_me_subject_id'],
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
        $contactMeSubjectModel = new ContactMeSubject();
        $subjectRecords = $contactMeSubjectModel->fetchAllRecords();
        $options = [];
        foreach ($subjectRecords as $record) {
            $options[] = [
                'value' => $record['id'],
                'label' => $record['name'],
            ];
        }

        $availableFilters = [
            [
                'id' => 1,
                'key' => 'id',
                'name' => 'Filter by ID',
                'type' => 'number'
            ],
            [
                'id' => 2,
                'key' => 'full_name',
                'name' => 'Filter by full name',
                'type' => 'text'
            ],
            [
                'id' => 3,
                'key' => 'email',
                'name' => 'Filter by email',
                'type' => 'text'
            ],
            [
                'id' => 3,
                'key' => 'contact_me_subject_id',
                'name' => 'Filter by subject',
                'type' => 'select',
                'options' => $options
            ]
        ];

        return $availableFilters;
    }
}
