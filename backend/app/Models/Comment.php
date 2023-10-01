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
 * @method getFields
 * @method getCommentTypeOptions
 * @method getCommentStatusOptions
 */
class Comment extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'comments';

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

    protected $statisticalIndicators = [
        'type',
        'status',
        'notify_new_comments',
        'content_id',
        'user_id',
    ];

    protected $resources = [
        'comments.index',
        'comments.create',
        'comments.show',
        'comments.update',
        'comments.destroy',
    ];

    protected $commentTypeOptions = [
        'Comment', 'Reply'
    ];

    protected $commentStatusOptions = [
        'Pending', 'Approved', 'Spam', 'Trash'
    ];

    protected $attributes = [
        'notify_new_comments' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'notify_new_comments' => 'boolean',
            'content_id'          => 'integer',
            'user_id'             => 'integer',
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
            $query = $this->select('*');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'type' || $field === 'status' || $field === 'notify_new_comments') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
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
     * @return \App\Models\Comment|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Comment|bool
    {
        try {
            $query = $this->create([
                'type'                => $payload['type'],
                'status'              => $payload['status'],
                'full_name'           => $payload['full_name'],
                'email'               => $payload['email'],
                'message'             => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
                'content_id'          => $payload['content_id'],
                'user_id'             => $payload['user_id'],
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
     * @return \App\Models\Comment|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Comment|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'                => $payload['type'],
                'status'              => $payload['status'],
                'full_name'           => $payload['full_name'],
                'email'               => $payload['email'],
                'message'             => $payload['message'],
                'notify_new_comments' => $payload['notify_new_comments'],
                'content_id'          => $payload['content_id'],
                'user_id'             => $payload['user_id'],
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
    public function getCommentTypeOptions(): array
    {
        return $this->commentTypeOptions;
    }

    /**
     * Get the content status options.
     * @return array An array containing the content status options.
     */
    public function getCommentStatusOptions(): array
    {
        return $this->commentStatusOptions;
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
