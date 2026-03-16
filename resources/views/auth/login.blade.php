<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Intranet 2026</title>
    <style>
        * { box-sizing: border-box; }

        :root {
            --color-primary-dark: #385506;
            --color-primary: #779123;
            --color-accent: #a0c525;
            --color-neutral: #656264;
            --color-white: #ffffff;
            --color-black: #000000;
            --color-bg: #f6f8f2;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f6f8f2 0%, #eef3df 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background: var(--color-white);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-top: 6px solid var(--color-primary);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
            text-align: center;
            color: var(--color-primary-dark);
        }

        p {
            text-align: center;
            color: var(--color-neutral);
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: var(--color-primary-dark);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #cdd6c1;
            border-radius: 8px;
            background: #ffffff;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(119,145,35,0.15);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        button {
            width: 100%;
            padding: 12px;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        button:hover {
            background: var(--color-primary-dark);
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f1eeef;
            color: #4b4a4b;
            border: 1px solid rgba(101, 98, 100, 0.14);
        }

        .alert-success {
            background: #edf7d7;
            color: #385506;
            border: 1px solid rgba(56, 85, 6, 0.14);
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px 16px;
            }
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
                <label for="remember" style="margin: 0; font-weight: normal; color:#656264;">Recordarme</label>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>