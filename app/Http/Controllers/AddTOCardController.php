<?php

namespace App\Http\Controllers;

use App\Models\AddTOCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\Product;

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
            'totalAmount' => AddTOCard::where('user_id', Auth::id())->sum('total_price'),
            'totalQuantity' => AddTOCard::query()->where('user_id', Auth::id())->count() ?? 0,
        ]);
    }

    private function calculateTotalPrice($quantity, $unitPrice, $discount)
    {
        return ($unitPrice * $quantity) - $discount;
    }
    public function updateCart(Request $request){
      
        $cartItem = AddTOCard::find($request->itemId);

        if ($cartItem) {
            // Update quantity and total price
            $quantity = $cartItem->quantity + $request->change; 
            if ($quantity < 1) {
                $quantity = 1;
            }
            $cartItem->quantity = $quantity;
            $cartItem->total_price = $this->calculateTotalPrice($quantity, $cartItem->unit_price, $cartItem->discount);
            $cartItem->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cartItem
        ]);
    }

    public function getCart()
    {
        $cartItems = AddTOCard::with(['product:id,title,slug', 'variation:id,sku', 'product.images' => function ($query) {
            $query->select('id', 'product_id', 'image_path')->limit(1);  // This will fetch only one image
        }])
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'success' => true,
            'cartItems' => $cartItems,
            'totalAmount' => $cartItems->sum('total_price'),
        ]);
    }

    public function removeItem($cartId)
    {
        AddTOCard::destroy($cartId);

        return back()->with('success', 'Item Removed From Card');
    }

    public function wishlist(Request $request)
    {
        return view('pages.wishlist');
    }

    public function getWishlistProducts(Request $request)
    {
        $productIds = $request->input('product_ids');
        $productIds = json_decode($productIds);
        if ($productIds) {
            $products = Product::with(['images', 'variations'])->whereIn('id', $productIds)->get();
            return response()->json($products);
        }
        
        return response()->json(['message' => 'No products found'], 404);

    }
}
