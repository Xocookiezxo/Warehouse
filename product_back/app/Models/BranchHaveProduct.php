<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BranchHaveProduct
 *
 * @package App\Models
 * @version May 23, 2024, 5:53 am UTC
 * @property \App\Models\Branch $branch
 * @property \App\Models\Product $product
 * @property \App\Models\User $user
 * @property integer $branch_id
 * @property integer $product_id
 * @property integer $pcount тоо
 * @property string $reg_type Зарлага эсэх
 * @property integer $user_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BranchHaveProductFactory factory($count = null, $state = [])
 * @method static Builder|BranchHaveProduct filter(array $filters)
 * @method static Builder|BranchHaveProduct newModelQuery()
 * @method static Builder|BranchHaveProduct newQuery()
 * @method static Builder|BranchHaveProduct query()
 * @method static Builder|BranchHaveProduct whereBranchId($value)
 * @method static Builder|BranchHaveProduct whereCreatedAt($value)
 * @method static Builder|BranchHaveProduct whereId($value)
 * @method static Builder|BranchHaveProduct wherePcount($value)
 * @method static Builder|BranchHaveProduct whereProductId($value)
 * @method static Builder|BranchHaveProduct whereRegType($value)
 * @method static Builder|BranchHaveProduct whereUpdatedAt($value)
 * @method static Builder|BranchHaveProduct whereUserId($value)
 * @mixin \Eloquent
 */
class BranchHaveProduct extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'branche_have_products';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'branch_id',
        'product_id',
        'pcount',
        'reg_type',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'branch_id' => 'integer',
        'product_id' => 'integer',
        'pcount' => 'integer',
        'reg_type' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'branch_id' => 'required',
        'product_id' => 'required',
        'pcount' => 'required|integer',
        'reg_type' => 'required|string|max:255',
        'user_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'branch_id',
        'product_id',
        'pcount',
        'reg_type',
        'user_id'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return BranchHaveProduct::$searchIn;
    }
}
