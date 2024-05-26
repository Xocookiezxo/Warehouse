<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Supply
 *
 * @package App\Models
 * @version May 26, 2024, 6:51 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection $supplyProducts
 * @property string $name нийлүүлэлтийн нэр
 * @property string $status төрөв
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SupplyFactory factory($count = null, $state = [])
 * @method static Builder|Supply filter(array $filters)
 * @method static Builder|Supply newModelQuery()
 * @method static Builder|Supply newQuery()
 * @method static Builder|Supply query()
 * @method static Builder|Supply whereCreatedAt($value)
 * @method static Builder|Supply whereDescription($value)
 * @method static Builder|Supply whereId($value)
 * @method static Builder|Supply whereName($value)
 * @method static Builder|Supply whereStatus($value)
 * @method static Builder|Supply whereUpdatedAt($value)
 * @property-read int|null $supply_products_count
 * @mixin \Eloquent
 */
class Supply extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'supplies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'status',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'status' => 'string|max:255',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function supplyProducts()
    {
        return $this->hasMany(\App\Models\SupplyProduct::class, 'supply_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'status',
        'description'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return Supply::$searchIn;
    }
}
