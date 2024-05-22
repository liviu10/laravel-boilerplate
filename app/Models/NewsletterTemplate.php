<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class NewsletterTemplate
 * @package App\Models
 */
class NewsletterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'newsletter_campaign_id',
        'path',
        'template',
        'is_active',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'newsletter_campaign_id' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    public function newsletter_campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\NewsletterCampaign');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'newsletter_campaign_id',
                'path',
                'is_active',
            )->with([
                'newsletter_campaign' => function ($query) {
                    $query->select('id', 'name');
                },
                'user' => function ($query) {
                    $query->select('id', 'full_name');
                }
            ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'newsletter_campaign_id' || $field === 'is_active') {
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

    public function createRecord(array $payload): NewsletterTemplate|Exception
    {
        try {
            return $this->create([
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
                'path' => $payload['path'],
                'is_active' => $payload['is_active'],
                'template' => $payload['template'],
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
                    'newsletter_subscribers' => function ($query) {
                        $query->select(
                            'id',
                            'newsletter_campaign_id',
                            'name',
                            'is_active',
                            'valid_from',
                            'valid_to',
                            'occur_times',
                            'occur_week',
                            'occur_day',
                            'occur_hour',
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

    public function updateRecord(array $payload, int $id): NewsletterTemplate|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
                'path' => $payload['path'],
                'is_active' => $payload['is_active'],
                'template' => $payload['template'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): NewsletterTemplate|Exception
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
