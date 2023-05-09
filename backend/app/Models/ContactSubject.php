<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogErrors;

/**
 * Class ContactSubject
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
 * @method fetchAllContactSubjectMessage
 * @method saveContactSubjectMessage
 */
class ContactSubject extends Model
{
    use HasFactory, LogErrors;

    /**
     * The name of the database table associated with the model.
     * @var string
     */
    protected $table = 'contact_subjects';

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
     * The list of attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
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
     * Get the contact subject that have many contact me messages.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->hasMany('App\Models\Contact');
    }

    /**
     * Get all user role types information.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of user role types with their associated information.
     * If an error occurs during retrieval, an boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the retrieval.
     */
    public function fetchAllContactSubjects()
    {
        try
        {
            return $this->select(
                'id',
                'title',
            )->get();
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
     * Save the contact subjects into the database.
     * @param array $payload An associative array of values to create a new contact subjects.
     * @return \App\Models\Contact|bool Returns a contact subjects object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during registration.
     */
    public function saveContactSubjects(array $payload)
    {
        try
        {
            $contactSubjects = $this->create([
                'title' => $payload['title'],
            ]);
            return $contactSubjects;
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
     * Update the contact subjects.
     * @param array $payload An associative array of values to update the contact subjects.
     * @param int $id The ID of the contact subjects to update.
     * @return bool Returns true if the update was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the update.
     */
    public function updateUserRole(array $payload, int $id)
    {
        try
        {
            $this->find($id)->update([
                'title' => $payload['title'],
            ]);
            return True;
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
