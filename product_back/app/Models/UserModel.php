<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserModel
 *
 * @package App\Models
 * @version May 26, 2024, 6:04 pm UTC
 * @property \App\Models\Branch $branch
 * @property \Illuminate\Database\Eloquent\Collection $brancheHaveProducts
 * @property string $register Регистр
 * @property string $ovog Овог
 * @property string $name Нэр
 * @property integer $branch_id Салбар
 * @property string $phone Утас
 * @property string $username Нэвтрэх нэр
 * @property string $password Нууц үг
 * @property string $roles Эрхийн түвшин
 * @property string $remember_token
 * @property string $push_token
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Database\Factories\UserModelFactory factory($count = null, $state = [])
 * @method static Builder|UserModel filter(array $filters)
 * @method static Builder|UserModel newModelQuery()
 * @method static Builder|UserModel newQuery()
 * @method static Builder|UserModel query()
 * @method static Builder|UserModel whereBranchId($value)
 * @method static Builder|UserModel whereCreatedAt($value)
 * @method static Builder|UserModel whereDeletedAt($value)
 * @method static Builder|UserModel whereId($value)
 * @method static Builder|UserModel whereName($value)
 * @method static Builder|UserModel whereOvog($value)
 * @method static Builder|UserModel wherePassword($value)
 * @method static Builder|UserModel wherePhone($value)
 * @method static Builder|UserModel wherePushToken($value)
 * @method static Builder|UserModel whereRegister($value)
 * @method static Builder|UserModel whereRememberToken($value)
 * @method static Builder|UserModel whereRoles($value)
 * @method static Builder|UserModel whereUpdatedAt($value)
 * @method static Builder|UserModel whereUsername($value)
 * @mixin \Eloquent
 */
class UserModel extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'register',
        'ovog',
        'name',
        'branch_id',
        'phone',
        'username',
        'password',
        'roles',
        'remember_token',
        'push_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'register' => 'string',
        'ovog' => 'string',
        'name' => 'string',
        'branch_id' => 'integer',
        'phone' => 'string',
        'username' => 'string',
        'password' => 'string',
        'roles' => 'string',
        'remember_token' => 'string',
        'push_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register' => 'nullable|string|max:255',
        'ovog' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'branch_id' => 'required',
        'phone' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255',
        'password' => 'required|string|max:255',
        'roles' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'push_token' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function brancheHaveProducts()
    {
        return $this->hasMany(\App\Models\BrancheHaveProduct::class, 'user_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'register',
        'ovog',
        'name',
        'branch_id',
        'phone',
        'username',
        'password',
        'roles',
        'remember_token',
        'push_token'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return UserModel::$searchIn;
    }
}
