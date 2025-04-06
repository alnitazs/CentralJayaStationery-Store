<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        if (Cart::count() > 0) {
            //echo "Produk sudah ada di keranjang";
            // Products found in cart
            // Check if this product already in the cart
            // Return as message that product already added in your cart
            // if product not found in the cart, then add product in cart

            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                    break; // Tambahkan ini biar loop berhenti begitu ketemu produk yang sama
                }
            }

            if ($productAlreadyExist == false) {
                // Cart::add($product->id, $product->title, 1, $product->price * 1000, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() :'']);
                Cart::add(
                    $product->id,
                    $product->title,
                    1,
                    $product->price * 1000,
                    ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']
                );

                $status = true;
                $message = '<strong>' . $product->title . '</strong> Produk berhasil ditambahkan ke keranjang Anda';
                session()->flash('success', $message);
            } else {
                $status = false;
                $message = $product->title . 'Produk sudah ditambahkan ke keranjang';
            }
        } else {
            // Cart::add($product->id, $product->title, 1, $product->price * 1000, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() :'']);
            Cart::add(
                $product->id,
                $product->title,
                1,
                $product->price* 1000, // << ini yang harus dikali lagi
                ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']
            );

            $status = true;
            $message = '<strong>' . $product->title . '</strong> Produk berhasil ditambahkan ke keranjang Anda';
            session()->flash('success', $message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        //dd(Cart::content());
        //dd(Cart::subtotal());
        //dd(Cart::total());
        //dd((float) Cart::subtotal(), number_format((float) Cart::subtotal(), 0, ',', '.'));
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);
        // check qty available in stock

        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = 'Keranjang berhasil diperbarui';
                $status = true;
                session()->flash('success', $message);
            } else {
                $message = 'Request qty(' . $qty . ') tidak tersedia dalam stock';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Keranjang berhasil diperbarui';
            $status = true;
            session()->flash('success', $message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'total' => (float) Cart::subtotal(0, '', ''), // Pastikan formatnya angka
            'grandTotal' => (float) Cart::total(0, '', ''), // Jika ada pajak/diskon, tambahkan juga
        ]);
    }

    public function deleteItem(Request $request)
    {

        $itemInfo = Cart::get($request->rowId);

        if ($itemInfo == null) {
            $errorMessage = 'Barang tidak ditemukan dikeranjang';
            session()->flash('error', $errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Barang berhasil dihapus dari keranjang';
        session()->flash('success', $message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function checkout()
    {

        $discount = 0;

        //-- if cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        //-- if user is not logged in then redirect to login page
        if (Auth::check() == false) {

            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('account.login');
        }

        //-- Check if user has verified email
        // if (Auth::user()->email_verified_at == null) {
        //     return redirect()->route('verification.notice')->with('error', 'Silakan verifikasi email Anda sebelum checkout.');
        // }

        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();

        $subTotal = Cart::subtotal(2, '.', '');
        // Apply discount here
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                $discount = $code->discount_amount;
            }
        }

        // Calculate shipping here
        if ($customerAddress != '') {
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();

            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            if ($shippingInfo) {
                $totalShippingCharge = $shippingInfo->amount;
            } else {
                // Handle case when no shipping info found (set default charge or any logic you need)
                $totalShippingCharge = 0;
            }
            
            $grandTotal = ($subTotal - $discount) + $totalShippingCharge;
        } else {
            $grandTotal = ($subTotal - $discount);
            $totalShippingCharge = 0;
        }


        return view('front.checkout', [
            'countries' => $countries,
            'customerAddress' => $customerAddress,
            'totalShippingCharge' => $totalShippingCharge,
            'discount' => $discount,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function processCheckout(Request $request)
    {

        // step - 1 Apply Validation

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:10',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Tolong perbaiki error',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // step - 2 save user address

        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
        );

        // step - 3 store data in orders table

        if ($request->payment_method == 'cod') {

            $discountCodeId = NULL;
            $promoCode = '';
            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2, '.', '');
            // $grandTotal = $subTotal + $shipping;

            // Apply discount here
            if (session()->has('code')) {
                $code = session()->get('code');

                if ($code->type == 'percent') {
                    $discount = ($code->discount_amount / 100) * $subTotal;
                } else {
                    $discount = $code->discount_amount;
                }

                $discountCodeId = $code->id;
                $promoCode = $code->code;
            }

            // Calculate shipping
            $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {
                $shipping = $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shipping;
            } else {
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $shipping = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shipping;
            }

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->discount = $discount;
            $order->coupon_code_id = $discountCodeId;
            $order->coupon_code = $promoCode;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->country_id = $request->country;
            $order->save();

            // step - 4 store order items in order items table

            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();

                // update product stock
                $productData = Product::find($item->id);
                if ($productData->track_qty == 'Yes') {
                    $currentQty = $productData->qty;
                    $updatedQty = $currentQty - $item->qty;
                    $productData->qty = $updatedQty;
                    $productData->save();
                }
            }

            // send order email
            orderEmail($order->id, 'customer');

            session()->flash('success', 'Anda berhasil membuat pesanan');

            Cart::destroy();

            session()->forget('code');

            return response()->json([
                'message' => 'Berhasil menyimpan order',
                'orderId' => $order->id,
                'status' => true
            ]);
        } else {
            //
        }
    }

    public function thankyou($id)
    {
        return view('front.thanks', [
            'id' => $id
        ]);
    }

    public function getOrderSummary(Request $request)
    {
        // $subTotal = Cart::subtotal(2, '.', '');
        $subTotal = (float) str_replace(',', '', Cart::subtotal(2, '.', ''));
        $discount = 0;
        $discountString = '';

        // Apply discount here
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                $discount = $code->discount_amount;
            }

            $discountString = '<div class="mt-4" id="discount-response">
                <strong>' . session()->get('code')->code . '</strong>
                <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
            </div>';
        }

        if ($request->country_id > 0) {

            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {

                $shippingCharge = $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'shippingCharge' => $shippingCharge,
                ]);
            } else {
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();

                $shippingCharge = $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'shippingCharge' => $shippingCharge,
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'grandTotal' => number_format(($subTotal - $discount), 2),
                'discount' => number_format($discount, 2),
                'discountString' => $discountString,
                'shippingCharge' => number_format(0, 2),
            ]);
        }
    }

    public function applyDiscount(Request $request)
    {
        //dd($request->code);

        $code = DiscountCoupon::where('code', $request->code)->first();

        if ($code == null) {
            return response()->json([
                'status' => false,
                'message' => 'Kupon diskon tidak valid',
            ]);
        }

        // check if coupon start date is valid or not

        $now = Carbon::now()->setTimezone('Asia/Jakarta');
        Log::info('Current Time: ' . $now->toDateTimeString());

        //echo $now->format('Y-m-d H:i:s');

        if ($code->starts_at != "") {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->starts_at);

            if ($now->lt($startDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kupon belum berlaku',
                ]);
            }
        }

        if ($code->expires_at != "") {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);

            if ($now->gt($endDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kupon sudah expired',
                ]);
            }
        }

        // max uses check
        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();

            if ($couponUsed >= $code->max_uses) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kupon diskon tidak valid',
                ]);
            }
        }

        // max uses user check
        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::user()->id])->count();

            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda telah menggunakan kupon ini, coba kupon lain',
                ]);
            }
        }

        $subTotal = Cart::subtotal(2, '.', '');
        Log::info('Subtotal: ' . $subTotal);
        Log::info('Coupon Discount: ' . $code->discount_amount);

        // min amount condition check
        if ($code->min_amount > 0) {
            if ($subTotal < $code->min_amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Minimal belanja Rp' . $code->min_amount . '.',
                ]);
            }
        }

        session()->put('code', $code);

        return $this->getOrderSummary($request);
    }

    public function removeCoupon(Request $request)
    {
        session()->forget('code');
        return $this->getOrderSummary($request);
    }
}
