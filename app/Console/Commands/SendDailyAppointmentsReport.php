<?php

namespace App\Console\Commands;

use App\Mail\DailyAppointmentsReport;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyAppointmentsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía al administrador el listado de citas del día';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', today())
            ->get();

        $admin = User::role('Administrador')->first();
        $adminEmail = $admin ? $admin->email : config('mail.from.address');

        Mail::to($adminEmail)->send(new DailyAppointmentsReport($appointments));

        $this->info('Reporte diario enviado a ' . $adminEmail);
    }
}
