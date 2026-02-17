<!DOCTYPE html>
<html lang="en" 
      x-data="{ 
        mobileMenu: false, 
        darkMode: localStorage.getItem('theme') === 'dark',
        activeSection: 'home' 
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAPS hindu mandir.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=Tenor+Sans&display=swap" rel="stylesheet">
    
    <style>
        :root { --heading: 'Cormorant Garamond', serif; --body: 'Tenor Sans', sans-serif; }
        h1, h2, h3, .serif { font-family: var(--heading); }
        body, p, span, a { font-family: var(--body); letter-spacing: 0.05em; }
        
        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 100px; }

        .nav-floating {
            top: 20px; width: calc(100% - 40px); left: 20px;
            border-radius: 100px; box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        }

        .iphone-toggle {
            position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
            border-radius: 24px; display: flex; align-items: center; justify-content: center;
            z-index: 9999; cursor: pointer; backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        * { transition: background-color 0.5s ease, color 0.5s ease; }
        [x-cloak] { display: none !important; }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { darkBg: '#0a0a0a' } } }
        }
    </script>
</head>
<body class="antialiased bg-[#f9f8f4] text-black dark:bg-darkBg dark:text-zinc-100"
      @scroll.window="
        const sections = ['home', 'collections', 'events', 'about'];
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el && window.scrollY >= el.offsetTop - 160) activeSection = id;
        })
      ">

    {{-- Dark Mode Toggle --}}
    <div @click="darkMode = !darkMode" class="iphone-toggle bg-white/20 dark:bg-white/10 border border-black/5 dark:border-white/10 hover:scale-110 active:scale-95 z-[100]">
        <svg x-show="darkMode" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>
        <svg x-show="!darkMode" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
    </div>

    {{-- Navbar --}}
    <nav class="nav-floating bg-white/90 dark:bg-zinc-900/80 backdrop-blur-xl border border-zinc-100 dark:border-zinc-800 fixed z-50">
        <div class="max-w-full mx-auto px-6 md:px-10 py-5 flex justify-between items-center">
            
            {{-- Adaptive Logo --}}
            <a href="#home" class="text-xl font-bold tracking-[0.3em] text-black dark:text-white italic uppercase">
                <span class="hidden md:inline">{{ $contents['site_name'] ?? 'BAPS hindu mandir' }}</span>
                <span class="md:hidden">BAPS</span>
            </a>
            
            {{-- Navigation Desktop (Visible only on Desktop) --}}
            <div class="hidden md:flex gap-12 text-sm font-bold text-zinc-400 tracking-[0.2em] uppercase">
                <a href="#home" :class="activeSection === 'home' ? 'text-black dark:text-white border-b border-black dark:border-white' : 'hover:text-black dark:hover:text-white'">Home</a>
                <a href="#collections" :class="activeSection === 'collections' ? 'text-black dark:text-white border-b border-black dark:border-white' : 'hover:text-black dark:hover:text-white'">Collections</a>
                <a href="#events" :class="activeSection === 'events' ? 'text-black dark:text-white border-b border-black dark:border-white' : 'hover:text-black dark:hover:text-white'">Events</a>
                <a href="#about" :class="activeSection === 'about' ? 'text-black dark:text-white border-b border-black dark:border-white' : 'hover:text-black dark:hover:text-white'">About</a>
            </div>

            {{-- Auth Section --}}
            <div class="flex items-center gap-4 md:gap-8">
                @auth
                    {{-- User Info (Desktop only) --}}
                    <div class="hidden md:block text-right border-r border-zinc-200 dark:border-zinc-800 pr-6">
                        <p class="text-[8px] text-zinc-400 uppercase tracking-[0.5em] leading-none mb-1 italic font-bold">Authorized</p>
                        <p class="text-[11px] font-bold text-black dark:text-white uppercase tracking-widest">{{ Auth::user()->name }}</p> 
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="hidden md:inline">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold tracking-[0.3em] text-red-400 hover:text-red-600 uppercase transition-all">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="/login" class="hidden md:block text-xs font-bold tracking-[0.3em] dark:text-white hover:opacity-50 transition-all uppercase">LOGIN</a>
                @endauth

                {{-- Hamburger Button (Visible ONLY on Mobile) --}}
                <button @click="mobileMenu = true" class="md:hidden p-2 text-black dark:text-white hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu Overlay (Visible ONLY on Mobile when triggered) --}}
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed inset-0 z-[150] bg-white dark:bg-darkBg flex flex-col p-10 md:hidden" x-cloak>
        
        <div class="flex justify-between items-center mb-20">
            <span class="text-xl font-bold tracking-[0.3em] italic uppercase">S.F</span>
            <button @click="mobileMenu = false" class="text-black dark:text-white p-2 border border-zinc-200 dark:border-zinc-800 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex flex-col gap-8 text-4xl italic font-light">
            <a href="#home" @click="mobileMenu = false" class="hover:translate-x-4 transition-transform text-black dark:text-white">Home</a>
            <a href="#collections" @click="mobileMenu = false" class="hover:translate-x-4 transition-transform text-black dark:text-white">Collections</a>
            <a href="#events" @click="mobileMenu = false" class="hover:translate-x-4 transition-transform text-black dark:text-white">Events</a>
            <a href="#about" @click="mobileMenu = false" class="hover:translate-x-4 transition-transform text-black dark:text-white">About</a>
        </div>

        <div class="mt-auto border-t border-zinc-100 dark:border-zinc-900 pt-10 flex flex-col gap-6">
            @auth
                <p class="text-[10px] uppercase tracking-[0.4em] text-zinc-400">Authorized: {{ Auth::user()->name }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs font-bold tracking-widest text-red-500 uppercase italic">Logout Session</button>
                </form>
            @else
                <a href="/login" class="text-xs font-bold tracking-widest uppercase italic text-black dark:text-white">Login</a>
            @endauth
        </div>
    </div>

    <div class="h-32"></div>

    <main>
        @yield('content')
    </main>
</body>
</html>