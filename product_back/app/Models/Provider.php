<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Provider
 *
 * @package App\Models
 * @version May 23, 2024, 4:53 am UTC
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property string $name Нэр
 * @property string $contact Холбоо барих
 * @property string $address Хаяг
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProviderFactory factory($count = null, $state = [])
 * @method static Builder|Provider filter(array $filters)
 * @method static Builder|Provider newModelQuery()
 * @method static Builder|Provider newQuery()
 * @method static Builder|Provider query()
 * @method static Builder|Provider whereAddress($value)
 * @method static Builder|Provider whereContact($value)
 * @method static Builder|Provider whereCreatedAt($value)
 * @method static Builder|Provider whereDescription($value)
 * @method static Builder|Provider whereId($value)
 * @method static Builder|Provider whereName($value)
 * @method static Builder|Provider whereUpdatedAt($value)
 * @property-read int|null $products_count
 * @mixin \Eloquent
 */
class Provider extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'providers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'contact',
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
        'contact' => 'string',
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
        'contact' => 'required|string|max:1000',
        'address' => 'required|string|max:1000',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'provider_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'contact',
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
        return Provider::$searchIn;
    }
}
