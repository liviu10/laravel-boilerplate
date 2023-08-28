<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogApiError;
use App\Traits\FilterAvailableFields;

/**
 * Class Report
 * @package App\Models
 *
 * @property int $id
 * @property string $label
 * @property int $value
 * @property int $percentage
 * @property \Carbon\Carbon $from
 * @property \Carbon\Carbon $to
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method fetchAllRecords
 */
class Report extends Model
{
    use HasFactory, FilterAvailableFields, LogApiError;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reports';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'label',
        'value',
        'percentage',
        'from',
        'to',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'         => 'integer',
        'value'      => 'integer',
        'from'       => 'datetime:d.m.Y H:i',
        'to'         => 'datetime:d.m.Y H:i',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent polymorphic relationship between newsletter_campaign and newsletter_logs.
     *
     */
    public function logable()
    {
        return $this->morphTo();
    }

    /**
     * Get all the records from the database.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of records.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchAllRecords()
    {
        try
        {
            $query = $this->select('id', 'reportable_id', 'reportable_type')->get()->unique('reportable_type');

            return $query;
        }
        catch (\Exception $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
    }

    /**
     * Get record details from the database.
     * @return \Illuminate\Database\Eloquent\Collection|array|boolean
     * Returns a collection of record with their associated relation.
     * If an error occurs during retrieval, a boolean will be returned.
     * @throws \Exception|\Illuminate\Database\QueryException
     * Throws an exception if an error occurs during retrieval.
     */
    public function fetchSingleRecord($reportableId)
    {
        try
        {
            $query = $this->select(
                'id',
                'label',
                'value',
                'percentage',
                'from',
                'to'
            )
            ->where('reportable_id', '=', $reportableId)
            ->get();

            return $query;
        }
        catch (\Exception $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $this->LogApiError($exception);
            return false;
        }
    }
}
