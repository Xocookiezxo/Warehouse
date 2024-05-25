<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Product
 *
 * @package App\Models
 * @version May 23, 2024, 4:58 am UTC
 * @property \App\Models\ProductCategory $productCategory
 * @property \App\Models\Provider $provider
 * @property \Illuminate\Database\Eloquent\Collection $brancheHaveProducts
 * @property string $name Нэр
 * @property integer $provider_id Нийлүүлэгч
 * @property string $barcode Баркод
 * @property number $price Үнэ
 * @property integer $product_category_id Бүтгээгдэхүүны төрөл
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $branche_have_products_count
 * @property-read \App\Models\ProductCategory $product_category
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product filter(array $filters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBarcode($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereProductCategoryId($value)
 * @method static Builder|Product whereProviderId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'products';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'provider_id',
        'barcode',
        'price',
        'product_category_id',
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
        'provider_id' => 'integer',
        'barcode' => 'string',
        'price' => 'decimal:2',
        'product_category_id' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:1000',
        'provider_id' => 'required',
        'barcode' => 'required|string|max:1000',
        'price' => 'required|numeric',
        'product_category_id' => 'required',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product_category()
    {
        return $this->belongsTo(\App\Models\ProductCategory::class, 'product_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function provider()
    {
        return $this->belongsTo(\App\Models\Provider::class, 'provider_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function brancheHaveProducts()
    {
        return $this->hasMany(\App\Models\BrancheHaveProduct::class, 'product_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'provider_id',
        'barcode',
        'price',
        'product_category_id',
        'description'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return Product::$searchIn;
    }
}
