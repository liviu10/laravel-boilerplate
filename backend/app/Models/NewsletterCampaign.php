<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

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
 * @method getFields
 */
class NewsletterCampaign extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'newsletter_campaigns';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

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

    protected $statisticalIndicators = [
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

    protected $attributes = [
        'is_active' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'valid_from'  => 'datetime:d.m.Y H:i',
            'valid_to'    => 'datetime:d.m.Y H:i',
            'occur_times' => 'integer',
            'occur_week'  => 'integer',
            'occur_day'   => 'integer',
            'occur_time'  => 'time:H:i',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function newsletter_subscribers()
    {
        return $this->hasMany('App\Models\NewsletterSubscriber');
    }

    /**
     * Fetch records from the database based on optional search criteria.
     * @param array $search An associative array of search criteria (field => value).
     * @param string|null $type The fetch type: 'paginate'for paginated results or null for a collection.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|bool
     * A paginated result, a collection, or `false` if an error occurs.
     */
    public function fetchAllRecords(array $search = [], string|null $type = null): LengthAwarePaginator|Collection|bool
    {
        try {
            $query = $this->select('id', 'name', 'valid_from', 'valid_to', 'is_active');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'description') {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    } else {
                        $query->where($field, '=', $value);
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\NewsletterCampaign|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): NewsletterCampaign|bool
    {
        try {
            $query = $this->create([
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

            return $query;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Fetch a single record from the database by its ID.
     * @param int $id The unique identifier of the record to fetch.
     * @param string|null $type The fetch type: 'relation' to include
     * related data or null for just the record.
     * @return \Illuminate\Support\Collection|bool The fetched record or
     * related data as a Collection, or `false` if an error occurs.
     */
    public function fetchSingleRecord(int $id, string|null $type = null): Collection|bool
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            if ($type === 'relation') {
                $query->with([
                    'newsletter_subscribers' => function ($query) {
                        $query->select('id', 'newsletter_campaign_id', 'full_name', 'email_address', 'privacy_policy');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);
                return $query->get();
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Update a record in the database.
     * @param array $payload An associative array containing the updated record data.
     * @param int $id The unique identifier of the record to update.
     * @return \App\Models\NewsletterCampaign|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): NewsletterCampaign|bool
    {
        try {
            $query = tap($this->find($id))->update([
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

            return $query->fresh();
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields(): array
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
}
