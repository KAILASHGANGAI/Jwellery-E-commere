<?php

namespace App\Http\Controllers;

use App\Models\AddTOCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddTOCardController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'sku' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discountCode' => 'nullable|string',
        ]);

        // Check if the product with the same SKU is already in the user's cart
        $cartItem = AddTOCard::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('sku', $request->sku)
            ->first();

        if ($cartItem) {
            // Update quantity and total price
            $cartItem->quantity += $request->quantity;
            $cartItem->total_price = $this->calculateTotalPrice($cartItem->quantity, $cartItem->unit_price, $cartItem->discount);
            $cartItem->save();
        } else {
            // Calculate total price and create a new cart item
            $totalPrice = $this->calculateTotalPrice($request->quantity, $request->unit_price, $request->discount ?? 0);

            $cartItem = AddTOCard::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'variation_id' => $request->variation_id,
                'sku' => $request->sku,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $totalPrice,
                'discount' => $request->discount ?? 0,
                'discountCode' => $request->discountCode ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cartItem,
        ]);
    }

    private function calculateTotalPrice($quantity, $unitPrice, $discount)
    {
        return ($unitPrice * $quantity) - $discount;
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
