@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Karyawan</h1>
        <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Karyawan
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr class="border-t">
                    <td class="p-3">{{ $employee->name }}</td>
                    <td class="p-3">{{ $employee->email }}</td>
                    <td class="p-3 text-center space-x-2">

                        <a href="{{ route('employees.edit', $employee->id) }}" class="bg-yellow-300 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-5 text-center text-gray-500">
                        Belum ada data karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection