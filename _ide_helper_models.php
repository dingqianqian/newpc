<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model{
/**
 * App\Model\Area
 *
 */
	class Area extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\BrowseHistory
 *
 * @property-read \App\Model\Goods $goods
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\GoodsImg[] $goodsImg
 */
	class BrowseHistory extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\CheckIns
 *
 * @property-read mixed $create_time
 */
	class CheckIns extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Collection
 *
 * @property-read \App\Model\Goods $goods
 */
	class Collection extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Coupon
 *
 */
	class Coupon extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\CouponType
 *
 */
	class CouponType extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Employee
 *
 */
	class Employee extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Goods
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\GoodsImg[] $goodsImg
 * @property-read \App\Model\GoodsStatus $goodsStatus
 * @property-read \App\Model\GoodsType $goodsType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\NormsCombo[] $normsCombo
 */
	class Goods extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsDetailsImg
 *
 */
	class GoodsDetailsImg extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsEvaluate
 *
 * @property-read \App\Model\User $user
 */
	class GoodsEvaluate extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsImg
 *
 */
	class GoodsImg extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsSale
 *
 * @property-read \App\Model\Goods $goods
 */
	class GoodsSale extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Goods[] $Goods
 */
	class GoodsStatus extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\GoodsType
 *
 */
	class GoodsType extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Integral
 *
 */
	class Integral extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Norms
 *
 */
	class Norms extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\NormsCombo
 *
 * @property-read \App\Model\Goods $goods
 * @property-read \App\Model\GoodsImg $goodsImg
 */
	class NormsCombo extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\NormsComboImg
 *
 */
	class NormsComboImg extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\NormsGroup
 *
 */
	class NormsGroup extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Order
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\OrderGoods[] $orderGoods
 */
	class Order extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\OrderGoods
 *
 */
	class OrderGoods extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\PayErrorCount
 *
 */
	class PayErrorCount extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Recharge
 *
 */
	class Recharge extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ShopCart
 *
 * @property-read \App\Model\Goods $goods
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\NormsCombo[] $normsCombo
 */
	class ShopCart extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\TakeOver
 *
 */
	class TakeOver extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\User
 *
 */
	class User extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Wallet
 *
 */
	class Wallet extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

