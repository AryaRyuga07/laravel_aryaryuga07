<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-primary bg-gradient d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row shadow-lg rounded-4 overflow-hidden bg-white" style="max-width: 900px; margin:auto;">
            <div class="col-md-6 p-5">
                <h6 class="text-muted">Selamat Datang Kembali !!!</h6>
                <h2 class="fw-bold mb-4">Masuk</h2>

                <form method="POST" action="{{ route('doLogin') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="********">
                    </div>
                    <button type="submit" class="btn btn-danger w-100 rounded-pill">LOGIN →</button>
                </form>

                <div class="text-center mt-4">
                    <p class="mt-3">Tidak punya akun?
                        <a href="{{ route('register') }}" class="text-decoration-none">Daftar</a>
                    </p>
                </div>
            </div>

            <div class="col-md-6 p-0">
                <img src="{{ asset('assets/img/hospital.jpg') }}" class="w-100 h-100" style="object-fit: cover;"
                    alt="Login Illustration">
            </div>
        </div>
    </div>
</body>

</html>
