<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

/**
 * Class NewsletterSubscriber
 * @package App\Models

 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property boolean $privacy_policy
 * @property boolean $valid_email
 * @property int $newsletter_campaign_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class NewsletterSubscriber extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'newsletter_subscribers';

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
    protected $foreignKey = 'newsletter_campaign_id';

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
        'full_name',
        'email',
        'privacy_policy',
        'valid_email',
        'newsletter_campaign_id',
    ];

    /**
    * The attributes that are mass assignable.
    * @var string
    */
    protected $attributes = [
        'privacy_policy' => false,
        'valid_email'    => false,
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'                     => 'integer',
        'privacy_policy'         => 'boolean',
        'valid_email'            => 'boolean',
        'newsletter_campaign_id' => 'integer',
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
     * Eloquent relationship between newsletter subscribers and newsletter campaigns.
     */
    public function newsletter_campaign()
    {
        return $this->belongsTo('App\Models\NewsletterCampaign');
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
            $query = $this->select('id', 'full_name', 'email', 'privacy_policy', 'valid_email');

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
                'full_name'              => $payload['full_name'],
                'email'                  => $payload['email'],
                'privacy_policy'         => $payload['privacy_policy'],
                'valid_email'            => $payload['valid_email'],
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
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
                            'newsletter_campaign' => function ($query) {
                                $query->select('id', 'name', 'valid_from', 'valid_to');
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
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
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
            'full_name'              => 'text',
            'email'                  => 'text',
            'privacy_policy'         => 'boolean',
            'valid_email'            => 'boolean',
            'newsletter_campaign_id' => 'number',
        ];

        $excludedFields = ['newsletter_campaign_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Check if an email subscriber exists and retrieve their information.
     * @param string $email The email address to check and retrieve information for.
     * @return array|false An array containing associative arrays with 'id' and 'email'
     * keys for the matching subscriber(s), or false if an error occurs during the query.
     */
    public function checkEmailSubscriber($email)
    {
        try
        {
            $result = $this->select('id', 'email')->where('email', $email)->get()->toArray();

            return $result;
        }
        catch (\Illuminate\Database\QueryException $mysqlError)
        {
            $this->LogApiError($mysqlError);
            return false;
        }
    }
}
