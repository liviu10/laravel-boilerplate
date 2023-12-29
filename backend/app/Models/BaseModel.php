<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseModel
 * @package App\Models

 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class BaseModel extends Model
{
    use LogApiError;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id'         => 'integer',
        'is_active'  => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'deleted_at' => 'datetime:d.m.Y H:i',
    ];

    /**
     * Delete a record from the database.
     * @param int $id The unique identifier of the record to delete.
     * @return mixed The freshly retrieved record after deletion, or `false` if an error occurs.
     */
    public function deleteRecord(int $id)
    {
        try {
            $query = tap($this->find($id))->delete();
            return $query->fresh();
        } catch (\Exception $exception) {
            $this->LogApiError($exception);
            return false;
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->LogApiError($exception);
            return false;
        }
    }
}
