<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Daftar Daily Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('log.index') }}" method="GET" class="mb-4">
                        <div class="flex space-x-4">
                            <!-- Filter berdasarkan nama staff -->
                            <select name="staff" class="rounded-md border-gray-300">
                                <option value="">Pilih Staff</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->name }}" {{ request('staff') == $staff->name ? 'selected' : '' }}>{{ $staff->name }}</option>
                                @endforeach
                            </select>
                    
                            <!-- Filter berdasarkan tanggal -->
                            <select name="filter_date" class="rounded-md border-gray-300">
                                <option value="all" {{ request('filter_date') == 'all' ? 'selected' : '' }}>Semua Hari</option>
                                <option value="today" {{ request('filter_date') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="this_week" {{ request('filter_date') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="this_month" {{ request('filter_date') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            </select>
                    
                            <button type="submit" style="background-color: #c2c2c2; color: #ffffff; padding: 0.5rem 1.5rem;border-radius: 0.375rem;font-weight: 600;font-size: 1rem; margin-left:1rem;">Filter</button>
                        </div>
                    </form>
                    <div class="mb-6 flex space-x-4">
                        {{-- <a href="{{ route('log.create') }}" style="background-color: #4F46E5; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600; margin-right: 0.5rem;">
                            {{ __('Tambah Log') }}
                        </a> --}}
                        {{-- <a href="{{ route('verifikasi-log.index') }}" style="background-color: #4F46E5; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                            {{ __('Verifikasi Log') }}
                        </a> --}}
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Atasan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->pegawai->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->deskripsi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->pegawai->jabatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->pegawai->atasan->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->status->name == 'Disetujui')
                                            <span style="color: #00b406;">{{ $log->status->name }}</span>
                                        @elseif($log->status->name == 'Pending')
                                            <span style="color: #1E90FF;">{{ $log->status->name }}</span>
                                        @elseif($log->status->name == 'Ditolak')
                                            <span style="color: #ff0000;">{{ $log->status->name }}</span>
                                        @else
                                            {{ $log->status->name }}
                                        @endif
                                    </td>
                                    {{-- <td class="px-6 py-4 whitespace-nowrap flex space-x-2"> --}}
                                        {{-- <a href="{{ route('log.edit', $log->id) }}" style="background-color: #00ff22; color: #ffffff; padding: 0.5rem 1rem; border-radius: 1rem; text-decoration: none; font-weight: 600; margin-right: 0.5rem;">
                                            {{ __('Edit') }}
                                        </a>                                                                              
                                        <form action="{{ route('log.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #ff0000; color: #ffffff; padding: 0.5rem 1rem; border-radius: 1rem; text-decoration: none; font-weight: 600;">
                                                {{ __('Delete') }}
                                            </button>
                                        </form> --}}
                                        
                                    {{-- </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
