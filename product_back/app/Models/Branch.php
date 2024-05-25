<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Branch
 *
 * @package App\Models
 * @version May 23, 2024, 5:25 am UTC
 * @property \Illuminate\Database\Eloquent\Collection $brancheHaveProducts
 * @property string $name Нэр
 * @property string $address Хаяг
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $branche_have_products_count
 * @method static \Database\Factories\BranchFactory factory($count = null, $state = [])
 * @method static Builder|Branch filter(array $filters)
 * @method static Builder|Branch newModelQuery()
 * @method static Builder|Branch newQuery()
 * @method static Builder|Branch query()
 * @method static Builder|Branch whereAddress($value)
 * @method static Builder|Branch whereCreatedAt($value)
 * @method static Builder|Branch whereDescription($value)
 * @method static Builder|Branch whereId($value)
 * @method static Builder|Branch whereName($value)
 * @method static Builder|Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'branches';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'address',
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
        'address' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:1000',
        'address' => 'required|string|max:1000',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function brancheHaveProducts()
    {
        return $this->hasMany(\App\Models\BrancheHaveProduct::class, 'branch_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'address',
        'description'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return Branch::$searchIn;
    }
}
