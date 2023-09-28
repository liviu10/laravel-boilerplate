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
 * Class AcceptedDomain
 * @package App\Models

 * @property int $id
 * @property string $domain
 * @property string $type
 * @property int $user_id
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method checkEmailProvider
 * @method getUniqueDomainTypes
 * @method getFields
 */
class AcceptedDomain extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'accepted_domains';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'domain',
        'type',
        'user_id',
        'is_active',
    ];

    protected $statisticalIndicators = [
        'type',
        'is_active',
        'user_id',
    ];

    protected $resources = [
        'accepted-domains.index',
        'accepted-domains.create',
        'accepted-domains.show',
        'accepted-domains.update',
        'accepted-domains.destroy',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'user_id' => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
            $query = $this->select(
                'id',
                'domain',
                'type',
                'is_active'
            );

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'type' || $field === 'is_active') {
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
     * @return \App\Models\AcceptedDomain|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): AcceptedDomain|bool
    {
        try {
            $query = $this->create([
                'domain'    => $payload['domain'],
                'type'      => $payload['type'],
                'user_id'   => $payload['user_id'],
                'is_active' => $payload['is_active'],
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
     * @return \App\Models\AcceptedDomain|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): AcceptedDomain|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'domain'    => $payload['domain'],
                'type'      => $payload['type'],
                'user_id'   => $payload['user_id'],
                'is_active' => $payload['is_active'],
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
     * Check if email provider domains exist in the database.
     * @param array $domain An array containing email provider domains to check.
     * @return array|bool An array of matching records or `false` if an error occurs.
     */
    public function checkEmailProvider(array $domain): array|bool
    {
        try {
            $result = $this->select('id', 'domain')->whereIn('domain', ['.' . $domain[0], '.' . $domain[1]])->get()->toArray();
            return $result;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get unique domain types from the database.
     * @return array|bool An array containing unique domain types or `false` if an error occurs.
     */
    public function getUniqueDomainTypes(): array|bool
    {
        try {
            $uniqueDomainTypes['type'] = $this->select('id', 'type')->get()->unique('type')->toArray();
            return $uniqueDomainTypes;
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
            'domain'    => 'text',
            'type'      => 'select',
            'user_id'   => 'number',
            'is_active' => 'boolean',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}
