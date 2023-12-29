<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ConfigurationTranslation
 * @package App\Models

 * @property int $id
 * @property string $key
 * @property string $translation
 * @property string $related_model_name
 * @property int $related_model_id
 * @property int $configuration_translation_locale_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class ConfigurationTranslation extends BaseModel
{
    use HasFactory, LogApiError, SoftDeletes;

    protected $table = 'set_configuration_translations';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $configTranslationLocaleForeignKey = 'configuration_translation_locale_id';

    protected $configTranslationLocaleForeignKeyType = 'int';

    protected $fillable = [
        'key',
        'translation',
        'related_model_name',
        'related_model_id',
        'configuration_translation_locale_id',
        'user_id',
    ];

    protected $resources = [
        'configuration-resources.index',
        'configuration-resources.create',
        'configuration-resources.show',
        'configuration-resources.update',
        'configuration-resources.destroy',
    ];

    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'related_model_id' => 'integer',
            'configuration_translation_locale_id' => 'integer',
            'user_id' => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function configuration_translation_locale()
    {
        return $this->belongsTo('App\Models\ConfigurationTranslationLocale');
    }

    /**
     * Fetch records from the database based on optional search criteria.
     * @param array $search An associative array of search criteria (field => value).
     * @param string|null $type The fetch type: 'paginate'for paginated results or null for a collection.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|bool
     * A paginated result, a collection, or `false` if an error occurs.
     */
    public function fetchAllRecords(array $search = [], string|null $type = null): LengthAwarePaginator|Collection|bool
    {
        try {
            $query = $this->select('id', 'key', 'translation', 'related_model_name', 'related_model_id');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id') {
                        $query->where($field, '=', $value);
                    } else {
                        if ($field === 'related_model_name') {
                            $query->where($field, 'LIKE', $value);
                        } else {
                            $query->where($field, 'LIKE', '%' . $value . '%');
                        }
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
            } elseif ($type === 'restore') {
                return $query->onlyTrashed()->select('id', 'key', 'translation')->get();
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\ConfigurationTranslation|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): ConfigurationTranslation|bool
    {
        try {
            $query = $this->create([
                'key'                => $payload['key'],
                'translation'        => $payload['translation'],
                'related_model_name' => $payload['related_model_name'],
                'related_model_id'   => $payload['related_model_id'],
                'user_id'            => $payload['user_id'],
            ]);

            return $query;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Fetch a single record from the database by its ID.
     * @param int $id The unique identifier of the record to fetch.
     * @param string|null $type The fetch type: 'relation' to include
     * related data or null for just the record.
     * @return \Illuminate\Support\Collection|bool The fetched record or
     * related data as a Collection, or `false` if an error occurs.
     */
    public function fetchSingleRecord(int $id, string|null $type = null): Collection|bool
    {
        try {
            $query = $this->select('*')->where('id', '=', $id);

            if ($type === 'relation') {
                $query->with([
                    'configuration_translation_locale' => function ($query) {
                        $query->select(
                            'id',
                            'code',
                            'country',
                        );
                    },
                    'user' => function ($query) {
                        $query->select('id', 'full_name');
                    }
                ]);

                return $query->get();
            } else {
                return $query->get();
            }
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Update a record in the database.
     * @param array $payload An associative array containing the updated record data.
     * @param int $id The unique identifier of the record to update.
     * @return \App\Models\ConfigurationTranslation|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): ConfigurationTranslation|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'key'                => $payload['key'],
                'translation'        => $payload['translation'],
                'related_model_name' => $payload['related_model_name'],
                'related_model_id'   => $payload['related_model_id'],
                'user_id'            => $payload['user_id'],
            ]);

            return $query->fresh();
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get the resource methods for the model.
     * @return array An array containing the resource methods for the model.
     */
    public function getResources(): array
    {
        return $this->resources;
    }
}
