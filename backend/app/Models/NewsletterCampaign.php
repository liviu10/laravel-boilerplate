<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use App\Traits\GetModelIdAndName;
use App\Traits\GetStatisticalIndicators;

/**
 * Class NewsletterCampaign
 * @package App\Models

 * @property int $id
 * @property string $name
 * @property string $description
 * @property boolean $is_active
 * @property \Carbon\Carbon $valid_from
 * @property \Carbon\Carbon $valid_to
 * @property int $occur_times
 * @property int $occur_week
 * @property int $occur_day
 * @property \Carbon\Carbon $occur_time
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class NewsletterCampaign extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError,
    GetModelIdAndName, GetStatisticalIndicators;

    /**
     * The model id.
     * @var int
     */
    protected $modelId = 7;

    /**
     * The model name.
     * @var string
     */
    protected $modelName = 'NewsletterCampaign';

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'newsletter_campaigns';

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
        'name',
        'description',
        'is_active',
        'valid_from',
        'valid_to',
        'occur_times',
        'occur_week',
        'occur_day',
        'occur_hour',
        'user_id',
    ];

    /**
     * The statistical indicators.
     * @var array<string>
     */
    protected $indicators = [
        'number_of_newsletter_campaigns',
        'number_of_newsletter_campaigns_by_status',
    ];

    /**
    * The attributes that are mass assignable.
    * @var string
    */
    protected $attributes = [
        'is_active' => false,
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'          => 'integer',
        'is_active'   => 'boolean',
        'valid_from'  => 'datetime:d.m.Y H:i',
        'valid_to'    => 'datetime:d.m.Y H:i',
        'occur_times' => 'integer',
        'occur_week'  => 'integer',
        'occur_day'   => 'integer',
        'occur_time'  => 'time:H:i',
        'created_at'  => 'datetime:d.m.Y H:i',
        'updated_at'  => 'datetime:d.m.Y H:i',
        'user_id'     => 'integer',
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
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Eloquent relationship between newsletter campaigns and newsletter subscribers.
     */
    public function newsletter_subscribers()
    {
        return $this->hasMany('App\Models\NewsletterSubscriber');
    }

    /**
     * Eloquent polymorphic relationship between notification campaigns and reports.
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
            $query = $this->select('id', 'name', 'valid_from', 'valid_to', 'is_active');

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
                'name'        => $payload['name'],
                'description' => $payload['description'],
                'is_active'   => $payload['is_active'],
                'valid_from'  => $payload['valid_from'],
                'valid_to'    => $payload['valid_to'],
                'occur_times' => $payload['occur_times'],
                'occur_week'  => $payload['occur_week'],
                'occur_day'   => $payload['occur_day'],
                'occur_hour'  => $payload['occur_hour'],
                'user_id'     => $payload['user_id'],
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
                            'newsletter_subscribers' => function ($query) {
                                $query->select('id', 'newsletter_campaign_id', 'full_name', 'email_address', 'privacy_policy');
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
                'name'        => $payload['name'],
                'description' => $payload['description'],
                'is_active'   => $payload['is_active'],
                'valid_from'  => $payload['valid_from'],
                'valid_to'    => $payload['valid_to'],
                'occur_times' => $payload['occur_times'],
                'occur_week'  => $payload['occur_week'],
                'occur_day'   => $payload['occur_day'],
                'occur_hour'  => $payload['occur_hour'],
                'user_id'     => $payload['user_id'],
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
            'name'        => 'text',
            'description' => 'text',
            'is_active'   => 'boolean',
            'valid_from'  => 'date',
            'valid_to'    => 'date',
            'occur_times' => 'number',
            'occur_week'  => 'number',
            'occur_day'   => 'number',
            'occur_hour'  => 'time',
            'user_id'     => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
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
