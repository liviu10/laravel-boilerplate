<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiLogError;
use App\Traits\ApiDataModel;
use App\Traits\ApiFilters;

/**
 * Class Sort
 * @package App\Models\Admin\Settings

 * @property int $id
 * @property int $sortable_id
 * @property string $sortable_type
 * @property string $value
 * @property string $label
 * @property boolean $is_order
 * @property boolean $is_sort
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Sort extends Model
{
    use HasFactory, ApiLogError, ApiDataModel, ApiFilters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sorts';

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
        'field_id',
        'value',
        'label',
        'is_order',
        'is_sort',
        'is_active',
    ];

    /**
    * The attributes that are mass assignable.
    *
    * @var string
    */
    protected $attributes = [
        'is_order'  => false,
        'is_sort'   => false,
        'is_active' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'          => 'integer',
        'field_id'    => 'integer',
        'sortable_id' => 'integer',
        'is_order'    => 'boolean',
        'is_sort'     => 'boolean',
        'is_active'   => 'boolean',
        'created_at'  => 'datetime:d.m.Y H:i',
        'updated_at'  => 'datetime:d.m.Y H:i',
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
     * Eloquent polymorphic relationship between all models and sorts.
     *
     */
    public function sortable()
    {
        return $this->morphTo();
    }
}
