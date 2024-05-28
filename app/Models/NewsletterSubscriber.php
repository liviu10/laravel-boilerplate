<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class NewsletterSubscriber
 * @package App\Models
 */
class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'newsletter_campaign_id',
        'full_name',
        'email',
        'privacy_policy',
        'terms_and_conditions',
        'data_protection',
        'valid_email',
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
        'privacy_policy' => 'boolean',
        'terms_and_conditions' => 'boolean',
        'data_protection' => 'boolean',
        'valid_email' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    protected $attributes = [
        'privacy_policy' => false,
        'terms_and_conditions' => false,
        'data_protection' => false,
        'valid_email' => false,
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
                'full_name',
                'email',
                'privacy_policy',
                'terms_and_conditions',
                'data_protection',
                'valid_email',
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
                    if ($field === 'id' || $field === 'newsletter_campaign_id' ||
                        $field === 'privacy_policy' || $field === 'terms_and_conditions' || $field === 'data_protection' || $field === 'valid_email') {
                        $query->where($field, '=', $value);
                    } elseif ($field === 'newsletter_campaign_ids') {
                        $query->whereIn('newsletter_campaign_id', $value);
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

    public function fetchNewsletterSubscriberCampaigns(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'newsletter_campaign_id',
                'full_name',
                'email',
                'privacy_policy',
                'terms_and_conditions',
                'data_protection',
                'valid_email',
            )->with([
                'newsletter_campaign' => function ($query) {
                    $query->select(
                        'id',
                        'name',
                        'description',
                        'valid_from',
                        'valid_to',
                        'occur_times',
                        'occur_week',
                        'occur_day',
                        'occur_hour'
                    );
                }
            ]);

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'newsletter_campaign_ids') {
                        $query->whereIn('newsletter_campaign_id', $value);
                    } else {
                        $query->where($field, $value);
                    }
                }
            }

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): NewsletterSubscriber|Exception
    {
        try {
            return $this->create([
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'privacy_policy' => $payload['privacy_policy'],
                'terms_and_conditions' => $payload['terms_and_conditions'],
                'data_protection' => $payload['data_protection'],
                'valid_email' => $payload['valid_email'],
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
                    'newsletter_campaign' => function ($query) {
                        $query->select(
                            'id',
                            'name',
                            'description',
                            'valid_from',
                            'valid_to',
                            'occur_times',
                            'occur_week',
                            'occur_day',
                            'occur_hour'
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

    public function updateRecord(array $payload, int $id): NewsletterSubscriber|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'newsletter_campaign_id' => $payload['newsletter_campaign_id'],
                'full_name' => $payload['full_name'],
                'email' => $payload['email'],
                'privacy_policy' => $payload['privacy_policy'],
                'terms_and_conditions' => $payload['terms_and_conditions'],
                'data_protection' => $payload['data_protection'],
                'valid_email' => $payload['valid_email'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): NewsletterSubscriber|Exception
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
