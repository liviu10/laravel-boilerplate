<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Traits\LogApiError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class Permission
 * @package App\Models

 * @property int $id
 * @property string $name
 * @property string $description
 * @property boolean $is_active
 * @property int $role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 * @method createRecord
 * @method fetchSingleRecord
 * @method updateRecord
 * @method deleteRecord
 */
class Permission extends BaseModel
{
    use HasFactory, LogApiError;

    protected $table = 'permissions';

    protected $foreignKey = 'role_id';

    protected $foreignKeyType = 'int';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'role_id',
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    protected function getCastAttributes()
    {
        $parentCasts = parent::getCastAttributes();
        return array_merge($parentCasts, [
            'role_id' => 'integer',
        ]);
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Fetch records from the database based on optional search criteria.
     * @return \Illuminate\Pagination\LengthAwarePaginator|bool
     * A paginated result or `false` if an error occurs.
     */
    public function fetchAllRecords(): LengthAwarePaginator|bool
    {
        try {
            return $this->select('id', 'name')->paginate(15);
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Create a new record.
     * @param array $payload An associative array of values to create a new record.
     * @return \App\Models\Permission|bool Returns a user object if the creation was successful,
     * or a boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during creation.
     */
    public function createRecord($payload)
    {
        try {
            $this->create([
                'name'        => $payload['name'],
                'description' => $payload['description'],
                'is_active'   => $payload['is_active'],
                'role_id'     => $payload['role_id'],
            ]);

            return True;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * SQL query to fetch a single record from the database.
     * @param  int  $id
     * @return  Collection|Bool
     */
    public function fetchSingleRecord($id)
    {
        try {
            return $this->select('*')
                ->where('id', '=', $id)
                ->get();
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Update the record.
     * @param array $payload An associative array of values to update the record.
     * @param int $id The ID of the user to update.
     * @return bool Returns true if the update was successful,
     * or an boolean otherwise.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during the update.
     */
    public function updateRecord($payload, $id)
    {
        try {
            $this->find($id)->update([
                'name'        => $payload['name'],
                'description' => $payload['description'],
                'is_active'   => $payload['is_active'],
                'role_id'     => $payload['role_id'],
            ]);

            return True;
        } catch (Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }
}
