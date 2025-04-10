@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">                    
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('brands.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('brands.store') }}" id="editBrandForm" name="editBrandForm" method="post">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="nama" value="{{ $brand->name }}">    
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="slug" value="{{ $brand->slug }}">
                                <p></p>    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($brand->status == 1) ? 'selected' : '' }} value="1">Aktif</option>
                                    <option {{ ($brand->status == 0) ? 'selected' : '' }} value="0">Tidak Aktif</option>
                                </select>
                                <p></p>    
                            </div>
                        </div>                                    
                    </div>
                </div>                            
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-dark ml-3">Batal</a>
            </div>
        </form>
    </div>
</section>
@endsection

@section('customJS')
<script>
$("#editBrandForm").submit(function(event) {
    event.preventDefault();
    var element = $(this);

    $("button[type=submit]").prop('disabled', true);

    $.ajax({
        url: '{{ route("brands.update", $brand->id) }}',
        type: 'put',
        data: element.serialize(),
        dataType: 'json',
        success: function(response) {
            $("button[type=submit]").prop('disabled', false);
            if (response["status"] == true) {
                window.location.href = '{{ route("brands.index") }}';
            } else {
                if (response['notFound'] == true) {
                    window.location.href = "{{ route('brands.index') }}";
                }
                var errors = response['errors'];
                if (errors['name']) {
                    $("#name").addClass('is-invalid')
                        .siblings('p').addClass('invalid-feedback')
                        .html(errors['name'][0]);
                } else {
                    $("#name").removeClass('is-invalid')
                        .siblings('p').removeClass('invalid-feedback')
                        .html("");
                }

                if (errors['slug']) {
                    $("#slug").addClass('is-invalid')
                        .siblings('p').addClass('invalid-feedback')
                        .html(errors['slug'][0]);
                } else {
                    $("#slug").removeClass('is-invalid')
                        .siblings('p').removeClass('invalid-feedback')
                        .html("");
                }
            }
        },
        error: function(jqXHR, exception) {
            console.log("Terjadi Kesalahan");
        }
    });
});

$("#name").on("input", function() {
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);
    $.ajax({
        url: '{{ route("getSlug") }}',
        type: 'get',
        data: { title: element.val() },
        dataType: 'json',
        success: function(response) {
            $("button[type=submit]").prop('disabled', false);
            if (response["status"] == true) {
                $("#slug").val(response["slug"]);
            }
        }
    });
});
</script>
@endsection
