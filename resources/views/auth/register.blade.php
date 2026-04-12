@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-xl overflow-hidden mt-12 border border-slate-100">
    <div class="px-8 py-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Buat Akun Pelanggan</h2>
            <p class="text-slate-500 mt-2">Daftar untuk melakukan pemesanan motor</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 focus:ring-red-500 @enderror">
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 focus:ring-red-500 @enderror">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 focus:ring-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-transform transform active:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </form>
    </div>
    <div class="bg-slate-50 py-4 text-center border-t border-slate-100 text-sm text-slate-500">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk di sini</a>
    </div>
</div>
@endsection
