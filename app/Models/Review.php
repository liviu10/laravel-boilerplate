<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class Review
 * @package App\Models
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'rating',
        'comment',
        'is_active',
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
            'key' => 'rating',
            'type' => 'number',
            'min' => 1,
            'max' => 30,
            'is_filter' => true,
            'is_create' => false,
            'is_edit' => false,
        ],
        [
            'id' => 3,
            'key' => 'is_active',
            'type' => 'select',
            'is_filter' => true,
            'is_create' => false,
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
        'rating' => 'integer',
        'is_active' => 'boolean',
        'user_id' => 'integer',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select('id', 'full_name', 'rating', 'is_active');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'rating' || $field === 'is_active') {
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

    public function createRecord(array $payload): Review|Exception
    {
        try {
            return $this->create([
                'full_name' => $payload['full_name'],
                'rating' => $payload['rating'],
                'comment' => $payload['comment'],
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
            return $this->select('*')
                ->where('id', '=', $id)
                ->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function updateRecord(array $payload, int $id): Review|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'full_name' => $payload['full_name'],
                'rating' => $payload['rating'],
                'comment' => $payload['comment'],
                'is_active' => $payload['is_active'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): Review|Exception
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
            }
        }

        return $inputs;
    }
}
