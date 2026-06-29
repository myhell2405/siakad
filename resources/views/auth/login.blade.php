<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal SDN 01 Durian Gadang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset('images/bg.jpeg') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            backdrop-filter: blur(10px);
            background-color: rgba(0,0,0,0.3);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 30px;
            width: 350px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            color: white;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .form-control {
            background: rgba(255,255,255,0.3);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.8);
        }

        .form-control:focus {
            background: rgba(255,255,255,0.4);
            box-shadow: none;
            color: white;
        }

        .btn-login {
            width: 100%;
            background-color: #4CAF50;
            border: none;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        SDN 01 Durian Gadang
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="mb-3">
            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Username / NIP / NISN"
                   required
                   autofocus>
        </div>

        <div class="mb-3">
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Password"
                   required>
        </div>

        <button type="submit" class="btn btn-login text-white">
            LOGIN
        </button>
    </form>
</div>

</body>
</html>