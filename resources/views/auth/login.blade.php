<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Intranet 2026</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 420px;
            margin: 80px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
            text-align: center;
        }

        p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1d4ed8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #1e40af;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Intranet 2026</h1>
        <p>Inicia sesión para continuar</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <label for="login">Correo o usuario</label>
            <input
                type="text"
                name="login"
                id="login"
                value="{{ old('login') }}"
                placeholder="admin@intranet.local o admin"
                required
            >

            <label for="password">Contraseña</label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="********"
                required
            >

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin: 0; font-weight: normal;">Recordarme</label>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>