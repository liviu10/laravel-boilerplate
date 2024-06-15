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
 * Class ContactSubject
 * @package App\Models
 */
class ContactSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'label',
        'is_active',
        'user_id',
    ];

    protected $inputs = [
        [
            'id' => 1,
            'key' => 'label',
            'type' => 'text',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
        ],
        [
            'id' => 2,
            'key' => 'is_active',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => true,
            'is_edit' => true,
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
        'is_active' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
        'user_id' => 'integer',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function contact_messages(): HasMany
    {
        return $this->hasMany('App\Models\ContactMessage');
    }

    public function fetchAllRecords(array $search = []): Collection|LengthAwarePaginator|Exception
    {
        try {
            $query = $this->select('id', 'value', 'label', 'is_active', 'user_id')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            $query = $query->get();
            $query->each(function ($item) {
                $item->makeHidden('user_id');
            });

            return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): ContactSubject|Exception
    {
        try {
            return $this->create([
                'value' => $payload['value'],
                'label' => $payload['label'],
                'is_active' => $payload['is_active'],
                'user_id' => $payload['user_id'],
            ]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function fetchSingleRecord(int $id): Collection|Exception
    {
        try {
            $query = $this->select('*')
                ->where('id', '=', $id)
                ->with([
                    'contact_messages' => function ($query) {
                        $query->select(
                            'id',
                            'contact_subject_id',
                            'full_name',
                            'email',
                            'privacy_policy',
                            'terms_and_conditions',
                            'data_protection',
                        );
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

                $query = $query->get();
                $query->each(function ($item) {
                    $item->makeHidden('user_id');
                });

                return $query;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): ContactSubject|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'value' => $payload['value'],
                'label' => $payload['label'],
                'is_active' => $payload['is_active'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): ContactSubject|Exception
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
            if ($input['key'] === 'is_active') {
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
                break;
            }
        }

        return $inputs;
    }
}
