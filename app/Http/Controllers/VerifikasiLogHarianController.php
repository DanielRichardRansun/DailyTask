<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogHarian;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiLogHarianController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->jabatan === 'Staff') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        } else {
            $user = Auth::user();
            $query = LogHarian::with(['pegawai', 'status'])
                ->whereHas('pegawai', function ($query) use ($user) {
                    $query->where('atasan_id', $user->id);
                });

            // Filter berdasarkan tanggal
            $dateFilter = $request->input('date_filter');
            if ($dateFilter) {
                switch ($dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'this_week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'this_month':
                        $query->whereMonth('created_at', now()->month);
                        break;
                }
            }

            // Filter berdasarkan status
            $statusFilter = $request->input('status_filter');
            if ($statusFilter) {
                $query->where('status_id', $statusFilter);
            }

            // Filter berdasarkan nama staff
            $staffFilter = $request->input('staff_filter');
            if ($staffFilter) {
                $query->where('pegawai_id', $staffFilter);
            }

            // Ambil data log yang difilter dan "desc" data baru diatas sendiri
            $logs = $query->orderBy('created_at', 'desc')->get();

            //ambil data buta dropdown
            $statuses = Status::all();
            $staffs = User::where('jabatan', 'Staff')->get();

            return view('log.verifikasi', compact('logs', 'statuses', 'staffs'));
        }
    }

    public function update(Request $request, LogHarian $log)
    {
        $status = $request->status;
        $log->update([
            'status_id' => $status,
            'verified_at' => now(),
        ]);

        return redirect()->route('verifikasi-log.index');
    }
}
