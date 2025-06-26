<?php


namespace App\Models\Factories;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * BaseFactory
 */
class CartItemFactory extends BaseFactory
{

    /**
     *
     */
    public function __construct()
    {
        $this->model = CartItem::class;
    }

    /**
     * @param User $objUser
     * @return mixed
     */
    public function getByUser(User $objUser){

        return $this->model::where("user_id", $objUser->getId())->get()->all();
    }

    /**
     * @param User $objUser
     * @param Model $objProductType
     * @return mixed
     */
    public function getByUserAndProductType(User $objUser, Model $objProductType){

        return $this->model::where("user_id", $objUser->getId())
            ->where('product_type', '=', $objProductType::class)
            ->get()->all();
    }

    /**
     * @param User $objUser
     * @param Model $objProduct
     * @param int $quantity
     * @return CartItem|false
     */
    public function create(User $objUser, Model $objProduct, int $quantity){
        $objCartItem = new CartItem();
        $objCartItem->setUserId($objUser->getId());
        $objCartItem->setProductId($objProduct->getId());
        $objCartItem->setProductType($objProduct::class);
        $objCartItem->setQuantity($quantity);

        if(!$objCartItem->save()){
            return false;
        }

        return $objCartItem;
    }
}
