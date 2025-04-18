@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">Akun Saya</a></li>
                <li class="breadcrumb-item">Pesanan saya</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Pesanan saya</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pesanan #</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->isNotEmpty())
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('account.orderDetail',$order->id) }}">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                            <span class="badge bg-danger">Tertunda</span>
                                            @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">Dikirim</span>
                                            @elseif ($order->status == 'delivered')
                                            <span class="badge bg-success">Sudah sampai</span>
                                            @else
                                            <span class="badge bg-secondary">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>{{ formatRupiah($order->grand_total,2) }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">Pesanan tidak ditemukan</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
