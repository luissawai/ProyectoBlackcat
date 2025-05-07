<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo contacto recibido</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #2c3e50;
            width: 30%;
        }
        .action-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
        }
        .action-button:hover {
            background-color: #2980b9;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Nuevo mensaje recibido</h1>
    

    <table>
        <tr>
            <th>Fecha</th>
            <td>{{ now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td>{{ $contact->nombre }}</td>
        </tr>
        <tr>
            <th>Empresa</th>
            <td>{{ $contact->empresa }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td><a href="mailto:{{ $contact->correo }}">{{ $contact->correo }}</a></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $contact->telefono }}</td>
        </tr>
        <tr>
            <th>Tipo de Empresa</th>
            <td>{{ $contact->tipo_empresa }}</td>
        </tr>
        <tr>
            <th>Producto de interés</th>
            <td>{{ $contact->producto_interesado }}</td>
        </tr>
        <tr>
            <th>Ubicación</th>
            <td>{{ $contact->provincia }}, {{ $contact->localidad }}</td>
        </tr>
    </table>

    <div style="text-align: center;">
        <a href="mailto:{{ $contact->correo }}?subject=Respuesta a tu consulta" class="action-button">
            Responder al contacto
        </a>
    </div>

    <footer>
        <p>Este mensaje fue generado automáticamente. No responder directamente a este correo.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
    </footer>
</div>

</body>
</html>