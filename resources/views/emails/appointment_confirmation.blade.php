<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cita — Healthify</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f1f5f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

                    {{-- CABECERA --}}
                    <tr>
                        <td style="background-color: #1e3a5f; padding: 28px 40px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 1px;">Healthify</h1>
                            <p style="color: #90c4f8; font-size: 13px; margin: 4px 0 0;">Confirmación de Cita Médica</p>
                        </td>
                    </tr>

                    {{-- CUERPO --}}
                    <tr>
                        <td style="padding: 36px 40px;">
                            <p style="font-size: 16px; color: #0f172a; margin: 0 0 16px;">
                                Hola, <strong>{{ $appointment->patient->user->name }}</strong>,
                            </p>

                            <p style="font-size: 14px; color: #334155; margin: 0 0 24px; line-height: 1.6;">
                                Tu cita médica ha sido confirmada para el
                                <strong>
                                    @if($appointment->date instanceof \Carbon\Carbon)
                                        {{ $appointment->date->format('d/m/Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                    @endif
                                </strong>
                                a las <strong>{{ substr($appointment->start_time, 0, 5) }}</strong>.
                            </p>

                            {{-- DETALLE DE LA CITA --}}
                            <table width="100%" cellpadding="12" cellspacing="0" style="background-color: #eff6ff; border-radius: 6px; border: 1px solid #bfdbfe; margin-bottom: 24px;">
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase; width: 40%; vertical-align: top;">Doctor</td>
                                    <td style="color: #0f172a; font-size: 14px;">{{ $appointment->doctor->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase; vertical-align: top; border-top: 1px solid #bfdbfe;">Especialidad</td>
                                    <td style="color: #0f172a; font-size: 14px; border-top: 1px solid #bfdbfe;">{{ $appointment->doctor->speciality->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight: bold; text-transform: uppercase; vertical-align: top; border-top: 1px solid #bfdbfe;">Motivo</td>
                                    <td style="color: #0f172a; font-size: 14px; border-top: 1px solid #bfdbfe;">{{ $appointment->reason }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #334155; margin: 0 0 8px; line-height: 1.6;">
                                Encuentra tu comprobante en PDF adjunto.
                            </p>

                            <p style="font-size: 14px; color: #334155; margin: 24px 0 0; line-height: 1.6;">
                                — <strong>Equipo Healthify</strong>
                            </p>
                        </td>
                    </tr>

                    {{-- PIE --}}
                    <tr>
                        <td style="background-color: #f8fafc; padding: 16px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="font-size: 11px; color: #94a3b8; margin: 0;">
                                Este correo fue generado automáticamente, por favor no responda.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
