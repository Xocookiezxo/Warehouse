<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BranchHaveProduct
 *
 * @package App\Models
 * @version May 25, 2024, 6:09 pm UTC
 * @property \App\Models\Branch $branch
 * @property \App\Models\Product $product
 * @property \App\Models\User $user
 * @property integer $branch_id
 * @property integer $product_id
 * @property integer $pcount тоо
 * @property string $reg_type Зарлага эсэх
 * @property integer $user_id
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BranchHaveProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct wherePcount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereRegType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchHaveProduct whereUserId($value)
 */
	class BranchHaveProduct extends \Eloquent {}
}

namespace App\Models{
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
	class Branche extends \Eloquent {}
}

namespace App\Models{
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
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductCategory
 *
 * @package App\Models
 * @version May 23, 2024, 4:53 am UTC
 * @property string $name Код
 * @property string $description Тайлбар
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProductCategoryFactory factory($count = null, $state = [])
 * @method static Builder|ProductCategory filter(array $filters)
 * @method static Builder|ProductCategory newModelQuery()
 * @method static Builder|ProductCategory newQuery()
 * @method static Builder|ProductCategory query()
 * @method static Builder|ProductCategory whereCreatedAt($value)
 * @method static Builder|ProductCategory whereDescription($value)
 * @method static Builder|ProductCategory whereId($value)
 * @method static Builder|ProductCategory whereName($value)
 * @method static Builder|ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
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
	class Provider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name Нэр
 * @property string $email Нэвтрэх нэр
 * @property mixed $password Нууц үг
 * @property string|null $phone Утас
 * @property string $roles Эрхийн түвшин
 * @property string|null $remember_token
 * @property string|null $push_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePushToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property int|null $gender_id Хүйс
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGenderId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $filters)
 * @property string $username
 * @property string $position
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
	class UserModel extends \Eloquent {}
}

