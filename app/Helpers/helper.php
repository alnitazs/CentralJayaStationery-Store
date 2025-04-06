<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductImage;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

function getCategories(){
    return Category::orderBy('name','ASC')
        ->with('sub_category')
        ->orderBy('id','DESC')
        ->where('status',1)
        ->where('showHome','Yes')
        ->get();
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        return 'Rp' . number_format((float) $angka, 0, ',', '.'); // Format 0 desimal dan titik ribuan
    }
}

function getProductImage($productId) {
    return ProductImage::where('product_id',$productId)->first();
}

function orderEmail($orderId, $userType="customer") {
    $order = Order::where('id',$orderId)->with('items')->first();

    if ($userType == 'customer') {
        $subject = 'Terima kasih telah berbelanja';
        $email = $order->email;
    } else {
        $subject = 'Anda telah menerima pesanan';
        $email = env('ADMIN_EMAIL');
    }

    $mailData = [
        'subject' => $subject,
        'order' => $order,
        'userType' => $userType
    ];

    Mail::to($email)->send(new OrderEmail($mailData));
}

function getCountryInfo($id) {
    return Country::where('id',$id)->first();
}

function staticPages() {
    $pages = Page::orderBy('name','ASC')->get();
    return $pages;
}

?>