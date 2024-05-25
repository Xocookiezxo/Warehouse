<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserModel
 *
 * @package App\Models
 * @version May 23, 2024, 3:09 am UTC
 * @property string $name Нэр
 * @property string $phone Утас
 * @property string $username Нэр
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
 * @method static Builder|UserModel whereCreatedAt($value)
 * @method static Builder|UserModel whereDeletedAt($value)
 * @method static Builder|UserModel whereId($value)
 * @method static Builder|UserModel whereName($value)
 * @method static Builder|UserModel wherePassword($value)
 * @method static Builder|UserModel wherePhone($value)
 * @method static Builder|UserModel wherePushToken($value)
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
        'name',
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
        'name' => 'string',
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
        'name' => 'required|string|max:255',
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
     * @var array
     */
    public static $searchIn = [
        'name',
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
