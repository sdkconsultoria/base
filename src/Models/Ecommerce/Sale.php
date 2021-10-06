<?php

namespace Sdkconsultoria\Base\Models\Ecommerce;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use ShoppingCart;

class Sale extends BaseModel
{
    public function processPay(Request $request)
    {
        $cart = ShoppingCart::where('created_by', Auth::id())->get();
        $openpay = Openpay::getInstance(config('app.openpay.id'), config('app.openpay.private_key'), 'MX');
        $user = Auth::user();

        $customer = array(
            'name' => $user->firstname,
            'last_name' => $user->lastname1,
            'email' => $user->email);

        $chargeData = array(
            'method' => 'card',
            'source_id' => $request->input('token_id'),
            'amount' => $request->input('amount'), // formato númerico con hasta dos dígitos decimales.
            'description' => 'Compra en BKN',
            'device_session_id' => $request->input('deviceIdHiddenFieldName'),
            'customer' => $customer
        );

        $charge = $openpay->charges->create($chargeData);

        $sale = new Sale();
        $sale->created_by = Auth::id();
        $sale->pay_id = $charge->id;
        $sale->save();

        foreach ($cart as $key => $producto) {
            $producto->delete();
            $detail = new SaleDetails();
            $detail->product_id = $producto->product->id;
            $detail->quantity = $producto->quantity;
            $detail->price = $producto->product->price;
            $detail->created_by = Auth::id();
            $detail->sale_id = $sale->id;
            $detail->save();
        }

        return redirect()->route('send', $sale->id);
    }
}
