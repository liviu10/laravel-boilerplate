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
 * Class General
 * @package App\Models

 * @property int $id
 * @property string $type
 * @property string $label
 * @property string $value
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method updateRecord
 * @method deleteRecord
 */
class General extends BaseModel
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'generals';

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
        'type',
        'label',
        'value',
        'user_id',
    ];

    /**
     * The general type options.
     * @var array<string>
     */
    protected $generalTypeOptions = [
        'General',
        'Writing',
        'Reading',
        'Discussion',
        'Media',
        'Performance',
        'Notifications',
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
            'user_id' => 'integer',
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
     * @return \App\Models\General|bool The newly created
     * User instance, or `false` if an error occurs.
     */
    public function createRecord(array $payload): General|bool
    {
        try {
            $query = $this->create([
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
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
     * Update a record in the database.
     * @param array $payload An associative array containing the updated record data.
     * @param int $id The unique identifier of the record to update.
     * @return \App\Models\General|bool The freshly updated User instance, or `false` if an error occurs.
     */
    public function updateRecord(array $payload, int $id): General|bool
    {
        try {
            $query = tap($this->find($id))->update([
                'type'    => $payload['type'],
                'label'   => $payload['label'],
                'value'   => $payload['value'],
                'user_id' => $payload['user_id'],
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
            'type'    => 'text',
            'label'   => 'text',
            'value'   => 'text',
            'user_id' => 'number',
        ];

        $excludedFields = ['user_id'];

        return $this->handleFilterAvailableFields($fieldTypes, $excludedFields);
    }

    /**
     * Get the general type options.
     * @return array An array containing the general type options.
     */
    public function getGeneralTypeOptions(): array
    {
        return $this->generalTypeOptions;
    }
}
