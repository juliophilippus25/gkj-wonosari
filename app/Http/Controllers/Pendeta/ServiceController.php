<?php

namespace App\Http\Controllers\Pendeta;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $dataType = 'pelayanan';
        $pendetaId = Auth::id();

        $schedules = Schedule::where('pendeta_id', $pendetaId)->get();

        return view('pendeta.service.index', compact('dataType', 'schedules'));
    }

    public function show($scheduleId)
    {
        $dataType = 'pendaftar';
        $pendetaId = Auth::id();

        $schedule = Schedule::with('services')
            ->where('id', $scheduleId)
            ->where('pendeta_id', $pendetaId)
            ->firstOrFail();

        // Mengambil pendaftar yang mengambil schedule ini
        $registrations = Registration::with(['user', 'region'])->where('schedule_id', $scheduleId)->get();

        return view('pendeta.service.show', compact('dataType','schedule', 'registrations'));
    }

    public function accept($registrationId)
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->status = 'approved';
        $registration->save();

        toast("Pendaftar diterima.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }

    public function reject($registrationId)
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->status = 'rejected';
        $registration->save();

        toast("Pendaftar ditolak.", 'success')->timerProgressBar()->autoClose(5000);
        return redirect()->back();
    }
}
