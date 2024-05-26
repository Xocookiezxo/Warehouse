<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SupplyProduct
 *
 * @package App\Models
 * @version May 26, 2024, 6:51 pm UTC
 * @property \App\Models\Product $product
 * @property \App\Models\Supply $supply
 * @property integer $supply_id Нийлүүлэлт
 * @property integer $product_id Бүтээгдэхүүн
 * @property integer $expected_count тоо
 * @property integer $pcount тоо
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SupplyProductFactory factory($count = null, $state = [])
 * @method static Builder|SupplyProduct filter(array $filters)
 * @method static Builder|SupplyProduct newModelQuery()
 * @method static Builder|SupplyProduct newQuery()
 * @method static Builder|SupplyProduct query()
 * @method static Builder|SupplyProduct whereCreatedAt($value)
 * @method static Builder|SupplyProduct whereDescription($value)
 * @method static Builder|SupplyProduct whereExpectedCount($value)
 * @method static Builder|SupplyProduct whereId($value)
 * @method static Builder|SupplyProduct wherePcount($value)
 * @method static Builder|SupplyProduct whereProductId($value)
 * @method static Builder|SupplyProduct whereSupplyId($value)
 * @method static Builder|SupplyProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupplyProduct extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'supply_products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'supply_id',
        'product_id',
        'expected_count',
        'pcount',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'supply_id' => 'integer',
        'product_id' => 'integer',
        'expected_count' => 'integer',
        'pcount' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'supply_id' => 'required',
        'product_id' => 'required',
        'expected_count' => 'required|integer',
        'pcount' => 'nullable|integer',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function supply()
    {
        return $this->belongsTo(\App\Models\Supply::class, 'supply_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'supply_id',
        'product_id',
        'expected_count',
        'pcount',
        'description'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return SupplyProduct::$searchIn;
    }
}
