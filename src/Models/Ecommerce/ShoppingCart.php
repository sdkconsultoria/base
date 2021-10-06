<?php

namespace Sdkconsultoria\Base\Models\Ecommerce;

use Sdkconsultoria\Base\Models\Model as BaseModel;

class ShoppingCart extends BaseModel
{
    protected function setToSession($product)
    {
        session(['cart' => $product]);
    }

    protected function getFromSession()
    {
        return session('key');
    }

    public function setCart()
    {

    }

    public function getCart()
    {

    }
}
