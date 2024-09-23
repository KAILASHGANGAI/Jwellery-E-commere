<?php

namespace App\Http\Controllers;

use App\Models\AddTOCard;
use Illuminate\Http\Request;

class AddTOCardController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'variation_id' => 'nullable|integer',
            'sku' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discountCode' => 'nullable|string',
        ]);

        // Calculate the total price
        $totalPrice = (new AddTOCard())->calculateTotalPrice(
            $request->quantity,
            $request->unit_price,
            $request->discount ?? 0
        );

        // Save to cart
        $cart = AddTOCard::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'variation_id' => $request->variation_id,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'discount' => $request->discount ?? 0,
            'discountCode' => $request->discountCode ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart' => $cart,
        ]);
    }

    public function getCart($userId)
    {
        $cartItems = AddTOCard::where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'cartItems' => $cartItems,
        ]);
    }

    public function removeItem($cartId)
    {
        AddTOCard::destroy($cartId);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully!',
        ]);
    }
}
