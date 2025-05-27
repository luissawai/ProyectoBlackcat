<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #1a1a1a;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .content {
            padding: 30px;
        }
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            color: #1a1a1a;
            font-weight: bold;
            padding: 10px 0;
            width: 140px;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            color: #333;
            padding: 10px 0;
        }
        .desafios-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .desafio-item {
            background-color: #f8f9fa;
            padding: 12px;
            margin-bottom: 8px;
            border-left: 4px solid #1a1a1a;
            border-radius: 4px;
        }
        .desafio-title {
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        .desafio-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 4px;
        }
        .desafio-solution {
            color: #28a745;
            font-size: 12px;
            font-style: italic;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
        }
        .copyright {
            color: #999;
            font-size: 11px;
        }

        @media (max-width: 768px) {

            title{
                font-size: 20px;
            }
            .info-grid {
                display: block;
            }
            .info-row {
                display: block;
                margin-bottom: 15px;
            }
            .info-label {
                display: block;
                width: auto;
                margin-bottom: 5px;
                font-size: 18px;
            }
            .info-value {
                display: block;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo mensaje de contacto</h1>
        </div>
        
        <div class="content">
            <p class="subtitle">Nuevo Mensaje. Un cliente se puso en contacto</p>

            <div class="info-section">
                <h2>Información del Contacto</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Nombre:</div>
                        <div class="info-value">{{ $contact->nombre }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $contact->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">{{ $contact->telefono }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Sector:</div>
                        <div class="info-value">
                            @if($contact->sector === 'otros')
                                {{ $contact->sector_otro }}
                            @else
                                {{ ucfirst($contact->sector) }}
                            @endif
                        </div>
                    </div>
                    @if($contact->sector !== 'otros')
                    <div class="info-row">
                        <div class="info-label">Tipo de Empresa:</div>
                        <div class="info-value">{{ ucfirst($contact->tipo_empresa) }}</div>
                    </div>
                    @endif
                    <div class="info-row">
                        <div class="info-label">Desafíos:</div>
                        <div class="info-value">
                            @if($contact->sector === 'otros')
                                <div class="desafio-item">
                                    <div class="desafio-title">Desafíos personalizados</div>
                                    <div class="desafio-description">{{ $contact->desafios_otros }}</div>
                                </div>
                            @else
                                @php
                                    // Intentar obtener como array (con cast automático)
                                    $desafios = $contact->desafios;
                                    
                                    // Si no es array, intentar decodificar manualmente
                                    if (!is_array($desafios)) {
                                        $desafios = json_decode($contact->desafios, true);
                                    }
                                    
                                    // Si aún no es array, dividir por comas como fallback
                                    if (!is_array($desafios)) {
                                        $desafios = explode(', ', $contact->desafios);
                                    }
                                @endphp
                                
                                @if(is_array($desafios) && count($desafios) > 0)
                                    <ul class="desafios-list">
                                        @foreach($desafios as $desafio)
                                            <li class="desafio-item">
                                                @if(is_array($desafio) && isset($desafio['title']))
                                                    <div class="desafio-title">{{ $desafio['title'] }}</div>
                                                    @if(isset($desafio['description']))
                                                        <div class="desafio-description">{{ $desafio['description'] }}</div>
                                                    @endif
                                                    @if(isset($desafio['recommendedSolution']))
                                                        <div class="desafio-solution">Solución recomendada: {{ $desafio['recommendedSolution'] }}</div>
                                                    @endif
                                                @else
                                                    <div class="desafio-title">{{ is_string($desafio) ? $desafio : 'Desafío no especificado' }}</div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="desafio-item">
                                        <div class="desafio-title">{{ $contact->desafios ?: 'No especificado' }}</div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Rol:</div>
                        <div class="info-value">
                            @if($contact->rol === 'otros_rol')
                                {{ $contact->rol_otro }}
                            @else
                                {{ $contact->rol }}
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contactar en:</div>
                        <div class="info-value">{{ $contact->momento_contacto }}</div>
                    </div>
                    @if($contact->mensaje)
                    <div class="info-row">
                        <div class="info-label">Mensaje:</div>
                        <div class="info-value">{{ $contact->mensaje }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Este mensaje fue generado automáticamente. Por favor no responda a este correo.</p>
            <p class="copyright">&copy; {{ date('Y') }} BlackCat. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>