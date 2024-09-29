<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccessMail;
use App\Models\AddTOCard;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Customer;
use Modules\Admin\Models\DelivaryLocation;
use Modules\Admin\Models\Order;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{

    public function index()
    {
        return view('pages.checkout');
    }
    public function shipCard()
    {
        return view('pages.shopping-cart');
    }

    public function placeOrder(Request $request)
    {


        $request->validate([
            'name' => 'required |string',
            'email' => 'required |email',
            'address' => 'required |string',
            'city' => 'required |string',
            'state' => 'required |string',
            // 'country' => 'required |string',
            'zip' => 'required |string',
            'phone' => 'required |string',

        ]);
        try {
            DB::beginTransaction();
            if (AddTOCard::where('user_id', FacadesAuth::user()->id)->count() == 0) {
                return back()->with('error', 'Cart is Empty')->withInput($request->all());
            }
            $customer = $this->manageCustomer($request);

            $order = $this->manageOrder($request, $customer->id);


            $orderProducts = $this->manageOrderProducts($order->id);
            if ($orderProducts) {
                // delete from the card 
                AddTOCard::where('user_id', FacadesAuth::user()->id)->delete();
            }

            $this->deliaryLocation($order->id, $request);
            \Mail::to(
                $request->email
            )->send(new \App\Mail\OrderSuccessMail($order->id));
            DB::commit();

            return redirect()
                ->route('orderSuccess', ['OrderID' => $order->id])
                ->with('success', 'Order Placed Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function manageCustomer($data)
    {

        $customer = [
            'user_id' => FacadesAuth::user()->id,
            'status' => 'active',
            'name' => $data->name,
            // 'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'state' => $data->state,
            'city' => $data->city,
            'zip' => $data->zip,

        ];
        return Customer::updateOrCreate([
            'email' => $data->email,
        ], $customer);
    }

    public function deliaryLocation($orderID, $data)
    {

        $customer = [
            'order_id' => $orderID,
            'user_id' => FacadesAuth::user()->id,

            'name' => $data->name,
            // 'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'billingAddress' => $data->billingAddress ?? $data->address,
            'shippingAddress' => $data->shippingAddress ?? $data->address,
            'note' => @$data->note,
            'state' => $data->state,
            'city' => $data->city,
            'zip' => $data->zip,
        ];
        return DelivaryLocation::updateOrCreate([
            'order_id' => $orderID,
        ], $customer);
    }

    public function manageOrder($request, $customerID)
    {
        $cardItem = AddTOCard::where('user_id', FacadesAuth::user()->id)->get();
        $discount = @$request->coupon_code ? $this->getDiscountAmount($request->coupon_code) : 0;
        $netTotal = $cardItem->sum('total_price') - $discount;
        $taxAmount = $netTotal * 0.13;

        $totalAmount = $netTotal + $taxAmount;

        $order = [
            'customer_id' => $customerID,
            'user_id' => FacadesAuth::user()->id,
            'status' => 'pending',
            'total_amount' => $totalAmount, // total amount with tax and discount applied
            'no_of_item' => $cardItem->count(),
            'subtotal' => $cardItem->sum('total_price'), // total amount without tax and discount
            'delivaryCharge' => 0,
            'payment_method' => $request->payment_method,
            'nettotal' => $netTotal,  // total amount without tax but with discount
            'discount' => $discount,
            'taxAmount' => $taxAmount,
            'coupon_code' => $request->coupon_code,
            'order_date' => now(),
        ];
        return Order::create($order);
    }
    public function getDiscountAmount($couponCode)
    {
        return 0;
    }
    public function calculateNetTotal($cardItem, $discount)
    {
        return $cardItem->sum('total_price') - $discount;
    }

    public function manageOrderProducts($orderID)
    {
        $cardItem = AddTOCard::where('user_id', FacadesAuth::user()->id)->get();
        $orderProducts = [];
        foreach ($cardItem as $item) {
            $orderProducts[] = [
                'order_id' => $orderID,
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'variation_id' => $item->variation_id,
                'sku' => $item->sku,
                'quantity' => $item->quantity,
                'unitPrice' => $item->unit_price,
                'subtotal' => $item->total_price,
                'status' => 1,
                'discount_amount' => $item->discount ?? 0,
                'discountCode' => $item->discountCode ?? '',
            ];
        }
        return DB::table('order_products')->insert($orderProducts);
    }

    public function orderSuccess()
    {
        return view('pages.ordermessage.success');
    }

    public function orderFailed()
    {
        return view('pages.ordermessage.failuer');
    }

    public function downloadBill($orderID)
    {
        // Fetch the order details
        $order = Order::with([
            'customer',
            'orderProducts',
            'delivaryLocation'
        ])->where('id', $orderID)->first();

        // Generate the PDF from the Blade view
        $pdf = Pdf::loadView('pdf.bill', compact('order'));

        // Stream the PDF for download, naming it appropriately
        return $pdf->download('invoice_order_' . $orderID . '.pdf');
    }
}
