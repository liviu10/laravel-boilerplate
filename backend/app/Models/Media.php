<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

/**
 * Class Media
 * @package App\Models

 * @property int $id
 * @property string $type
 * @property string $internal_path
 * @property string $external_path
 * @property int $content_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class Media extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'medias';

    /**
     * The foreign key associated with the table.
     * @var string
     */
    protected $foreignKey = 'content_id';

    /**
     * The data type of the database table foreign key.
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The foreign key associated with the table.
     * @var string
     */
    protected $userIdForeignKey = 'user_id';

    /**
     * The data type of the database table foreign key.
     * @var string
     */
    protected $userIdForeignKeyType = 'int';

    /**
     * The attributes that are mass assignable.
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'internal_path',
        'external_path',
        'content_id',
        'user_id',
    ];

    /**
     * The media type options.
     * @var array<string>
     */
    protected $mediaTypeOptions = [
        'Images', 'Documents', 'Videos', 'Audio', 'Others'
    ];

    /**
     * Get the type casts for the model attributes.
     * This method allows you to customize the attribute type casts for the model.
     * It merges the parent model's casts with any additional or modified casts
     * specific to the child model.
     * @return array
     */
    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'content_id' => 'integer',
            'user_id'    => 'integer',
        ]);
    }

    /**
     * Eloquent relationship between medias and users.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Eloquent relationship between medias and contents.
     */
    public function content()
    {
        return $this->belongsTo('App\Models\Content');
    }

    /**
     * Fetch records from the database based on optional search criteria.
     * @param array $search An associative array of search criteria (field => value).
     * @param string|null $type The fetch type: 'paginate'for paginated results or null for a collection.
     * @return \Illuminate\Support\Collection|bool
     * A paginated result, a collection, or `false` if an error occurs.
     */
    public function fetchAllRecords(array $search = []): Collection|bool
    {
        try {
            $query = $this->all();

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'type') {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

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
     * Create a new record in the database.
     * @param array $payload An associative array containing record data.
     * @return \App\Models\Media|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Media|bool
    {
        try {
            $query = $this->create([
                'type'          => $payload['type'],
                'internal_path' => $payload['internal_path'],
                'external_path' => $payload['external_path'],
                'content_id'    => $payload['content_id'],
                'user_id'       => $payload['user_id'],
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
                    'content' => function ($query) {
                        $query->select('*');
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
     * @return \App\Models\Media|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Media|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'          => $payload['type'],
                'internal_path' => $payload['internal_path'],
                'external_path' => $payload['external_path'],
                'content_id'    => $payload['content_id'],
                'user_id'       => $payload['user_id'],
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
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields(): array
    {
        $fieldTypes = [
            'type'          => 'select',
            'internal_path' => 'text',
            'external_path' => 'text',
            'content_id'    => 'number',
            'user_id'       => 'number',
        ];

        $excludedFields = ['content_id', 'user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the media type options.
     * @return array An array containing the media type options.
     */
    public function getMediaTypeOptions(): array
    {
        return $this->mediaTypeOptions;
    }
}
