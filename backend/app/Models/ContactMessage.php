<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContactMessage
 * @package App\Models

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
class ContactMessage extends BaseModel
{
    use HasFactory, LogApiError, SoftDeletes;

    protected $table = 'contact_messages';

    protected $foreignKey = 'contact_subject_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'message',
        'privacy_policy',
        'contact_subject_id',
    ];

    protected $resources = [
        'contact-messages.index',
        'contact-messages.create',
        'contact-messages.show',
        'contact-messages.update',
        'contact-messages.destroy',
    ];

    protected $attributes = [
        'privacy_policy' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'privacy_policy'     => 'boolean',
            'contact_subject_id' => 'integer',
        ]);
    }

    public function contact_subject()
    {
        return $this->belongsTo('App\Models\ContactSubject');
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
                'full_name',
                'email',
                'phone',
                'privacy_policy',
                'contact_subject_id'
            )
                ->with([
                    'contact_subject' => function ($query) {
                        $query->select('id', 'name');
                    }
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'privacy_policy' || $field === 'contact_subject_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } elseif ($type === 'restore') {
                return $query->onlyTrashed()->select('id', 'full_name')->get();
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
     * @return \App\Models\ContactMessage|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ContactMessage|bool
    {
        try {
            $query = $this->create([
                'full_name'          => $payload['full_name'],
                'email'              => $payload['email'],
                'phone'              => $payload['phone'],
                'message'            => $payload['message'],
                'privacy_policy'     => $payload['privacy_policy'],
                'contact_subject_id' => $payload['contact_subject_id'],
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
                return $query->with([
                    'contact_subject' => function ($query) {
                        $query->select('id', 'name');
                    }
                ])->get();
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
     * @return \App\Models\ContactMessage|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ContactMessage|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'full_name'          => $payload['full_name'],
                'email'              => $payload['email'],
                'phone'              => $payload['phone'],
                'message'            => $payload['message'],
                'privacy_policy'     => $payload['privacy_policy'],
                'contact_subject_id' => $payload['contact_subject_id'],
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
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}
