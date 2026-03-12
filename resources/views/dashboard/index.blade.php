<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Intranet 2026</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #1e293b;
            color: #fff;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            padding: 30px;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        }

        button {
            background: #dc2626;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <strong>Intranet 2026</strong>
        </div>

        <div>
            {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}

            <form method="POST" action="{{ route('logout') }}" style="display:inline-block; margin-left:12px;">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <h1>Bienvenido al dashboard</h1>
            <p>Has iniciado sesión correctamente.</p>
            <p><strong>Usuario:</strong> {{ auth()->user()->nombre_usuario }}</p>
            <p><strong>Correo:</strong> {{ auth()->user()->correo }}</p>
        </div>
    </div>
</body>
</html>