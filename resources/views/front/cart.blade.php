@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route("front.home") }}">Beranda</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route("front.shop") }}">Toko</a></li>
                <li class="breadcrumb-item">Keranjang</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-9 pt-4">
    <div class="container">
        <div class="row">
        @if(Session::has('success'))
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! Session::get('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        </div>
        @endif

        @if(Session::has('error'))
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        </div>
        @endif

            @if (Cart::count() > 0)
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" id="cart">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($cartContent as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">

                                        @if(!empty($item->options->productImage->image))
                                        <img src="{{ asset('uploads/product/small/'.$item->options->productImage->image)}}" />
                                        @else
                                        <img src="{{ asset('admin-assets/img/default-150x150.png') }}" />
                                        @endif

                                        <h2 class="ms-2 flex-grow-1">{{ $item->name }}</h2>
                                    </div>
                                </td>
                                <td>Rp{{ number_format($item->price , 0, ',', '.') }}</td>
                                <td>
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{ $item->rowId }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{ $item->rowId }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    Rp{{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="deleteItem('{{ $item->rowId }}');"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card cart-summery mb-5">
                    <div class="card-body">
                        <div class="sub-title">
                            <h2 class="bg-white-2">Ringkasan Keranjang</h2>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Total Harga</div>
                            <div>Rp{{ number_format((float) Cart::subtotal(0, '', ''), 0, ',', '.') }}</div>
                            {{-- <div>Rp{{ number_format((float) str_replace(',', '', Cart::subtotal()), 0, ',', '.') }}</div> --}}
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('front.checkout') }}" class="btn-dark btn btn-block w-100">Lanjut ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <h4>Keranjang Anda Kosong!</h4>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script>
        $('.add').click(function(){
            var qtyElement = $(this).parent().prev(); // Input Jumlah
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);
                
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId,newQty)
            }            
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().next(); 
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);

                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId,newQty)
            }        
        });

        function updateCart(rowId,qty) {
            $.ajax({
                url: '{{ route("front.updateCart") }}',
                type: 'post',
                data: {rowId:rowId, qty:qty},
                dataType: 'json',
                success: function(response) {
                    window.location.href = '{{ route("front.cart") }}';
                }
            });
        }

        function deleteItem(rowId) {
            if (confirm("Apakah Anda yakin ingin menghapus?")) {
                $.ajax({
                    url: '{{ route("front.deleteItem.cart") }}',
                    type: 'post',
                    data: {rowId:rowId},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route("front.cart") }}';
                    }
                });
            }
        }
    </script>
@endsection
