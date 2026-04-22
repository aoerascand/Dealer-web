@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-slate-900 to-green-800 rounded-2xl shadow-2xl overflow-hidden mb-12">
    <div class="px-8 py-16 md:px-16 text-center md:text-left md:flex justify-between items-center text-white">
        x
        <!-- TEXT -->
        <div class="md:w-1/2">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4 text-transparent bg-clip-text bg-gradient-to-r from-green-200 to-white">
                Temukan Motor Impian Anda
            </h1>
            <p class="text-lg text-green-200 mb-8 max-w-lg">
                Dealer resmi terpercaya dengan koleksi motor terlengkap, harga terbaik, dan jaminan purna jual berkualitas. 
            </p>
            <a href="/kategori" class="bg-white text-green-900 hover:bg-green-50 font-bold px-8 py-3.5 rounded-full shadow-lg transition-transform transform active:scale-95 inline-block">
                Lihat Katalog
            </a>
        </div>

        <!-- IMAGE -->
        <div class="md:w-1/2 mt-10 md:mt-0 relative flex justify-center items-center">
            
            <!-- Blur effect (biar tetap keliatan fancy) -->
            <div class="absolute w-64 h-64 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-40"></div>

            <!-- Gambar motor -->
            <img class="animate-float" src="{{ asset('images/motor-removebg-preview.png') }}" 
                 alt="Motor" 
                 class="relative w-[320px] md:w-[420px] object-contain drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>

    </div>
</div>

@endsection
