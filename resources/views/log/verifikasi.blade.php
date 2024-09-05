<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Verifikasi Daily Task') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('verifikasi-log.index') }}" class="mb-4">
                        <div class="flex flex-col space-y-4">
                            <div class="flex space-x-4">
                                <select name="date_filter"  class="rounded-md border-gray-300" style="margin-right: 0.5rem;">
                                    <option value="">Semua Hari</option>
                                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                    
                                <select name="status_filter"  class="rounded-md border-gray-300" style="margin-right: 0.5rem;">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ request('status_filter') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                    
                                <select name="staff_filter" class="rounded-md border-gray-300" style="margin-right: 0.5rem;">
                                    <option value="">Pilih Staff</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->id }}" {{ request('staff_filter') == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" style="background-color: #c2c2c2; color: #ffffff; padding: 0.5rem 1.5rem;border-radius: 0.375rem;font-weight: 600;font-size: 1rem; margin-left:1rem;">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg ">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Atasan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-4">
                                    @if ($log->status->name === 'Pending')
                                        <form action="{{ route('verifikasi-log.update', $log) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
    
                                            <input type="hidden" name="status" value="2">
                                            <button type="submit" style="background-color: #00ff22; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600; margin-right: 0.5rem;">
                                                {{ __('Accept') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('verifikasi-log.update', $log) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
    
                                            <input type="hidden" name="status" value="3">
                                            <button type="submit" style="background-color: #ff0000; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">
                                                {{ __('Refuse') }}
                                            </button>
                                        </form>
                                        @else
                                        <div style="text-align: center">Success Input Status!</div>
                                    @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
