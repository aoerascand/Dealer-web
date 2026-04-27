@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-lg">

    <h1 class="text-2xl font-bold mb-6">Edit Karyawan</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Password (opsional)</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('employees.index') }}" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </div>
    </form>

</div>
@endsection