@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12 max-w-5xl mx-auto my-12">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-800">Hubungi Kami</h2>
        <p class="text-slate-500 mt-2">Dapatkan informasi lebih lanjut dengan menghubungi tim kami atau kunjungi showroom kami.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Contact Info -->
        <div class="space-y-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-slate-800">Telepon / WhatsApp</h4>
                    <p class="text-slate-600 mt-1">+62 812-3456-7890</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 bg-pink-100 p-3 rounded-full text-pink-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-slate-800">Instagram</h4>
                    <p class="text-slate-600 mt-1"><a href="https://instagram.com/dealerauto_id" target="_blank" class="hover:text-blue-600">@dealerauto_id</a></p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 bg-green-100 p-3 rounded-full text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-slate-800">Alamat Showroom</h4>
                    <p class="text-slate-600 mt-1">Jl. Otomotif Raya No. 123, Jakarta Selatan, 12345</p>
                </div>
            </div>
        </div>

        <!-- Google Maps iframe -->
        <div class="h-64 md:h-auto rounded-xl overflow-hidden shadow-lg border border-slate-200">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126938.83419515636!2d106.7455828!3d-6.1557022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
@endsection
