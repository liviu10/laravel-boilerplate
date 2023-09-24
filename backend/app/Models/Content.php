<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Content
 * @package App\Models

 * @property int $id
 * @property string $visibility
 * @property string $content_url
 * @property string $title
 * @property string $content_type
 * @property string $description
 * @property string $content
 * @property boolean $allow_comments
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 * @method getFields
 * @method getVisibilityOptions
 * @method getContentTypeOptions
 */
class Content extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    protected $table = 'contents';

    protected $foreignKey = 'user_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'visibility',
        'content_url',
        'title',
        'content_type',
        'description',
        'content',
        'allow_comments',
        'user_id',
    ];

    protected $visibilityOptions = [
        'Public', 'Private', 'Draft'
    ];

    protected $contentTypeOptions = [
        'Page', 'Article'
    ];

    protected $attributes = [
        'allow_comments' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'allow_comments' => 'boolean',
            'user_id'        => 'integer',
        ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }

    public function medias()
    {
        return $this->hasMany('App\Models\Media');
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
            $query = $this->select('id', 'visibility', 'content_url', 'title', 'content_type');

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if (
                        $field === 'id' ||
                        $field === 'visibility' ||
                        $field === 'content_type' ||
                        $field === 'allow_comments'
                    ) {
                        $query->where($field, '=', $value);
                    } else {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    }
                }
            }

            if ($type === 'paginate') {
                return $query->paginate(15);
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
     * @return \App\Models\Content|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Content|bool
    {
        try {
            $query = $this->create([
                'visibility'     => $payload['visibility'],
                'content_url'    => $payload['content_url'],
                'title'          => $payload['title'],
                'content_type'   => $payload['content_type'],
                'description'    => $payload['description'],
                'content'        => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'user_id'        => $payload['user_id'],
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
                    'tags' => function ($query) {
                        $query->select('*');
                    },
                    'medias' => function ($query) {
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
     * @return \App\Models\Content|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Content|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'visibility'     => $payload['visibility'],
                'content_url'    => $payload['content_url'],
                'title'          => $payload['title'],
                'content_type'   => $payload['content_type'],
                'description'    => $payload['description'],
                'content'        => $payload['content'],
                'allow_comments' => $payload['allow_comments'],
                'user_id'        => $payload['user_id'],
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
            'visibility'     => 'select',
            'content_url'    => 'text',
            'title'          => 'text',
            'content_type'   => 'select',
            'description'    => 'date',
            'content'        => 'number',
            'allow_comments' => 'boolean',
            'user_id'        => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the visibility options.
     * @return array An array containing the visibility options.
     */
    public function getVisibilityOptions(): array
    {
        return $this->visibilityOptions;
    }

    /**
     * Get the content type options.
     * @return array An array containing the content type options.
     */
    public function getContentTypeOptions(): array
    {
        return $this->contentTypeOptions;
    }
}
