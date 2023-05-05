<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogErrors;

/**
 * Class Contact
 * @package App\Models
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property boolean $privacy_policy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllContactMessage
 * @method saveContactMessage
 * @method deleteContactMessage
 */
class Contact extends Model
{
    use HasFactory, LogErrors;

    /**
     * The name of the database table associated with the model.
     * @var string
     */
    protected $table = 'contact';

    /**
     * The name of the primary key column in the associated database table.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the primary key column in the associated database table.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The name of the foreign key column in the associated database table.
     * @var string
     */
    protected $foreignKey = 'contact_subject_id';

    /**
     * The data type of the foreign key column in the associated database table.
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The list of attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'contact_subject_id',
        'message',
        'privacy_policy',
    ];

    /**
     * The default attribute values for the model.
     * @var array
     */
    protected $attributes = [
        'privacy_policy' => false,
    ];

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the contact me messages that belong to this contact subject.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact_subject()
    {
        return $this->belongsTo('App\Models\ContactSubject');
    }

    /**
     * Get the contact me messages that has many contact responses.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact_responses()
    {
        return $this->belongsTo('App\Models\ContactResponse');
    }

    /**
     * Get all user role types information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of user role types with their associated information.
     * If an error occurs during retrieval, an boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the retrieval.
     */
    public function fetchAllContactMessage($searchTerms = null)
    {
        try
        {
            $query = $this->select(
                'id',
                'full_name',
                'email',
                'phone',
                'contact_subject_id',
                'message',
                'privacy_policy',
                'created_at',
                'updated_at'
            )->with([
                'contact_subject' => function ($query) {
                    $query->select('id', 'title');
                },
                'contact_responses' => function ($query) {
                    $query->select('id', 'message');
                }
            ]);

            if ($searchTerms)
            {
                $searchTerms = collect($searchTerms)->except('page')->toArray();
                foreach ($searchTerms as $key => $value)
                {
                    if ($key === 'contact_subject_id' || $key === 'privacy_policy')
                    {
                        $query->where($key, $value);
                    }
                    else
                    {
                        $query->where($key, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            return $query->paginate(15)->onEachSide(2);
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }

    /**
     * Get all user role types information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of user role types with their associated information.
     * If an error occurs during retrieval, an boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the retrieval.
     */
    public function fetchSingleContactMessage($contactId)
    {
        try
        {
            $query = $this->select(
                'id',
                'full_name',
                'email',
                'phone',
                'contact_subject_id',
                'message',
                'privacy_policy',
                'created_at',
                'updated_at'
            )
            ->where('id', $contactId)
            ->with([
                'contact_subject' => function ($query) {
                    $query->select('id', 'title');
                },
                'contact_responses' => function ($query) {
                    $query->select('id', 'message');
                }
            ]);

            return $query->get();
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }

    /**
     * Save the contact message into the database.
     * @param array $payload An associative array of values to create a new contact message.
     * @return \App\Models\Contact|bool Returns a contact message object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during registration.
     */
    public function saveContactMessage(array $payload)
    {
        try
        {
            $contactMessage = $this->create([
                'full_name'      => $payload['full_name'],
                'email'          => $payload['email'],
                'phone'          => $payload['phone'],
                'subject'        => $payload['subject'],
                'message'        => $payload['message'],
                'privacy_policy' => 0,
            ]);
            return $contactMessage;
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }

    /**
     * Delete a contact message by ID.
     * @param int $id The ID of the contact message to delete.
     * @return bool Whether the contact message was successfully deleted.
     * @throws \Throwable If an error occurs while deleting the contact message.
     */
    public function deleteContactMessage(int $id)
    {
        try
        {
            $this->find($id)->delete();

            return true;
        }
        catch (\Exception $exception)
        {
            $this->logError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->logQueryError($exception);
            return false;
        }
    }
}
