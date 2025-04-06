<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Central Jaya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #8B1C2D;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background-color: #fff;
            border-radius: 1rem;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }
        .left-panel {
            padding: 3rem;
        }
        .right-panel {
            background-color: #8B1C2D;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #8B1C2D;
        }
        .btn-register {
            background-color: #8B1C2D;
            color: white;
        }
        .btn-register:hover {
            background-color: #a82a3c;
        }
        .form-text a {
            color: #8B1C2D;
            text-decoration: none;
        }
        .invalid-feedback {
            font-size: 0.875em;
            color: red;
        }
    </style>
</head>
<body>

<div class="register-container d-flex flex-column flex-md-row">
    <div class="col-md-6 left-panel">
        <div class="d-flex align-items-center mb-4">
            <img src="/front-assets/images/Logo.png" alt="Logo" style="max-height: 30px; margin-right: 10px;">
            <h3 class="text-danger fw-bold mb-0">Central Jaya Stationery</h3>
        </div>

        <h4 class="mb-3 text-center">Registrasi</h4>

        <form method="POST" id="registrationForm">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap">
                <p></p>
            </div>

            <div class="mb-3">
                <input type="text" name="email" id="email" class="form-control" placeholder="Alamat Email">
                <p></p>
            </div>

            <div class="mb-3">
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor HP">
                <p></p>
            </div>

            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi">
                <p></p>
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi">
                <p></p>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-register">Daftar</button>
            </div>
        </form>

        <div class="mt-4 text-center form-text">
            Sudah punya akun? <a href="{{ route('account.login') }}">Login sekarang, yuk!</a>
        </div>
    </div>

    <div class="col-md-6 right-panel text-center">
        <div>
            <h2 class="fw-bold">HELLO, FRIEND!</h2>
            <p>Masukkan detail pribadi Anda dan mulailah perjalanan bersama kami</p>
        </div>
    </div>
</div>

{{-- JQuery CDN --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script type="text/javascript">
    $("#registrationForm").submit(function(event){
        event.preventDefault();

        $("button[type='submit']").prop('disabled', true);

        $.ajax({
            url: '{{ route("account.processRegister") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type='submit']").prop('disabled', false);

                var errors = response.errors;

                // Cek dan tampilkan error
                ['name', 'email', 'phone', 'password', 'password_confirmation'].forEach(function(field){
                    if(errors && errors[field]) {
                        $("#" + field).siblings("p").addClass('invalid-feedback').html(errors[field]);
                        $("#" + field).addClass('is-invalid');
                    } else {
                        $("#" + field).siblings("p").removeClass('invalid-feedback').html('');
                        $("#" + field).removeClass('is-invalid');
                    }
                });

                // Jika sukses
                if(response.status === true){
                    $("#registrationForm")[0].reset();
                    $(".form-control").removeClass('is-invalid');
                    $("p").removeClass('invalid-feedback').html('');
                    window.location.href = "{{ route('account.login') }}";
                }
            },
            error: function(jQXHR, exception) {
                console.log("Terjadi Kesalahan");
                $("button[type='submit']").prop('disabled', false);
            }
        });
    });
</script>

</body>
</html>
