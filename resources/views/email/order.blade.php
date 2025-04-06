<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">


    @if($mailData['userType'] == 'customer')
        <h1>Terima kasih telah berbelanja!</h1>
        <h2>Id pesanan Anda adalah: #{{ $mailData['order']->id }}</h2>
    @else
        <h1>Anda telah menerima pesanan:</h1>
        <h2>Id pesanan: #{{ $mailData['order']->id }}</h2>
    @endif

    <h2>Alamat Pengiriman</h2>
    <address>
        <strong>{{ $mailData['order']->first_name.' '.$mailData['order']->last_name }}</strong><br>
        {{ $mailData['order']->address }}<br>
        {{ $mailData['order']->city }}, {{ getCountryInfo($mailData['order']->country_id)->name }}, {{ $mailData['order']->zip }}<br>
        Nomor Handphone: {{ $mailData['order']->mobile }}<br>
        Email: {{ $mailData['order']->email }}
    </address>

    <h2>Produk</h2>

    <table cellpadding="3" cellspacing="3" border="0" width="700">
        <thead>
            <tr style="background: #CCC;">
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mailData['order']->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>Rp{{ number_format($item->price * 1000, 0, ',', '.') }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp{{ number_format($item->total * 1000, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3" align="right">Harga Produk:</th>
                <td>Rp{{ number_format($mailData['order']->subtotal * 1000, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Diskon{{ (!empty($mailData['order']->coupon_code)) ? '('.$mailData['order']->coupon_code.')' : '' }}:</th>
                <td>Rp{{ number_format($mailData['order']->discount, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <th colspan="3" align="right">Biaya Pengiriman:</th>
                <td>Rp{{ number_format($mailData['order']->shipping, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Total Pembayaran:</th>
                <td>Rp{{ number_format($mailData['order']->grand_total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
