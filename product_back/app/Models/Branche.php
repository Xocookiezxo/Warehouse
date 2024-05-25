<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Branche
 *
 * @package App\Models
 * @version May 23, 2024, 4:53 am UTC
 * @property \Illuminate\Database\Eloquent\Collection $brancheHaveProducts
 * @property string $name Нэр
 * @property string $address Хаяг
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BrancheFactory factory($count = null, $state = [])
 * @method static Builder|Branche filter(array $filters)
 * @method static Builder|Branche newModelQuery()
 * @method static Builder|Branche newQuery()
 * @method static Builder|Branche query()
 * @method static Builder|Branche whereAddress($value)
 * @method static Builder|Branche whereCreatedAt($value)
 * @method static Builder|Branche whereDescription($value)
 * @method static Builder|Branche whereId($value)
 * @method static Builder|Branche whereName($value)
 * @method static Builder|Branche whereUpdatedAt($value)
 * @property-read int|null $branche_have_products_count
 * @mixin \Eloquent
 */
class Branche extends Model
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
        return Branche::$searchIn;
    }
}
