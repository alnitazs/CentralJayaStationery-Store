@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>{{ $totalOrders }}</h4>
                    <p>Total Pesanan</p>
                    <hr>
                    <a href="{{ route('orders.index') }}" class="text-dark">Info Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>{{ $totalProducts }}</h4>
                    <p>Total Produk</p>
                    <hr>
                    <a href="{{ route('products.index') }}" class="text-dark">Info Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>{{ $totalCustomers }}</h4>
                    <p>Total Pelanggan</p>
                    <hr>
                    <a href="{{ route('users.index') }}" class="text-dark">Info Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                    <p>Total Penjualan</p>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>Rp{{ number_format($revenueThisMonth, 0, ',', '.') }}</h4>
                    <p>Pendapatan Bulan Ini</p>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>Rp{{ number_format($revenueLastMonth, 0, ',', '.') }}</h4>
                    <p>Pendapatan Bulan Terakhir ({{ $lastMonthName }})</p>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card-custom">
                    <h4>Rp{{ number_format($revenueLast30Days, 0, ',', '.') }}</h4>
                    <p>Pendapatan 30 hari</p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('customJS')
	<style>
	.card-custom {
		border: 2px solid #A5231C;
		border-radius: 5px;
		text-align: center;
		padding: 15px;
	}
	.card-custom hr {
		margin: 10px 0;
	}
	.card-custom h4 {
		font-weight: bold;
	}
    .card-custom {
        border: 2px solid #A5231C;
        border-radius: 5px;
        text-align: center;
        padding: 15px;
        margin: 10px; /* Tambahin jarak antar card */
    }
    .card-custom hr {
        margin: 10px 0;
    }
    .card-custom h4 {
        font-weight: bold;
    }
</style>
@endsection