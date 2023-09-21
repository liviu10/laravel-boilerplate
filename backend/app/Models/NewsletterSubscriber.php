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
class NewsletterSubscriber extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'newsletter_subscribers';

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
     * The statistical indicators.
     * @var array<string>
     */
    protected $statisticalIndicators = [
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
     * Get the type casts for the model attributes.
     * This method allows you to customize the attribute type casts for the model.
     * It merges the parent model's casts with any additional or modified casts
     * specific to the child model.
     * @return array
     */
    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'privacy_policy'         => 'boolean',
            'valid_email'            => 'boolean',
            'newsletter_campaign_id' => 'integer',
        ]);
    }

    /**
     * Eloquent relationship between newsletter subscribers and newsletter campaigns.
     */
    public function newsletter_campaign()
    {
        return $this->belongsTo('App\Models\NewsletterCampaign');
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
            $query = $this->select('id', 'full_name', 'email', 'privacy_policy', 'valid_email');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'privacy_policy' || $field === 'valid_email') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
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
     * @return \App\Models\NewsletterSubscriber|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): NewsletterSubscriber|bool
    {
        try {
            $query = $this->create([
                'full_name'              => $payload['full_name'],
                'email'                  => $payload['email'],
                'privacy_policy'         => $payload['privacy_policy'],
                'valid_email'            => $payload['valid_email'],
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
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
                    'newsletter_campaign' => function ($query) {
                        $query->select('id', 'name', 'valid_from', 'valid_to');
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
     * @return \App\Models\NewsletterSubscriber|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): NewsletterSubscriber|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
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
    public function checkEmailSubscriber($email): array
    {
        try {
            $result = $this->select('id', 'email')->where('email', $email)->get()->toArray();

            return $result;
        } catch (\Illuminate\Database\QueryException $mysqlError) {
            $this->LogApiError($mysqlError);
            return false;
        }
    }
}
