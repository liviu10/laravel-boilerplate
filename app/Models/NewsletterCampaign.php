<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Collection;
use Exception;


/**
 * Class NewsletterCampaign
 * @package App\Models
 */
class NewsletterCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'valid_from',
        'valid_to',
        'occur_times',
        'occur_week',
        'occur_day',
        'occur_hour',
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
        'is_active' => 'boolean',
        'valid_from' => 'datetime:d.m.Y',
        'valid_to' => 'datetime:d.m.Y',
        'occur_times' => 'integer',
        'occur_week' => 'integer',
        'occur_day' => 'integer',
        'occur_hour' => 'datetime:H:i:s',
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

    public function newsletter_subscribers(): HasMany
    {
        return $this->hasMany('App\Models\NewsletterSubscriber');
    }

    public function newsletter_templates(): HasOne
    {
        return $this->hasOne('App\Models\NewsletterTemplate');
    }

    public function fetchAllRecords(array $search = []): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
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

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'is_active' || $field === 'valid_from' || $field === 'valid_to' ||
                        $field === 'occur_times' || $field === 'occur_week' || $field === 'occur_day' || $field === 'occur_hour') {
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

    public function fetchClientCampaigns(): Collection|Exception
    {
        try {
            $query = $this->select(
                'id',
                'name',
                'description',
            )
                ->where('is_active', true)
                ->where('valid_from', '>=', Carbon::now()->startOfMonth())
                ->where('valid_to', '<=', Carbon::now()->endOfMonth());

            return $query->get();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function createRecord(array $payload): NewsletterCampaign|Exception
    {
        try {
            return $this->create([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'is_active' => $payload['is_active'],
                'valid_from' => $payload['valid_from'],
                'valid_to' => $payload['valid_to'],
                'occur_times' => $payload['occur_times'],
                'occur_week' => $payload['occur_week'],
                'occur_day' => $payload['occur_day'],
                'occur_hour' => $payload['occur_hour'],
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
                    'newsletter_subscribers' => function ($query) {
                        $query->select(
                            'id',
                            'newsletter_campaign_id',
                            'full_name',
                            'email',
                            'privacy_policy',
                            'valid_email',
                        );
                    },
                    'newsletter_templates' => function ($query) {
                        $query->select(
                            'id',
                            'newsletter_campaign_id',
                            'path',
                        )->where('is_active', true);
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

    public function updateRecord(array $payload, int $id): NewsletterCampaign|Exception
    {
        try {
            $query = tap($this->find($id))->update([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'is_active' => $payload['is_active'],
                'valid_from' => $payload['valid_from'],
                'valid_to' => $payload['valid_to'],
                'occur_times' => $payload['occur_times'],
                'occur_week' => $payload['occur_week'],
                'occur_day' => $payload['occur_day'],
                'occur_hour' => $payload['occur_hour'],
                'user_id' => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function deleteRecord(string $id): NewsletterCampaign|Exception
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
