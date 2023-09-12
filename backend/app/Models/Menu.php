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
 * Class Menu
 * @package App\Models

 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $component
 * @property string $layout
 * @property string $title
 * @property string $caption
 * @property string $icon
 * @property boolean $is_active
 * @property boolean $requires_auth
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method updateRecord
 */
class Menu extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'menus';

    /**
     * The foreign key associated with the table.
     * @var string
     */
    protected $foreignKey = 'user_id';

    /**
     * The data type of the database table foreign key.
     * @var string
     */
    protected $foreignKeyType = 'int';

    /**
     * The attributes that are mass assignable.
     * @var array<string>
     */
    protected $fillable = [
        'path',
        'name',
        'component',
        'layout',
        'title',
        'caption',
        'icon',
        'is_active',
        'requires_auth',
        'user_id',
    ];

    /**
     * The attributes that are mass assignable.
     * @var string
     */
    protected $attributes = [
        'is_active'     => false,
        'requires_auth' => false,
    ];

    /**
     * Get the type casts for the model attributes.
     * This method allows you to customize the attribute type casts for the model.
     * It merges the parent model's casts with any additional or modified casts
     * specific to the child model.
     * @return array
     */
    protected function getCastAttributes(): array
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'requires_auth' => 'boolean',
            'user_id'       => 'integer',
        ]);
    }

    /**
     * Eloquent relationship between accepted domains and users.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
            $query = $this->select(
                'id',
                'path',
                'name',
                'component',
                'layout',
                'title',
                'caption',
                'icon',
                'is_active',
                'requires_auth',
            );

            if (!empty($search)) {
                foreach ($search as $field => $value) {
                    if ($field === 'id' || $field === 'type' || $field === 'is_active') {
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
     * @return \App\Models\Menu|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): Menu|bool
    {
        try {
            $query = $this->create([
                'path'          => $payload['path'],
                'name'          => $payload['name'],
                'component'     => $payload['component'],
                'layout'        => $payload['layout'],
                'title'         => $payload['title'],
                'caption'       => $payload['caption'],
                'icon'          => $payload['icon'],
                'is_active'     => $payload['is_active'],
                'requires_auth' => $payload['requires_auth'],
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
     * @return \App\Models\Menu|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): Menu|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'path'          => $payload['path'],
                'name'          => $payload['name'],
                'component'     => $payload['component'],
                'layout'        => $payload['layout'],
                'title'         => $payload['title'],
                'caption'       => $payload['caption'],
                'icon'          => $payload['icon'],
                'is_active'     => $payload['is_active'],
                'requires_auth' => $payload['requires_auth'],
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
            'path'          => 'text',
            'name'          => 'text',
            'component'     => 'text',
            'layout'        => 'text',
            'title'         => 'text',
            'caption'       => 'text',
            'icon'          => 'text',
            'is_active'     => 'boolean',
            'requires_auth' => 'boolean',
            'user_id'       => 'number',
        ];

        $excludedFields = [
            'component',
            'layout',
            'caption',
            'icon',
            'user_id'
        ];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }
}
