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
 * @method getFields
 */
class Appreciation extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'appreciations';

    protected $fillable = [
        'likes',
        'dislikes',
        'rating',
        'content_id',
        'user_id',
    ];

    protected $statisticalIndicators = [
        'likes',
        'dislikes',
        'rating',
        'content_id',
        'user_id',
    ];

    protected $resources = [
        'appreciations.index',
        'appreciations.create',
        'appreciations.show',
        'appreciations.update',
        'appreciations.destroy',
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'likes'      => 'integer',
            'dislikes'   => 'integer',
            'rating'     => 'integer',
            'content_id' => 'integer',
            'user_id'    => 'integer',
        ]);
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
            $query = $this->all();

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    $query->where($field, '=', $value);
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } else {
                return $query;
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
     * @return \App\Models\Appreciation|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Appreciation|bool
    {
        try {
            $query = $this->create([
                'likes'      => $payload['likes'],
                'dislikes'   => $payload['dislikes'],
                'rating'     => $payload['rating'],
                'content_id' => $payload['content_id'],
                'user_id'    => $payload['user_id'],
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
                // TODO: get relation content_id and user_id
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
     * @return \App\Models\Appreciation|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Appreciation|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'likes'      => $payload['likes'],
                'dislikes'   => $payload['dislikes'],
                'rating'     => $payload['rating'],
                'content_id' => $payload['content_id'],
                'user_id'    => $payload['user_id'],
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
            'likes'      => 'number',
            'dislikes'   => 'number',
            'rating'     => 'number',
            'content_id' => 'number',
            'user_id'    => 'number',
        ];

        $excludedFields = ['content_id', 'user_id'];

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
