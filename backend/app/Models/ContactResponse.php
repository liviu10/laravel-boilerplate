<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogErrors;

/**
 * Class ContactResponse
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
 * @method fetchAllContactResponseMessage
 * @method saveContactResponseMessage
 */
class ContactResponse extends Model
{
    use HasFactory, LogErrors;

    /**
     * The name of the database table associated with the model.
     * @var string
     */
    protected $table = 'contact_responses';

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
    protected $foreignKey = 'contact_id';

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
        'message',
        'contact_id'
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
     * Get the contact responses that have many contact me messages.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->hasMany('App\Models\Contact');
    }

    /**
     * Save the contact responses into the database.
     * @param array $payload An associative array of values to create a new contact responses.
     * @return \App\Models\ContactResponse|bool Returns a contact responses object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during registration.
     */
    public function saveContactResponse(array $payload)
    {
        try
        {
            $contactResponses = $this->create([
                'message' => $payload['message'],
                'contact_id' => $payload['id']
            ]);
            return $contactResponses;
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
