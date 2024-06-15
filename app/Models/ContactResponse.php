<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class ContactResponse
 * @package App\Models
 */
class ContactResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_message_id',
        'message',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'from',
            'type' => 'email',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 2,
            'key' => 'to',
            'type' => 'email',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 3,
            'key' => 'subject',
            'type' => 'text',
            'is_filter' => false,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 4,
            'key' => 'message',
            'type' => 'textarea',
            'is_filter' => false,
            'is_create' => true,
            'is_edit' => false,
        ],
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'contact_message_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function contact_message(): BelongsTo
    {
        return $this->belongsTo('App\Models\ContactMessage');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'contact_message_id',
                'message',
            )->with([
                'contact_message' => function ($query) {
                    $query->select('id', 'full_name', 'email')->with([
                        'contact_subject' => function ($query) {
                            $query->select('id', 'label')->where('is_active', true);
                        }
                    ]);
                },
                'user' => function ($query) {
                    $query->select('id', 'full_name');
                }
            ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'contact_message_id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): ContactResponse|Exception
    {
        try {
            return $this->create([
                'contact_message_id' => $payload['contact_message_id'],
                'message' => $payload['message'],
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
                    'contact_message' => function ($query) {
                        $query->select('id', 'full_name', 'email', 'contact_subject_id')
                        ->with([
                            'contact_subject' => function ($query) {
                                $query->select('id', 'label')->where('is_active', true);
                            }
                        ]);
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ])
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): ContactResponse|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'contact_message_id' => $payload['contact_message_id'],
                'message' => $payload['message'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): ContactResponse|Exception
    {
        try {
            $query = $this->find($id);
            $query->delete();

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function getInputs(): array
    {
        $inputs = $this->inputs;

        return $inputs;
    }
}
