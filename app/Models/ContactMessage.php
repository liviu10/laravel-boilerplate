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
        'data_protection',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'full_name',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 2,
            'key' => 'email',
            'type' => 'email',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 3,
            'key' => 'phone',
            'type' => 'tel',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 4,
            'key' => 'privacy_policy',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 5,
            'key' => 'terms_and_conditions',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 6,
            'key' => 'data_protection',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => false,
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
        'contact_subject_id' => 'integer',
        'privacy_policy' => 'boolean',
        'terms_and_conditions' => 'boolean',
        'data_protection' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'privacy_policy' => false,
        'terms_and_conditions' => false,
        'data_protection' => false,
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
                'data_protection',
            )
            ->with([
                'contact_subject' => function ($query) {
                    $query->select('id', 'label')
                        ->where('is_active', true)
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'full_name');
                            }
                        ]);
                },
            ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'contact_subject_id' || $field === 'privacy_policy' || $field === 'terms_and_conditions' || $field === 'data_protection') {
                        $query->where($field, '=', $value);
                    } elseif ($field === 'contact_message_ids') {
                        $query->whereIn('id', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();
            $query->each(function ($item) {
                $item->makeHidden('contact_subject_id');
            });

            return $query;
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
                'data_protection' => $payload['data_protection'],
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
                'data_protection' => $payload['data_protection'],
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

    public function getInputs(): array
    {
        $inputs = $this->inputs;
        foreach ($inputs as &$input) {
            if (
                $input['key'] === 'privacy_policy' ||
                $input['key'] === 'terms_and_conditions' ||
                $input['key'] === 'data_protection'
            ) {
                $input['options'] = [
                    [
                        'id' => 1,
                        'value' => 0,
                        'label' => __('No'),
                    ],
                    [
                        'id' => 2,
                        'value' => 1,
                        'label' => __('Yes'),
                    ],
                ];
            }
        }

        return $inputs;
    }
}
