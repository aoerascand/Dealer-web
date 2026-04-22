@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-xl overflow-hidden mt-12 border border-slate-200">
    
    <div class="px-8 py-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Welcome Back</h2>
            <p class="text-slate-500 mt-2">Sign in to your Dealer Account</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('email') border-red-500 focus:ring-red-500 @enderror">
                
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Password
                </label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-transform transform active:-translate-y-0.5">
                Sign In
            </button>
        </form>
    </div>

    <div class="bg-slate-50 py-4 text-center border-t border-slate-200 text-sm text-slate-500">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">
            Daftar sekarang
        </a>
    </div>
</div>
@endsection