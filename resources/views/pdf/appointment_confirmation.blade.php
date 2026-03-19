<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Cita — Healthify</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; color: #1e293b; background: #f8fafc; }

        .header {
            background-color: #1e3a5f;
            color: #ffffff;
            text-align: center;
            padding: 28px 20px;
        }
        .header h1 { font-size: 22px; font-weight: bold; letter-spacing: 1px; margin-bottom: 4px; }
        .header p  { font-size: 12px; color: #90c4f8; }

        .body { padding: 30px 40px; }

        .section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .section-title {
            background-color: #eff6ff;
            color: #1e40af;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 16px;
            border-bottom: 1px solid #bfdbfe;
        }
        .section-body { padding: 16px; }

        .row { display: block; margin-bottom: 10px; }
        .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
        }
        .value {
            font-size: 14px;
            color: #0f172a;
            margin-top: 2px;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        td { padding: 8px 16px; vertical-align: top; }
        td.lbl { width: 40%; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: bold; }
        td.val { color: #0f172a; font-size: 13px; }

        .badge {
            display: inline-block;
            background-color: #dbeafe;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 12px;
        }

        .footer {
            text-align: center;
            padding: 18px 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    {{-- ENCABEZADO --}}
    <div class="header">
        <h1>Healthify — Comprobante de Cita</h1>
        <p>Documento generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="body">

        {{-- DATOS DEL PACIENTE --}}
        <div class="section">
            <div class="section-title">Datos del Paciente</div>
            <div class="section-body">
                <table>
                    <tr>
                        <td class="lbl">Nombre</td>
                        <td class="val">{{ $appointment->patient->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Correo electrónico</td>
                        <td class="val">{{ $appointment->patient->user->email }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- DATOS DE LA CITA --}}
        <div class="section">
            <div class="section-title">Datos de la Cita</div>
            <div class="section-body">
                <table>
                    <tr>
                        <td class="lbl">Doctor</td>
                        <td class="val">{{ $appointment->doctor->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Especialidad</td>
                        <td class="val">{{ $appointment->doctor->speciality->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Fecha</td>
                        <td class="val">
                            @if($appointment->date instanceof \Carbon\Carbon)
                                {{ $appointment->date->format('d/m/Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="lbl">Hora inicio</td>
                        <td class="val">{{ substr($appointment->start_time, 0, 5) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Hora fin</td>
                        <td class="val">{{ substr($appointment->end_time, 0, 5) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Motivo</td>
                        <td class="val">{{ $appointment->reason }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Estado</td>
                        <td class="val"><span class="badge">{{ ucfirst($appointment->status ?? 'Programada') }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    {{-- PIE DE PÁGINA --}}
    <div class="footer">
        Este comprobante fue generado automáticamente por Healthify.<br>
        Por favor, no responda a este correo.
    </div>

</body>
</html>
