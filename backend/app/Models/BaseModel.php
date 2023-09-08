<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;

/**
 * Class BaseModel
 * @package App\Models

 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method getStatisticalIndicators
 */
class BaseModel extends Model
{
    use LogApiError;

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
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

    /**
     * Get the statistical indicators for the model.
     * @return array An array containing the statistical indicators for the model.
     */
    public function getStatisticalIndicators(): array
    {
        return $this->statisticalIndicators;
    }
}
