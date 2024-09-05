<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogHarian;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LogHarianController extends Controller
{

    public function index(Request $request)
    {
        $query = LogHarian::with(['pegawai', 'status']);

        // Filter berdasarkan nama staff
        if ($request->filled('staff')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('name', $request->staff);
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('filter_date')) {
            switch ($request->filter_date) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
            }
        }

        // Ambil data log yang difilter dan "desc" data baru diatas sendiri
        $logs = $query->orderBy('created_at', 'desc')->get();

        // Ambil semua pegawai untuk dropdown filter
        $staffs = User::all();

        return view('log.index', compact('logs', 'staffs'));
    }

    public function logSaya(Request $request)
    {
        $user = Auth::user();
        $query = LogHarian::where('pegawai_id', $user->id);
        $filter = $request->input('filter');

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month);
                break;
            default:
                // Tidak ada filter khusus
                break;
        }

        // Ambil data log yang difilter dan "desc" data baru diatas sendiri
        $logs = $query->orderBy('created_at', 'desc')->get();

        return view('log.log-saya', compact('logs'));
    }


    public function create()
    {
        $users = User::all();
        return view('log.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
        ]);

        // Simpan data ke database
        $log = new LogHarian();
        $log->pegawai_id = auth()->user()->id; //mengambil id user
        $log->status_id = 1;
        $log->deskripsi = $request->input('deskripsi');
        $log->created_at = now()->setTimezone('Asia/Jakarta');
        $log->save();

        return redirect()->route('log.index')->with('status', 'Log Harian berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $log = LogHarian::findOrFail($id);
        return view('log.edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $log = LogHarian::findOrFail($id);

        $request->validate([
            'deskripsi' => 'required',
        ]);

        $log->deskripsi = $request->input('deskripsi');
        $log->created_at = now()->setTimezone('Asia/Jakarta');
        $log->save();

        return redirect()->route('log.index')->with('status', 'Log Harian berhasil diperbarui!');
    }



    public function destroy($id)
    {
        $log = LogHarian::findOrFail($id);
        Log::info('Request reached destroy method', ['log_id' => $log->id]);
        $log->delete();
        return redirect()->route('log.index')->with('status', 'Log Harian berhasil dihapus!');
    }
}
