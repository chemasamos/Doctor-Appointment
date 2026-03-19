<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Citas del Día — Healthify</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="700" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

                    {{-- CABECERA --}}
                    <tr>
                        <td style="background-color: #1e3a5f; padding: 28px 40px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 20px; margin: 0 0 4px; letter-spacing: 1px;">Healthify</h1>
                            <p style="color: #90c4f8; font-size: 13px; margin: 0;">
                                Reporte de Citas del Día — {{ \Carbon\Carbon::today()->format('d/m/Y') }}
                            </p>
                        </td>
                    </tr>

                    {{-- CUERPO --}}
                    <tr>
                        <td style="padding: 32px 40px;">

                            @if($appointments->isEmpty())
                                {{-- SIN CITAS --}}
                                <p style="font-size: 14px; color: #64748b; text-align: center; padding: 30px 0; margin: 0;">
                                    No hay citas programadas para hoy.
                                </p>
                            @else
                                {{-- TABLA DE CITAS --}}
                                <p style="font-size: 14px; color: #334155; margin: 0 0 20px;">
                                    Se encontraron <strong>{{ $appointments->count() }}</strong> cita(s) programadas para hoy.
                                </p>

                                <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; font-size: 13px;">
                                    {{-- ENCABEZADO DE TABLA --}}
                                    <thead>
                                        <tr style="background-color: #1e40af;">
                                            <th style="color: #ffffff; text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Paciente</th>
                                            <th style="color: #ffffff; text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Doctor</th>
                                            <th style="color: #ffffff; text-align: center; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Hora Inicio</th>
                                            <th style="color: #ffffff; text-align: center; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Hora Fin</th>
                                            <th style="color: #ffffff; text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Motivo</th>
                                        </tr>
                                    </thead>
                                    {{-- FILAS --}}
                                    <tbody>
                                        @foreach($appointments as $index => $appt)
                                        <tr style="background-color: {{ $index % 2 === 0 ? '#f8fafc' : '#ffffff' }}; border-bottom: 1px solid #e2e8f0;">
                                            <td style="padding: 10px 12px; color: #0f172a; vertical-align: top;">
                                                {{ $appt->patient->user->name }}
                                            </td>
                                            <td style="padding: 10px 12px; color: #0f172a; vertical-align: top;">
                                                {{ $appt->doctor->user->name }}
                                            </td>
                                            <td style="padding: 10px 12px; color: #0f172a; text-align: center; vertical-align: top;">
                                                {{ substr($appt->start_time, 0, 5) }}
                                            </td>
                                            <td style="padding: 10px 12px; color: #0f172a; text-align: center; vertical-align: top;">
                                                {{ substr($appt->end_time, 0, 5) }}
                                            </td>
                                            <td style="padding: 10px 12px; color: #475569; vertical-align: top; font-size: 12px;">
                                                {{ $appt->reason }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </td>
                    </tr>

                    {{-- PIE --}}
                    <tr>
                        <td style="background-color: #f8fafc; padding: 16px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="font-size: 11px; color: #94a3b8; margin: 0;">
                                Reporte generado automáticamente — Healthify &nbsp;|&nbsp; {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
