<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiLogError;
use App\Traits\ApiDataModel;
use App\Traits\ApiFilters;

/**
 * Class Field
 * @package App\Models\Admin\Settings

 * @property int $id
 * @property int $fieldable_id
 * @property string $fieldable_type
 * @property string $key
 * @property string $type
 * @property boolean $is_field
 * @property boolean $is_filter
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Field extends Model
{
    use HasFactory, ApiLogError, ApiDataModel, ApiFilters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fields';

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
        'key',
        'type',
        'is_field',
        'is_filter',
        'is_active',
    ];

    /**
    * The attributes that are mass assignable.
    *
    * @var string
    */
    protected $attributes = [
        'is_field'  => false,
        'is_filter' => false,
        'is_active' => false,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'           => 'integer',
        'fieldable_id' => 'integer',
        'is_field'     => 'boolean',
        'is_filter'    => 'boolean',
        'is_active'    => 'boolean',
        'created_at'   => 'datetime:d.m.Y H:i',
        'updated_at'   => 'datetime:d.m.Y H:i',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'fieldable_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent polymorphic relationship between all models and fields.
     *
     */
    public function fieldable()
    {
        return $this->morphTo();
    }
}
