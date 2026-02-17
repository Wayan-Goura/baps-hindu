@extends('layouts.admin_panel')

@section('content')
<div class="space-y-0 bg-white dark:bg-darkBg">
    
    {{-- Indikator Visual Editor --}}
    <div class="mb-10 p-6 bg-[#d4af37]/10 border border-[#d4af37]/30">
        <p class="text-[10px] uppercase tracking-[0.4em] text-[#d4af37] font-bold">
            Mode Editor Aktif: Klik pada elemen teks atau media untuk mengubah konten.
        </p>
    </div>

    {{-- SECTION HERO --}}
    <div class="relative group cursor-help border-2 border-transparent hover:border-[#d4af37] transition-all">
        @include('public.home') {{-- Memanggil Hero --}}
        <div class="absolute inset-0 z-50 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
    </div>

    {{-- SECTION ABOUT --}}
    <div class="relative group cursor-help border-2 border-transparent hover:border-[#d4af37] transition-all">
        @include('public.about')
        <div class="absolute inset-0 z-50 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
    </div>

    {{-- SECTION COLLECTIONS --}}
    <div class="relative group cursor-help border-2 border-transparent hover:border-[#d4af37] transition-all">
        @include('public.collections')
        <div class="absolute inset-0 z-50 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
    </div>

</div>

{{-- Sertakan Modal Editor --}}
@include('admin.partials.modal_editor')

@endsection