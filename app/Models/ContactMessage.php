<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;


/**
 * Class ContactMessage
 * @package App\Models
 */
class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'contact_subject_id',
        'message',
        'privacy_policy',
        'terms_and_conditions',
        'user_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'contact_subject_id' => 'integer',
        'privacy_policy' => 'boolean',
        'terms_and_conditions' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'privacy_policy' => false,
        'terms_and_conditions' => false,
    ];

    public function contact_subject(): BelongsTo
    {
        return $this->belongsTo('App\Models\ContactSubject');
    }

    public function contact_responses(): HasMany
    {
        return $this->hasMany('App\Models\ContactResponse');
    }

    public function fetchAllRecords(array $search = []): Collection|LengthAwarePaginator|Exception
    {
        try {
            $query = $this->select(
                'id',
                'contact_subject_id',
                'full_name',
                'email',
                'phone',
                'privacy_policy',
                'terms_and_conditions',
            )->with([
                'contact_subject' => function ($query) {
                    $query->select('id', 'label')->where('is_active', true);
                },
                'user' => function ($query) {
                    $query->select('id', 'full_name');
                }
            ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'contact_subject_id' || $field === 'privacy_policy' || $field === 'terms_and_conditions') {
                        $query->where($field, '=', $value);
                    } elseif ($field === 'contact_message_ids') {
                        $query->whereIn('id', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            return $query->paginate(15);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): ContactMessage|Exception
    {
        try {
            return $this->create([
                'contact_subject_id' => $payload['contact_subject_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
                'message' => $payload['message'],
                'privacy_policy' => $payload['privacy_policy'],
                'terms_and_conditions' => $payload['terms_and_conditions'],
                'user_id' => $payload['user_id'],
            ]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function fetchSingleRecord(int $id): Collection|Exception
    {
        try {
            return $this->select('*')
                ->where('id', '=', $id)
                ->with([
                    'contact_subject' => function ($query) {
                        $query->select('id', 'label')->where('is_active', true);
                    },
                    'contact_responses' => function ($query) {
                        $query->select(
                            'id',
                            'contact_message_id',
                            'message',
                        )->with([
                            'user' => function ($query) {
                                $query->select('id', 'full_name');
                            }
                        ]);
                    },
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): ContactMessage|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'contact_subject_id' => $payload['contact_subject_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
                'message' => $payload['message'],
                'privacy_policy' => $payload['privacy_policy'],
                'terms_and_conditions' => $payload['terms_and_conditions'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): ContactMessage|Exception
    {
        try {
            $query = $this->find($id);
            $query->delete();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
