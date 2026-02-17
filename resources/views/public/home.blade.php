@extends('layouts.app')

@section('content')
<div class="bg-white text-black antialiased transition-colors duration-500 dark:bg-darkBg dark:text-zinc-100">
    
{{-- 01. HERO SECTION --}}
<section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden bg-black px-4">
    <div class="absolute inset-0 z-0">
        @php
            $bgAsset = asset($contents['hero_background'] ?? 'https://images.unsplash.com/photo-1551732998-9573f695fdbb?q=80&w=2000');
            $extension = pathinfo($bgAsset, PATHINFO_EXTENSION);
            $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'ogg']);
        @endphp

        {{-- Trigger Editor untuk Background --}}
        @auth
        <div @click="$dispatch('open-editor', { label: 'Hero Background (Media)', type: 'media', key: 'hero_background' })" 
             class="absolute inset-0 z-20 cursor-edit hover:bg-black/20 transition-all flex items-start p-20">
             <span class="bg-[#d4af37] text-black text-[9px] px-3 py-1 font-bold opacity-0 hover:opacity-100 transition-opacity">CHANGE BACKGROUND</span>
        </div>
        @endauth

        @if($isVideo)
            <video autoplay muted loop playsinline class="w-full h-full object-cover opacity-60 grayscale">
                <source src="{{ $bgAsset }}" type="video/{{ $extension }}">
            </video>
        @else
            <img src="{{ $bgAsset }}" class="w-full h-full object-cover opacity-60 grayscale contrast-125" alt="Hero Background">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/70"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto text-center px-6">
        <div class="flex items-center justify-center gap-4 mb-10">
            <div class="w-12 h-[1px] bg-[#d4af37]/50"></div>
            {{-- Tagline Editable --}}
            <span class="text-[#d4af37] text-xs uppercase tracking-[0.6em] font-bold @auth cursor-edit @endauth"
                  @auth @click="$dispatch('open-editor', { label: 'Hero Tagline', type: 'text', key: 'hero_tagline', value: '{{ $contents['hero_tagline'] ?? 'The Ultimate Asset Class' }}' })" @endauth>
                {{ $contents['hero_tagline'] ?? 'The Ultimate Asset Class' }}
            </span>
            <div class="w-12 h-[1px] bg-[#d4af37]/50"></div>
        </div>

        {{-- Title Editable --}}
        {{-- Hero Title --}}
<h1 class=" mb-6 text-white text-6xl lg:text-8xl italic leading-[0.9] tracking-tighter relative z-30 @auth cursor-edit pointer-events-auto @endauth"
    @auth 
    @click.stop="$dispatch('open-editor', { 
        label: 'Hero Title', 
        type: 'textarea', 
        key: 'hero_title', 
        value: '{{ str_replace(["\r", "\n"], '\n', addslashes($contents['hero_title'] ?? "6,500 Years \n In The Making.")) }}' 
    })" 
    @endauth>
    {!! nl2br(e($contents['hero_title'] ?? "6,500 Years \n In The Making.")) !!}
</h1>

{{-- Hero Description --}}
<div class="space-y-8 text-lg lg:text-xl text-white font-sans font-normal leading-relaxed @auth cursor-edit pointer-events-auto @endauth relative z-20"
    @auth 
    @click.stop="$dispatch('open-editor', { 
        label: 'Hero Description', 
        type: 'textarea', 
        key: 'hero_description', 
        value: `{{ $contents['hero_description'] ?? '...' }}` 
    })" 
    @endauth>
    <p class="font-sans antialiased tracking-normal">
        {{ $contents['hero_description'] ?? "Secure a piece of pre-civilization..." }}
    </p>
</div>

        <div x-data="{ open: false }" class="flex flex-col sm:flex-row items-center justify-center gap-4 md:gap-6 mt-16">
    
    {{-- Button Inquire --}}
    <button @click="open = true" class="w-full sm:w-auto bg-[#d4af37] text-black px-12 py-4 text-[10px] font-bold tracking-[0.3em] uppercase hover:bg-white transition-all duration-500 shadow-xl focus:outline-none">
        Inquire Now
    </button>

    {{-- Popup Modal (Contact Card) --}}
    <template x-teleport="body">
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/90 backdrop-blur-md">
            
            <div @click="open = false" class="absolute inset-0 cursor-pointer"></div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white dark:bg-zinc-950 w-full max-w-lg border border-zinc-200 dark:border-zinc-800 shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden">
                
                <div class="absolute top-0 left-0 w-full h-[3px] bg-[#d4af37]"></div>

                <div class="p-10 pb-6 flex justify-between items-start">
                    <div class="space-y-1">
                        <h4 class="text-3xl italic font-serif text-black dark:text-white leading-none">Acquisition Channels</h4>
                        <p class="text-[#d4af37] text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Private & Secure Inquiry</p>
                    </div>
                    <button @click="open = false" class="text-zinc-400 hover:text-black dark:hover:text-white transition-colors p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="px-10 pb-12 space-y-6">
                    <a href="https://wa.me/0881037757134" target="_blank" class="flex items-center gap-6 group p-4 border border-zinc-50 dark:border-zinc-900 hover:border-[#d4af37] transition-all duration-500 bg-zinc-50/50 dark:bg-zinc-900/30">
                        <div class="w-10 h-10 flex items-center justify-center bg-black dark:bg-white text-white dark:text-black group-hover:bg-[#d4af37] group-hover:text-black transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[9px] uppercase tracking-widest text-zinc-400 font-bold">WhatsApp Direct</p>
                            <p class="text-base italic font-serif text-black dark:text-white">+62 881 0377 57134</p>
                        </div>
                    </a>

                    <a href="mailto:goura123wayan.com" class="flex items-center gap-6 group px-4">
                        <div class="w-10 h-10 flex items-center justify-center border border-zinc-200 dark:border-zinc-800 text-[#d4af37] group-hover:border-[#d4af37] transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[9px] uppercase tracking-widest text-zinc-400 font-bold">Official Email</p>
                            <p class="text-base italic font-serif text-black dark:text-white">goura123wayan.com</p>
                        </div>
                    </a>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-900/50 p-6 text-center">
                    <p class="text-[9px] text-zinc-400 uppercase tracking-[0.3em]">Confidentiality Guaranteed — Est. 6500 Years Ago</p>
                </div>
            </div>
        </div>
    </template>
</div>
    </div>
</section>

{{-- 01. THE ORIGIN SECTION --}}
<section id="about" class="py-24 md:py-20 bg-white dark:bg-darkBg text-black dark:text-white px-6 overflow-hidden transition-colors duration-500">
    <div class="max-w-[1400px] mx-auto grid lg:grid-cols-12 gap-16 items-center">
        
        {{-- SISI KIRI: MEDIA (FOTO) --}}
        <div class="lg:col-span-7 relative group">
            <div class="aspect-[4/5] md:aspect-[3/4] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all duration-1000 group-hover:border-[#d4af37]">                @auth
                <div @click="$dispatch('open-editor', { label: 'Origin Image', type: 'media', key: 'origin_main_img' })" 
                     class="absolute inset-0 z-20 cursor-edit hover:bg-black/20 transition-all flex items-center justify-center">
                     <span class="bg-[#d4af37] text-black text-[9px] px-3 py-1 font-bold opacity-0 group-hover:opacity-100 transition-opacity">CHANGE IMAGE</span>
                </div>
                @endauth
                <img src="{{ asset($contents['origin_main_img'] ?? 'https://images.unsplash.com/photo-1549490349-8643362247b5?w=1000') }}" 
                     class="w-full h-full object-cover grayscale contrast-125 group-hover:grayscale-0 transition-all duration-1000">
            </div>

            <div class="absolute -bottom-4 -left-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 shadow-2xl z-30 @auth cursor-edit @endauth"
                 @auth @click="$dispatch('open-editor', { label: 'Years Stats', type: 'text', key: 'origin_year_number', value: '{{ $contents['origin_year_number'] ?? '6500' }}' })" @endauth>
                <span class="block text-6xl font-serif italic text-[#d4af37] leading-none">{{ $contents['origin_year_number'] ?? '6500' }}<sup class="text-sm">+</sup></span>
                <span class="text-[10px] uppercase tracking-[0.5em] text-zinc-500 font-bold">Years of History</span>
            </div>
        </div>

        {{-- SISI KANAN: TEKS --}}
        <div class="lg:col-span-5 space-y-12 relative z-10">
            
            {{-- JUDUL TERPISAH (2 WARNA) --}}
            <div class="space-y-4"> {{-- Menaikkan spacing sedikit agar garis dan judul tidak terlalu rapat --}}
    
    {{-- Tagline dengan Line Dekoratif --}}
    <div class="flex items-center gap-4">
        <div class="w-8 h-[1px] bg-[#d4af37]"></div> {{-- Line di depan --}}
        <span class="text-[#d4af37] text-[12px] tracking-[0.6em] uppercase font-bold @auth cursor-edit @endauth"
              @auth 
                @click.stop="$dispatch('open-editor', { 
                    label: 'Origin Tagline', 
                    type: 'text', 
                    key: 'origin_tagline', 
                    value: `{{ $contents['origin_tagline'] ?? 'The Origin' }}` 
                })" 
              @endauth>
            {{ $contents['origin_tagline'] ?? 'The Origin' }}
        </span>
    </div>
    
    {{-- Judul Split: Putih/Hitam & Grey --}}
    <h2 class="text-5xl m:text-1xl italic leading-[1] tracking-tighter">
        {{-- Baris 1: Warna Utama --}}
        <span class="block text-black dark:text-white @auth cursor-edit @endauth"
              @auth 
                @click.stop="$dispatch('open-editor', { 
                    label: 'Title Upper', 
                    type: 'text', 
                    key: 'origin_title_1', 
                    value: `{{ $contents['origin_title_1'] ?? 'Preserved by' }}` 
                })" 
              @endauth>
            {{ $contents['origin_title_1'] ?? 'Preserved by' }}
        </span>

        {{-- Baris 2: Warna Grey --}}
        <span class="block text-zinc-400 dark:text-zinc-500 @auth cursor-edit @endauth"
              @auth 
                @click.stop="$dispatch('open-editor', { 
                    label: 'Title Lower', 
                    type: 'text', 
                    key: 'origin_title_2', 
                    value: `{{ $contents['origin_title_2'] ?? 'the Elements' }}` 
                })" 
              @endauth>
            {{ $contents['origin_title_2'] ?? 'the Elements' }}
        </span>
    </h2>
</div>

            {{-- DESKRIPSI TERPISAH (FONT BIASA/NORMAL) --}}
            <div class="space-y-8 text-m m:text-xl text-zinc-600 dark:text-zinc-400 leading-relaxed">
    {{-- Paragraf 1 --}}
    <p class="@auth cursor-edit @endauth" 
       style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;"
       @auth @click.stop="$dispatch('open-editor', { label: 'Paragraph 1', type: 'textarea', key: 'origin_p1', value: `{{ $contents['origin_p1'] ?? '' }}` })" @endauth>
        {{ $contents['origin_p1'] ?? 'Subfossil oak, known as bog oak, is history encapsulated.' }}
    </p>
    
    {{-- Paragraf 2 --}}
    <p class="pl-12 @auth cursor-edit @endauth border-l-2 border-[#d4af37]/30"
       style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;"
       @auth @click.stop="$dispatch('open-editor', { label: 'Paragraph 2', type: 'textarea', key: 'origin_p2', value: `{{ $contents['origin_p2'] ?? '' }}` })" @endauth>
        {{ $contents['origin_p2'] ?? 'The timber rests in anaerobic depths, where minerals slowly saturate the grain over millennia.' }}
    </p>

    {{-- Paragraf 3 --}}
    <p class="@auth cursor-edit @endauth" 
       style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;"
       @auth @click.stop="$dispatch('open-editor', { label: 'Paragraph 3', type: 'textarea', key: 'origin_p3', value: `{{ $contents['origin_p3'] ?? '' }}` })" @endauth>
        {{ $contents['origin_p3'] ?? 'Each fiber tells a story of an ancient world, reclaimed and refined for the modern collector.' }}
    </p>
</div>

            {{-- FITUR VERTIKAL DENGAN ICON LEBIH BESAR --}}
            <div class="space-y-12 pt-8 border-t border-zinc-100 dark:border-zinc-800">
    {{-- Feature 1: Global Rarity (Diamond Icon) --}}
    <div class="flex gap-8 items-start @auth cursor-edit @endauth"
         @auth 
            @click.stop="$dispatch('open-editor', { 
                label: 'Feature 1', 
                type: 'textarea', 
                key: 'origin_feat_1', 
                value: `{{ $contents['origin_feat_1'] ?? 'Global Rarity|Under 1% of oak qualifies.' }}` 
            })" 
         @endauth>
        <div class="shrink-0 w-16 h-16 flex items-center justify-center border border-zinc-200 dark:border-zinc-800 shadow-sm">
            {{-- Diamond Icon SVG --}}
            <svg class="w-8 h-8 text-[#d4af37]" viewBox="0 0 512 512" fill="currentColor">
                <path d="M256,475.2L42.2,213.7l37.2-126.3h353.1l37.2,126.3L256,475.2z M82.1,114.6l-28.7,97.3L256,427.5l202.6-215.6l-28.7-97.3 H82.1z"/>
                <path d="M256,475.2L119.5,213.7h273L256,475.2z M157.1,230.9L256,421.4l98.9-190.5H157.1z"/>
                <path d="M432.5,213.7H79.5l37.2-126.3h278.5L432.5,213.7z M112.9,196.5h286.1l-27.1-91.9H140.1L112.9,196.5z"/>
                <circle cx="256" cy="275" r="10"/> {{-- Titik detail sesuai gambar --}}
            </svg>
        </div>
        <div class="space-y-2">
            @php $feat1 = explode('|', $contents['origin_feat_1'] ?? 'Global Rarity|Under 1% of oak qualifies.'); @endphp
            <h4 class="text-[12px] font-bold tracking-[0.4em] uppercase text-black dark:text-white font-sans">{{ $feat1[0] }}</h4>
            <p class="text-base text-zinc-500 font-normal leading-relaxed tracking-normal antialiased" 
               style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;">
                {{ $feat1[1] ?? '' }}
            </p>
        </div>
    </div>

    {{-- Feature 2: Finite Supply (Clock Icon) --}}
    <div class="flex gap-8 items-start @auth cursor-edit @endauth"
         @auth 
            @click.stop="$dispatch('open-editor', { 
                label: 'Feature 2', 
                type: 'textarea', 
                key: 'origin_feat_2', 
                value: `{{ $contents['origin_feat_2'] ?? 'Finite Supply|Diminishing global deposits.' }}` 
            })" 
         @endauth>
        <div class="shrink-0 w-16 h-16 flex items-center justify-center border border-zinc-200 dark:border-zinc-800 shadow-sm">
            {{-- Clock Icon SVG --}}
            <svg class="w-9 h-9 text-[#d4af37]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 16"></polyline>
            </svg>
        </div>
        <div class="space-y-2">
            @php $feat2 = explode('|', $contents['origin_feat_2'] ?? 'Finite Supply|Diminishing global deposits.'); @endphp
            <h4 class="text-[12px] font-bold tracking-[0.4em] uppercase text-black dark:text-white font-sans">{{ $feat2[0] }}</h4>
            <p class="text-base text-zinc-500 font-normal leading-relaxed tracking-normal antialiased" 
               style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;">
                {{ $feat2[1] ?? '' }}
            </p>
        </div>
    </div>
</div>
        </div>
    </div>
</section>

{{-- 02. THE NARRATIVE --}}
<section class="py-20 bg-white dark:bg-darkBg text-black dark:text-white px-6 transition-colors duration-500 border-t border-zinc-100 dark:border-zinc-900">
    <div class="max-w-6xl mx-auto text-center">
        {{-- Span "The Narrative" --}}
        <span class="text-[#d4af37] text-[12px] tracking-[0.8em] uppercase block mb-12 font-bold @auth cursor-edit @endauth"
            @auth 
                @click.stop="$dispatch('open-editor', { 
                    label: 'Narrative Tagline', 
                    type: 'text', 
                    key: 'narrative_tagline', 
                    value: '{{ addslashes($contents['narrative_tagline'] ?? 'The Narrative') }}' 
                })" 
            @endauth>
            {{ $contents['narrative_tagline'] ?? 'The Narrative' }}
        </span>

        {{-- Judul Utama --}}
        <h2 class="text-6xl m:text-[8vw] italic leading-[0.9] tracking-tighter text-black dark:text-white mb-12 @auth cursor-edit @endauth"
            @auth @click.stop="$dispatch('open-editor', { label: 'Quote Text', type: 'textarea', key: 'quote_text', value: '{{ str_replace(["\r", "\n"], '\n', addslashes($contents['quote_text'] ?? '')) }}' })" @endauth>
            "{{ $contents['quote_text'] ?? 'To touch this wood is to bridge a gap of sixty-five centuries.' }}"
        </h2>

        {{-- DESKRIPSI (Tambahan Baru) --}}
        <div class="max-w-1xl mx-auto space-y-8 text-m m:text-xl text-zinc-600 dark:text-zinc-400 leading-relaxed @auth cursor-edit pointer-events-auto @endauth relative z-10"
    @auth 
        @click.stop="$dispatch('open-editor', { 
            label: 'Narrative Description', 
            type: 'textarea', 
            key: 'narrative_description', 
            value: `{{ $contents['narrative_description'] ?? 'Each piece represents a moment frozen in time, transformed by nature into a substance that defies the usual lifecycle of timber. This is not just material; it is a witness to human history, reclaimed from the depths of the earth.' }}` 
        })" 
    @endauth>
    {{-- Menggunakan style sistem standar untuk menjamin font tidak miring dan terlihat "biasa" --}}
    <p style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;" class="antialiased tracking-normal">
        {{ $contents['narrative_description'] ?? 'Each piece represents a moment frozen in time, transformed by nature into a substance that defies the usual lifecycle of timber. This is not just material; it is a witness to human history, reclaimed from the depths of the earth.' }}
    </p>
</div>

        {{-- Garis Pembatas --}}
        <div class="w-24 h-[1px] bg-[#d4af37] mx-auto mt-20"></div>
    </div>
</section>

{{-- SECTION GRID MEDIA & NARRATIVE (REFINED) --}}
<section class="bg-white dark:bg-darkBg transition-colors duration-500 py-18">
    
    {{-- ROW 1: FOTO KIRI (4:3), TEKS KANAN --}}
    <div class="max-w-[1400px] mx-auto grid lg:grid-cols-2 gap-16 items-center px-6 mb-32">
        {{-- Media: Foto dengan Efek Mengambang --}}
        <div class="relative group">
            <div class="absolute -inset-4 bg-zinc-100 dark:bg-zinc-900/50 rounded-xl blur-2xl opacity-50 group-hover:opacity-80 transition-opacity duration-1000"></div>
            
            <div class="relative aspect-[4/3] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all duration-1000 group-hover:border-[#d4af37] bg-white dark:bg-zinc-900">
                @auth
                <div @click="$dispatch('open-editor', { label: 'Grid Photo 1', type: 'media', key: 'grid_img_1', value: '{{ $contents['grid_img_1'] ?? '' }}' })" 
                     class="absolute inset-0 z-20 flex items-center justify-center bg-black/0 hover:bg-black/40 transition-all cursor-edit group/admin">
                    <span class="bg-[#d4af37] text-black text-[9px] px-3 py-1 font-bold opacity-0 group-hover/admin:opacity-100 uppercase tracking-widest">Change Photo</span>
                </div>
                @endauth
                <img src="{{ asset($contents['grid_img_1'] ?? 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1000') }}" 
                     class="w-full h-full object-cover grayscale contrast-125 group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-110">
            </div>
        </div>

        {{-- Teks --}}
        <div class="space-y-8 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-8 h-[1px] bg-[#d4af37]"></div>
                <span class="text-[#d4af37] text-xs md:text-sm tracking-[0.6em] uppercase font-bold @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Grid Subtitle 1', type: 'text', key: 'grid_sub_1', value: '{{ $contents['grid_sub_1'] ?? 'The Material' }}' })" @endauth>
                    {{ $contents['grid_sub_1'] ?? 'The Material' }}
                </span>
            </div>

            {{-- Judul Terpisah: Putih & Grey (Ukuran Lebih Kecil 5xl/7xl) --}}
            <h2 class="text-5xl md:text-1xl lg:text-1xl italic leading-[1] tracking-tighter">
                <span class="block text-black dark:text-white @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Title Upper 1', type: 'text', key: 'grid_title_1_up', value: '{{ $contents['grid_title_1_up'] ?? 'Natural' }}' })" @endauth>
                    {{ $contents['grid_title_1_up'] ?? 'Natural' }}
                </span>
                <span class="block text-zinc-400 dark:text-zinc-500 @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Title Lower 1', type: 'text', key: 'grid_title_1_low', value: '{{ $contents['grid_title_1_low'] ?? 'Unification.' }}' })" @endauth>
                    {{ $contents['grid_title_1_low'] ?? 'Unification.' }}
                </span>
            </h2>

            {{-- Deskripsi: Normal Font Style & Lebih Kecil --}}
            {{-- Deskripsi pada Row 1 (Natural Unification) --}}
<div class="space-y-8 text-lg lg:text-1xl text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-xl">
    
    {{-- Paragraf 1 --}}
    <div class="px-10 @auth cursor-edit @endauth"
         @auth @click.stop="$dispatch('open-editor', { label: 'Grid Desc 1 - P1', type: 'textarea', key: 'grid_desc_1_p1', value: `{{ $contents['grid_desc_1_p1'] ?? '' }}` })" @endauth>
        <p style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important; font-weight: 400 !important; letter-spacing: normal !important; text-transform: none !important;" 
           class="antialiased tracking-normal">
            {{ $contents['grid_desc_1_p1'] ?? 'Forged by millennia of pressure and mineral exchange, resulting in a structural density that rivals stone.' }}
        </p>
    </div>

    {{-- Paragraf 2 --}}
    <div class="px-10 text-[#d4af37]/80 @auth cursor-edit @endauth"
         @auth @click.stop="$dispatch('open-editor', { label: 'Grid Desc 1 - P2', type: 'textarea', key: 'grid_desc_1_p2', value: `{{ $contents['grid_desc_1_p2'] ?? '' }}` })" @endauth>
        <p style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important; font-weight: 400 !important; letter-spacing: normal !important; text-transform: none !important;" 
           class="antialiased tracking-normal">
            {{ $contents['grid_desc_1_p2'] ?? 'The cellular structure of the oak has been replaced by minerals, creating a material that is neither purely wood nor entirely rock.' }}
        </p>
    </div>

    {{-- Paragraf 3 --}}
    <div class="pr-10 @auth cursor-edit @endauth"
         @auth @click.stop="$dispatch('open-editor', { label: 'Grid Desc 1 - P3', type: 'textarea', key: 'grid_desc_1_p3', value: `{{ $contents['grid_desc_1_p3'] ?? '' }}` })" @endauth>
        <p style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important; font-weight: 400 !important; letter-spacing: normal !important; text-transform: none !important;" 
           class="antialiased tracking-normal">
            {{ $contents['grid_desc_1_p3'] ?? 'This rare transformation ensures that every piece is unique, carrying the weight of eons in its grain.' }}
        </p>
    </div>
</div>
        </div>
    </div>

    {{-- ROW 2: TEKS KIRI, VIDEO KANAN (4:3) --}}
    <div class="max-w-[1400px] mx-auto grid lg:grid-cols-12 gap-16 items-center px-6">
        {{-- Teks (Col 5) --}}
        <div class="lg:col-span-5 space-y-8 order-2 lg:order-1 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-8 h-[1px] bg-[#d4af37]"></div>
                <span class="text-[#d4af37] text-xs md:text-sm tracking-[0.6em] uppercase font-bold @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Grid Subtitle 2', type: 'text', key: 'grid_sub_2', value: '{{ $contents['grid_sub_2'] ?? 'The Craft' }}' })" @endauth>
                    {{ $contents['grid_sub_2'] ?? 'The Craft' }}
                </span>
            </div>

            {{-- Judul Terpisah: Putih & Grey --}}
            <h2 class="text-5xl md:text-1xl lg:text-1xl italic leading-[1] tracking-tighter">
                <span class="block text-black dark:text-white @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Title Upper 2', type: 'text', key: 'grid_title_2_up', value: '{{ $contents['grid_title_2_up'] ?? 'Masterful' }}' })" @endauth>
                    {{ $contents['grid_title_2_up'] ?? 'Masterful' }}
                </span>
                <span class="block text-zinc-400 dark:text-zinc-500 @auth cursor-edit @endauth"
                      @auth @click.stop="$dispatch('open-editor', { label: 'Title Lower 2', type: 'text', key: 'grid_title_2_low', value: '{{ $contents['grid_title_2_low'] ?? 'Precision.' }}' })" @endauth>
                    {{ $contents['grid_title_2_low'] ?? 'Precision.' }}
                </span>
            </h2>

            {{-- Deskripsi: Normal Font Style & Lebih Kecil --}}
            <div class="text-lg lg:text-1xl text-base text-zinc-500 @auth cursor-edit @endauth" 
     @auth @click.stop="$dispatch('open-editor', { label: 'Grid Desc 2', type: 'textarea', key: 'grid_desc_2', value: `{{ $contents['grid_desc_2'] ?? '' }}` })" @endauth>
    <p style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; 
              font-style: normal !important; 
              font-weight: 400 !important; 
              line-height: 1.625 !important; 
              letter-spacing: normal !important; 
              text-transform: none !important;">
        {{ $contents['grid_desc_2'] ?? 'Our artisans respect the wood’s ancient journey, using traditional techniques to reveal its deep, obsidian soul.' }}
    </p>
</div>
        </div>

        {{-- Media: Video (Col 7) dengan Efek Mengambang --}}
        <div x-data="{ playing: true, muted: true }" 
             x-init="$watch('muted', value => $refs.videoPlayer.muted = value)"
             class="lg:col-span-7 relative group order-1 lg:order-2">
            
            <div class="absolute -inset-4 bg-zinc-100 dark:bg-zinc-900/50 rounded-xl blur-2xl opacity-50 group-hover:opacity-80 transition-opacity duration-1000"></div>

            <div class="relative aspect-[4/3] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl transition-all duration-1000 group-hover:border-[#d4af37] bg-black">
                @auth
                <div @click="$dispatch('open-editor', { label: 'Grid Video', type: 'media', key: 'grid_vid_2', value: '{{ $contents['grid_vid_2'] ?? '' }}' })" 
                     class="absolute inset-0 z-30 flex items-center justify-center bg-black/0 hover:bg-black/40 transition-all cursor-edit group/admin">
                    <span class="bg-[#d4af37] text-black text-[9px] px-3 py-1 font-bold opacity-0 group-hover/admin:opacity-100 uppercase tracking-widest">Change Video</span>
                </div>
                @endauth

                <video x-ref="videoPlayer" autoplay loop muted playsinline 
                       class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-1000">
                    <source src="{{ asset($contents['grid_vid_2'] ?? 'https://www.w3schools.com/html/mov_bbb.mp4') }}" type="video/mp4">
                </video>

                <div class="absolute bottom-6 right-6 z-40 flex items-center gap-3">
                    <button @click="muted = !muted" type="button" class="p-3 bg-black/40 hover:bg-[#d4af37] backdrop-blur-md border border-white/10 transition-all text-white">
                        <template x-if="muted"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" stroke-width="1.5"/><path d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" stroke-width="1.5"/></svg></template>
                        <template x-if="!muted"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M12 5l-4.707 4.707H4v4h3.293L12 19V5z" stroke-width="1.5"/></svg></template>
                    </button>
                    <button @click="if (playing) { $refs.videoPlayer.pause(); playing = false; } else { $refs.videoPlayer.play(); playing = true; }" type="button" class="p-3 bg-black/40 hover:bg-[#d4af37] backdrop-blur-md border border-white/10 transition-all text-white">
                        <template x-if="playing"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5"/></svg></template>
                        <template x-if="!playing"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" stroke-width="1.5"/></svg></template>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 04. THE COLLECTIONS / ARCHIVE --}}
<section id="collections" class="py-20 border-t border-zinc-100 dark:border-zinc-800 bg-white dark:bg-darkBg transition-colors duration-500">
    <div class="max-w-[1400px] mx-auto text-center mb-24 md:mb-40 px-6">
        {{-- Tagline --}}
        <div class="flex justify-center items-center gap-4 mb-10">
            <div class="w-12 h-[1px] bg-[#d4af37]"></div>
            <span class="text-[#d4af37] text-xs md:text-sm tracking-[0.8em] uppercase font-bold @auth cursor-edit @endauth"
                  @auth @click="$dispatch('open-editor', { label: 'Archive Tagline', type: 'text', key: 'coll_tagline', value: `{{ $contents['coll_tagline'] ?? 'Masterpieces' }}` })" @endauth>
                {{ $contents['coll_tagline'] ?? 'Masterpieces' }}
            </span>
            <div class="w-12 h-[1px] bg-[#d4af37]"></div>
        </div>

        {{-- Judul Utama --}}
        <div class="max-w-6xl mx-auto text-center relative py-10">
            <h2 class="text-5xl md:text-6xl lg:text-7xl italic leading-[0.9] tracking-tighter text-black dark:text-white @auth cursor-edit @endauth inline-block relative z-30"
                @auth @click.stop="$dispatch('open-editor', { label: 'Archive Main Title', type: 'text', key: 'coll_title', value: `{{ $contents['coll_title'] ?? 'SubFossil Archives' }}` })" @endauth>
                {{ $contents['coll_title'] ?? 'SubFossil Archives' }}
            </h2>
            
            {{-- Deskripsi Utama --}}
            <div class="max-w-3xl text-lg lg:text-1xl mx-auto mt-10 mb-8 relative z-30">
                <div class="text-lg lg:text-1xl text-zinc-600 dark:text-zinc-400 font-normal leading-relaxed @auth cursor-edit @endauth"
                     @auth @click.stop="$dispatch('open-editor', { label: 'Archive Description', type: 'textarea', key: 'coll_desc', value: `{{ $contents['coll_desc'] ?? '' }}` })" @endauth>
                    <p style="font-family: ui-sans-serif, system-ui, -apple-system, sans-serif !important; font-style: normal !important;">
                        {{ $contents['coll_desc'] ?? 'From monumental sculptures to spiritual artifacts, Subfossil Oak is the medium of choice for discerning collectors.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- GRID 3 CASE --}}
        <div class="max-w-[1600px] mx-auto px-6 mt-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                @for ($case = 1; $case <= 3; $case++)
                @php
                    $case_titles = [1 => 'Spiritual Significance', 2 => 'Monumental Installations', 3 => 'Museum Grade Artifacts'];
                    $case_descs = [1 => 'Honored for its pre-civilization purity and timeless energy.', 2 => 'Architectural anchors that define luxury through scale.', 3 => 'Preserved with precision, belonging in the world’s elite galleries.'];
                @endphp

                <div x-data="{ currentSlide: 1 }" class="relative group">
                    <div class="relative aspect-[3/4] overflow-hidden bg-zinc-900 border border-zinc-200 dark:border-zinc-800 group-hover:border-[#d4af37] transition-all duration-700 shadow-2xl">
                        
                        {{-- SLIDE FOTO --}}
                        @for ($imgNum = 1; $imgNum <= 3; $imgNum++)
                        @php 
                            $imgKey = "coll_case_{$case}_img_{$imgNum}";
                            $db_img = $contents[$imgKey] ?? 'https://picsum.photos/seed/bog'.$case.$imgNum.'/800/1200';
                        @endphp
                        
                        <div x-show="currentSlide == {{ $imgNum }}" 
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-110"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute inset-0 w-full h-full">
                            
                            {{-- Edit Image Trigger (Z-20) --}}
                            @auth
                            <div @click.stop="$dispatch('open-editor', { label: 'Change Case {{ $case }} Image #{{ $imgNum }}', type: 'media', key: '{{ $imgKey }}', value: '{{ $db_img }}' })" 
                                 class="absolute inset-0 z-20 flex items-center justify-center bg-black/40 opacity-0 hover:opacity-100 transition-opacity cursor-edit">
                                <span class="bg-[#d4af37] text-black text-[10px] px-4 py-2 font-bold tracking-widest uppercase">Change Image {{ $imgNum }}</span>
                            </div>
                            @endauth

                            <img src="{{ asset($db_img) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[2.5s] ease-out">
                        </div>
                        @endfor

                        {{-- Next Button (Z-50 agar selalu di atas) --}}
                        <button @click.stop="currentSlide = currentSlide === 3 ? 1 : currentSlide + 1" 
                                class="absolute top-1/2 right-4 -translate-y-1/2 z-50 w-12 h-12 border border-white/10 bg-black/40 text-white flex items-center justify-center hover:bg-[#d4af37] hover:text-black transition-all backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        {{-- CONTENT AREA (Z-40 agar di atas gambar/overlay) --}}
                        <div class="absolute inset-x-0 bottom-0 p-8 md:p-10 flex flex-col justify-end z-40 pointer-events-none">
                            <div class="w-12 h-[1px] bg-[#d4af37] mb-6 transform origin-left transition-transform duration-1000 group-hover:scale-x-150"></div>
                            
                            {{-- EDITABLE TITLE --}}
                            <h3 class="text-xl md:text-2xl italic font-serif text-white leading-none tracking-tight mb-2 @auth cursor-edit pointer-events-auto @endauth hover:text-[#d4af37] transition-colors"
                                @auth @click.stop="$dispatch('open-editor', { label: 'Edit Case {{ $case }} Title', type: 'text', key: 'coll_title_{{ $case }}', value: `{{ $contents['coll_title_'.$case] ?? $case_titles[$case] }}` })" @endauth>
                                {{ $contents['coll_title_'.$case] ?? $case_titles[$case] }}
                            </h3>

                            {{-- EDITABLE DESCRIPTION (NORMAL FONT) --}}
                            <div class="grid grid-rows-[0fr] opacity-0 group-hover:grid-rows-[1fr] group-hover:opacity-100 transition-all duration-700 pointer-events-none">
                                <div class="overflow-hidden">
                                    <p class="pt-4 text-sm text-zinc-400 font-normal leading-relaxed border-t border-zinc-800/50 mt-4 @auth cursor-edit pointer-events-auto @endauth hover:text-white transition-colors"
                                       style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; font-style: normal !important;"
                                       @auth @click.stop="$dispatch('open-editor', { label: 'Edit Case {{ $case }} Description', type: 'textarea', key: 'coll_desc_{{ $case }}', value: `{{ $contents['coll_desc_'.$case] ?? $case_descs[$case] }}` })" @endauth>
                                        {{ $contents['coll_desc_'.$case] ?? $case_descs[$case] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Indicators --}}
                        <div class="absolute top-8 right-8 flex flex-col items-end gap-2 z-30">
                            <span class="text-[#d4af37] text-[10px] tracking-[0.5em] font-bold opacity-80">CASE 0{{ $case }}</span>
                            <div class="flex gap-1.5">
                                <template x-for="i in 3">
                                    <div :class="currentSlide == i ? 'bg-[#d4af37] w-6' : 'bg-white/20 w-1.5'" class="h-[2px] transition-all duration-500"></div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor

            </div>
        </div>
    </div>
</section>

<section id="blog" class="pt-0 pb-8 bg-white dark:bg-darkBg text-black dark:text-white px-6 transition-colors duration-500 border-t border-zinc-100 dark:border-zinc-900"> {{-- py-18 dikurangi menjadi py-12 --}}
    <div class="max-w-6xl mx-auto text-center relative">
        
        {{-- Tagline dengan Line di Depannya --}}
        <div class="flex items-center justify-center gap-4 mb-2"> 
            <div class="w-8 h-[1px] bg-[#d4af37]"></div>
            <span class="text-[#d4af37] text-[12px] tracking-[0.8em] uppercase font-bold relative z-[99] @auth cursor-edit @endauth"
                @auth 
                    @click.stop="$dispatch('open-editor', { 
                        label: 'Blog Tagline', 
                        type: 'text', 
                        key: 'blog_tagline', 
                        value: `{{ $contents['blog_tagline'] ?? 'Journal' }}` 
                    })" 
                @endauth>
                {{ $contents['blog_tagline'] ?? 'Journal' }}
            </span>
        </div>

        {{-- Judul Besar --}}
        <div class="relative z-[99] mb-2"> {{-- mb-12 dikurangi menjadi mb-6 --}}
            <h2 class="text-5xl md:text-1xl lg:text-1xl italic leading-[0.9] tracking-tighter text-black dark:text-white cursor-edit inline-block"
                @auth 
                    @click.stop="$dispatch('open-editor', { 
                        label: 'Blog Main Title', 
                        type: 'textarea', 
                        key: 'blog_title', 
                        value: `{{ $contents['blog_title'] ?? 'The Untold Stories of Ancient Oak.' }}` 
                    })" 
                @endauth>
                "{{ $contents['blog_title'] ?? 'The Untold Stories of Ancient Oak.' }}"
            </h2>
        </div>

        {{-- Deskripsi --}}
        <div class="max-w-3xl mx-auto mb-8 relative z-[99]"> 
            <div class="space-y-4 text-lg lg:text-1xl text-zinc-600 dark:text-zinc-400 font-normal leading-relaxed @auth cursor-edit @endauth"
                 @auth 
                    @click.stop="$dispatch('open-editor', { 
                        label: 'Blog Description', 
                        type: 'textarea', 
                        key: 'blog_description', 
                        value: `{{ $contents['blog_description'] ?? '' }}` 
                    })" 
                 @endauth>
                <p class="px-10 antialiased tracking-normal" 
                    style="font-family: ui-sans-serif, system-ui, -apple-system, Arial, sans-serif !important; 
                          font-style: normal !important; 
                          font-weight: 400 !important; 
                          text-transform: none !important;
                          letter-spacing: normal !important;">
                    {{ $contents['blog_description'] ?? 'Explore our insights into the preservation process, the geological history of subfossil timber, and the artistic journey of bringing 6,500-year-old wood back to life.' }}
                </p>
            </div>
        </div>

        {{-- Garis Pembatas Bawah --}}
        <div class="w-24 h-[1px] bg-[#d4af37] mx-auto mt-2"></div> {{-- mt-18 dikurangi menjadi mt-6 --}}
    </div>
</section>
<section id="events" class="py-8 md:py-12 bg-white dark:bg-darkBg overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-6">
        <div class="space-y-8 md:space-y-12 pt-4 relative">
            
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-[1px] bg-[#d4af37]/30 -translate-x-1/2 z-0"></div>
            
            @php
                $zigzag_items = [
                    ['id' => 1, 'year' => '4500 BC', 'subtitle' => 'The Submerged Origin', 'img' => 'https://images.unsplash.com/photo-1518133835878-5a93cc3f89e5?w=1200'],
                    ['id' => 2, 'year' => '1500 AD', 'subtitle' => 'Alchemical Evolution', 'img' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?w=1200'],
                    ['id' => 3, 'year' => '2026', 'subtitle' => 'Modern Legacy', 'img' => 'https://images.unsplash.com/photo-1549490349-8643362247b5?w=1200']
                ];
            @endphp

            @foreach($zigzag_items as $z_item)
            <div class="grid md:grid-cols-12 gap-8 md:gap-16 items-center py-6 relative z-10">
                <div class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 bg-[#d4af37] rounded-full shadow-[0_0_15px_rgba(212,175,55,0.5)] z-20"></div>

                <div class="md:col-span-6 group {{ $z_item['id'] % 2 == 0 ? 'order-1 md:order-2' : '' }} relative">
                    <div class="hidden md:block absolute top-1/2 {{ $z_item['id'] % 2 == 0 ? '-left-10' : '-right-10' }} w-10 h-[1px] bg-[#d4af37]/30"></div>
                    
                    @auth
                    <div @click="$dispatch('open-editor', { label: 'Zig-Zag Media {{ $z_item['id'] }}', type: 'media', key: 'extra_art_{{ $z_item['id'] }}_img' })" 
                         class="absolute inset-0 z-20 cursor-edit hover:bg-black/20 transition-all flex items-center justify-center">
                         <span class="bg-[#d4af37] text-black text-[9px] px-3 py-1 font-bold opacity-0 group-hover:opacity-100 transition-opacity">CHANGE IMAGE</span>
                    </div>
                    @endauth

                    <div class="aspect-[16/10] bg-zinc-100 dark:bg-zinc-900 overflow-hidden grayscale border dark:border-zinc-800 hover:grayscale-0 transition-all duration-1000 relative">
                        <img src="{{ asset($contents['extra_art_'.$z_item['id'].'_img'] ?? $z_item['img']) }}" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Kolom Teks --}}
                <div class="md:col-span-6 space-y-2 flex flex-col {{ $z_item['id'] % 2 == 0 ? 'order-2 md:order-1 md:items-end' : 'md:items-start' }}">
                    
                    {{-- Judul & Subtitle tetap mengikuti arah zigzag --}}
                    <div class="{{ $z_item['id'] % 2 == 0 ? 'md:text-right' : 'md:text-left' }}">
                        <h3 class="text-5xl lg:text-7xl italic text-[#d4af37] leading-none tracking-tighter @auth cursor-edit @endauth"
                            @auth @click="$dispatch('open-editor', { label: 'Year Title', type: 'text', key: 'extra_art_{{ $z_item['id'] }}_title', value: `{{ $contents['extra_art_'.$z_item['id'].'_title'] ?? $z_item['year'] }}` })" @endauth>
                            {{ $contents['extra_art_'.$z_item['id'].'_title'] ?? $z_item['year'] }}
                        </h3>

                        <h4 class="text-4xl lg:text-6xl italic text-black dark:text-white leading-tight tracking-tighter @auth cursor-edit @endauth"
                            @auth @click="$dispatch('open-editor', { label: 'Subtitle', type: 'text', key: 'extra_art_{{ $z_item['id'] }}_subtitle', value: `{{ $contents['extra_art_'.$z_item['id'].'_subtitle'] ?? $z_item['subtitle'] }}` })" @endauth>
                            {{ $contents['extra_art_'.$z_item['id'].'_subtitle'] ?? $z_item['subtitle'] }}
                        </h4>
                    </div>

                    {{-- Deskripsi dipaksa Rata Kiri (text-left) --}}
                    <div class="space-y-4 text-base lg:text-1xl text-zinc-600 dark:text-zinc-400 font-normal leading-relaxed max-w-xl text-left @auth cursor-edit @endauth"
                         @auth @click.stop="$dispatch('open-editor', { label: 'Zig-Zag Description', type: 'textarea', key: 'extra_art_{{ $z_item['id'] }}_desc', value: `{{ $contents['extra_art_'.$z_item['id'].'_desc'] ?? '' }}` })" @endauth>
                        <p class="antialiased tracking-normal">{{ $contents['extra_art_'.$z_item['id'].'_desc'] ?? 'A journey through time that began millennia ago.' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 2. PHASE LIST SECTION --}}
<section class="py-12 md:py-16 bg-white dark:bg-darkBg overflow-hidden">
    <div class="max-w-[1200px] mx-auto px-8 lg:px-20">
        <h2 class="text-5xl italic text-black dark:text-white tracking-tighter mb-10 @auth cursor-edit @endauth"
            @auth @click="$dispatch('open-editor', { label: 'Acquisition Title', type: 'textarea', key: 'ev_hero_title', value: `{{ $contents['ev_hero_title'] ?? "Confidential \n Acquisition." }}` })" @endauth>
            {!! nl2br(e($contents['ev_hero_title'] ?? "Confidential \n Acquisition.")) !!}
        </h2>

        <div class="space-y-0 mb-12">
            @for($i=1; $i<=3; $i++)
            @php
                $default_labels = [1 => 'Phase 01', 2 => 'Phase 02', 3 => 'Phase 03'];
                $default_names = [1 => 'Dossier Access', 2 => 'Selection Process', 3 => 'Commissioning'];
            @endphp
            <div class="group grid md:grid-cols-4 gap-4 py-8 border-b border-zinc-100 dark:border-zinc-800 px-4 md:px-12 transition-all">
                {{-- PHASE LABEL EDITOR --}}
                <div class="text-xl font-light italic text-zinc-400 dark:text-zinc-600 @auth cursor-edit @endauth"
                     @auth @click.stop="$dispatch('open-editor', { label: 'Phase Label', type: 'text', key: 'ev_label_{{$i}}', value: `{{ $contents['ev_label_'.$i] ?? $default_labels[$i] }}` })" @endauth>
                    {{ $contents['ev_label_'.$i] ?? $default_labels[$i] }}
                </div>

                <div class="md:col-span-3">
                    {{-- PHASE NAME EDITOR --}}
                    <h3 class="text-1xl italic mb-1 text-black dark:text-white @auth cursor-edit @endauth"
                        @auth @click.stop="$dispatch('open-editor', { label: 'Phase Name', type: 'text', key: 'ev_name_{{$i}}', value: `{{ $contents['ev_name_'.$i] ?? $default_names[$i] }}` })" @endauth>
                        {{ $contents['ev_name_'.$i] ?? $default_names[$i] }}
                    </h3>
                    
                    {{-- PHASE DESC EDITOR --}}
                    <div class="@auth cursor-edit @endauth"
                         @auth @click.stop="$dispatch('open-editor', { label: 'Phase Description', type: 'textarea', key: 'ev_desc_{{$i}}', value: `{{ $contents['ev_desc_'.$i] ?? '' }}` })" @endauth>
                        <p class="text-lg lg:text-2xl text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            {{ $contents['ev_desc_'.$i] ?? 'Finalize the design parameters for your bespoke installation.' }}
                        </p>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

{{-- 3. INVESTMENT SECTION --}}
<section id="investment" class="py-16 md:py-24 bg-white dark:bg-darkBg px-6 border-t border-zinc-100 dark:border-zinc-800">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid lg:grid-cols-12 gap-8 md:gap-12 items-start">
            <div class="lg:col-span-7 space-y-6">
                <div class="space-y-2 relative z-30">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-8 h-[1px] bg-[#d4af37]"></div>
                        <span class="text-[#d4af37] text-[12px] tracking-[0.6em] uppercase font-bold @auth cursor-edit @endauth"
                              @auth @click.stop="$dispatch('open-editor', { label: 'Investment Tagline', type: 'text', key: 'inv_tagline', value: `{{ $contents['inv_tagline'] ?? 'The Asset Class' }}` })" @endauth>
                            {{ $contents['inv_tagline'] ?? 'The Asset Class' }}
                        </span>
                    </div>
                    <h2 class="text-5xl lg:text-1xl italic leading-[1] tracking-tighter">
                        <span class="block text-black dark:text-white @auth cursor-edit @endauth"
                              @auth @click.stop="$dispatch('open-editor', { label: 'Investment Title 1', type: 'text', key: 'inv_title_1', value: `{{ $contents['inv_title_1'] ?? 'Priceless Antiquity.' }}` })" @endauth>
                            {{ $contents['inv_title_1'] ?? 'Priceless Antiquity.' }}
                        </span>
                        <span class="block text-zinc-400 dark:text-zinc-500 @auth cursor-edit @endauth"
                              @auth @click.stop="$dispatch('open-editor', { label: 'Investment Title 2', type: 'text', key: 'inv_title_2', value: `{{ $contents['inv_title_2'] ?? 'Predictable Appreciation.' }}` })" @endauth>
                            {{ $contents['inv_title_2'] ?? 'Predictable Appreciation.' }}
                        </span>
                    </h2>
                </div>

                {{-- MAIN INV DESC --}}
                <div class="@auth cursor-edit @endauth"
                     @auth @click="$dispatch('open-editor', { label: 'Investment Description', type: 'textarea', key: 'inv_desc', value: `{{ $contents['inv_desc'] ?? '' }}` })" @endauth>
                    <p class="text-l text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-xl mb-6">
                        {{ $contents['inv_desc'] ?? 'Subfossil oak is not a commodity. It is a finite resource.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="space-y-2">
                        <h5 class="text-[#d4af37] text-[12px] tracking-[0.4em] uppercase font-bold italic @auth cursor-edit @endauth"
                            @auth @click="$dispatch('open-editor', { label: 'Stat 1 Title', type: 'text', key: 'inv_stat_t1', value: `{{ $contents['inv_stat_t1'] ?? 'Extreme Scarcity' }}` })" @endauth>
                            {{ $contents['inv_stat_t1'] ?? 'Extreme Scarcity' }}
                        </h5>
                        <div class="@auth cursor-edit @endauth" @auth @click="$dispatch('open-editor', { label: 'Stat 1 Desc', type: 'textarea', key: 'inv_stat_d1', value: `{{ $contents['inv_stat_d1'] ?? '' }}` })" @endauth>
                            <p class="text-m text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $contents['inv_stat_d1'] ?? 'Less than 0.01% of the world timber qualifies.' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h5 class="text-[#d4af37] text-[12px] tracking-[0.4em] uppercase font-bold italic @auth cursor-edit @endauth"
                            @auth @click="$dispatch('open-editor', { label: 'Stat 2 Title', type: 'text', key: 'inv_stat_t2', value: `{{ $contents['inv_stat_t2'] ?? 'Generational Hedge' }}` })" @endauth>
                            {{ $contents['inv_stat_t2'] ?? 'Generational Hedge' }}
                        </h5>
                        <div class="@auth cursor-edit @endauth" @auth @click="$dispatch('open-editor', { label: 'Stat 2 Desc', type: 'textarea', key: 'inv_stat_d2', value: `{{ $contents['inv_stat_d2'] ?? '' }}` })" @endauth>
                            <p class="text-m text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $contents['inv_stat_d2'] ?? 'Ultimate store of value for generations.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 p-8 md:p-10 shadow-2xl group hover:border-[#d4af37]">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h4 class="text-4xl italic font-serif text-black dark:text-white mb-1 leading-none tracking-tight @auth cursor-edit @endauth"
                                @auth @click.stop="$dispatch('open-editor', { label: 'Inquiry Title', type: 'text', key: 'inv_inq_title', value: `{{ $contents['inv_inq_title'] ?? 'Acquisition Inquiry' }}` })" @endauth>
                                {{ $contents['inv_inq_title'] ?? 'Acquisition Inquiry' }}
                            </h4>
                            <span class="text-[#d4af37] text-[10px] tracking-[0.3em] uppercase font-bold @auth cursor-edit @endauth"
                                  @auth @click.stop="$dispatch('open-editor', { label: 'Inquiry Sub', type: 'text', key: 'inv_inq_sub', value: `{{ $contents['inv_inq_sub'] ?? 'Confidential Dossier Access' }}` })" @endauth>
                                {{ $contents['inv_inq_sub'] ?? 'Confidential Dossier Access' }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-black/40 p-6 border-l border-[#d4af37] mb-8 shadow-sm">
                        <div class="@auth cursor-edit @endauth" @auth @click.stop="$dispatch('open-editor', { label: 'Quote', type: 'textarea', key: 'inv_quote', value: `{{ $contents['inv_quote'] ?? '' }}` })" @endauth>
                            <p class="text-lg italic text-zinc-600 dark:text-zinc-300 leading-relaxed">"{{ $contents['inv_quote'] ?? "This material doesn't just decorate a room; it anchors a legacy." }}"</p>
                        </div>
                        <div class="@auth cursor-edit @endauth" @auth @click.stop="$dispatch('open-editor', { label: 'Quote Author', type: 'text', key: 'inv_quote_auth', value: `{{ $contents['inv_quote_auth'] ?? 'Chief Curator' }}` })" @endauth>
                            <p class="text-[#d4af37] text-[10px] tracking-widest uppercase mt-4">— {{ $contents['inv_quote_auth'] ?? 'Chief Curator' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <button class="w-full bg-[#d4af37] text-black font-bold uppercase tracking-[0.3em] text-[10px] py-5 shadow-xl">Investment Prospectus</button>
                        <p class="text-[9px] text-center tracking-[0.2em] text-zinc-400 uppercase font-bold">Private & Confidential</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

{{-- Style & Script Tetap Sama --}}
<style>
    section { opacity: 0; transform: translateY(30px); transition: all 1.2s cubic-bezier(0.22, 1, 0.36, 1); }
    section.visible { opacity: 1; transform: translateY(0); }
    html { scroll-behavior: smooth; }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Smooth scaling for serif fonts */
    h3 { font-variant-ligatures: common-ligatures; }
</style>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('section').forEach(s => observer.observe(s));
</script>
@endsection