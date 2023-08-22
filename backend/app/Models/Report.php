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
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'id'         => 'integer',
        'value'      => 'integer',
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
     * Get the fillable fields for the model.
     * @return array An array containing the fillable fields for the model.
     */
    public function getFields()
    {
        $fieldTypes = [
            'label'      => 'text',
            'value'      => 'number',
            'created_at' => 'text',
        ];

        return $this->handleFilterAvailableFields($fieldTypes);
    }
}
