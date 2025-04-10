@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Buat Kategori</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('categories.index') }}" class="btn btn-primary">Kembali</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form action="{{ route('categories.store') }}" method="post" id="categoryForm" name="categoryForm">
                        @csrf
                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Nama Kategori</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="nama">	
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="slug">	
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                            <input type="hidden" id="image_id" name="image_id" value="">
                                                <label for="image">Gambar</label>
                                                <div id="image" class="dropzone dz-clickable">
                                                    <div class="dz-message needsclick">    
                                                        <br>Letakkan file di sini atau klik untuk mengunggah.<br><br>                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>								
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status">Tampilkan di Beranda</label>
                                                <select name="showHome" id="showHome" class="form-control">
                                                    <option value="Yes">Ya</option>
                                                    <option value="No">Tidak</option>
                                                </select>
                                            </div>
                                        </div>								
                                    </div>
                                </div>							
                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Buat</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Batal</a>
                            </div>
                        </form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
@endsection

@section('customJS')
<script>
$("#categoryForm").submit(function(event) {
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url: '{{ route("categories.store") }}',
        type: 'post',
        data: element.serialize(),
        dataType: 'json',
        success: function(response){
            $("button[type=submit]").prop('disabled',false);

            if(response["status"] == true) {

                window.location.href = '{{ route("categories.index") }}';

                $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                
                $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");



            } else {
                var errors = response['errors'];
                if(errors['name']) {
                    $("#name").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['name'][0]);
                } else {
                    $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }

                if(errors['slug']) {
                    $("#slug").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['slug']);
                } else {
                    $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }
            }

            

        }, error: function(jqXHR, exception){
            console.log("Terjadi Kesalahan");
        }
    })
});

    $("#name").on("input", function() {
        var element = $(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
        url: '{{ route("getSlug") }}',
        type: 'get',
        data: {title: element.val()},
        dataType: 'json',
        success: function(response){
            $("button[type=submit]").prop('disabled',false);
            if (response["status"] == true) {
                $("#slug").val(response["slug"]);
            }

            }
        });
    });



    Dropzone.autoDiscover = false;    
    const dropzone = $("#image").dropzone({ 
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });

</script>
@endsection