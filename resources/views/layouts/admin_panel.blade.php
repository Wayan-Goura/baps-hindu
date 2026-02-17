<!DOCTYPE html>
<html lang="en" x-data="{ 
    sidebarOpen: true,
    darkMode: localStorage.getItem('theme') === 'dark' 
}" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Management | BAPS.co</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=Tenor+Sans&display=swap" rel="stylesheet">
    
    <style>
        :root { --heading: 'Cormorant Garamond', serif; --body: 'Tenor Sans', sans-serif; }
        h1, h2, h3, .serif { font-family: var(--heading); }
        body, p, span, a, button { font-family: var(--body); letter-spacing: 0.05em; }
        
        [x-cloak] { display: none !important; }
        
        .sidebar-transition { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-link { position: relative; transition: all 0.3s ease; }
        .active-link { color: #d4af37 !important; font-weight: bold; }

        /* Styling for Editable Elements */
        .cursor-edit {
            cursor: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewbox='0 0 24 24' fill='none' stroke='%23d4af37' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path></svg>"), auto;
            position: relative;
        }
        .cursor-edit:hover {
            outline: 1px dashed #d4af37;
            outline-offset: 4px;
            background-color: rgba(212, 175, 55, 0.05);
        }

        .iphone-toggle { position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; border-radius: 24px; display: flex; align-items: center; justify-content: center; z-index: 9999; cursor: pointer; backdrop-filter: blur(15px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        * { transition: background-color 0.3s ease, color 0.3s ease; }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { darkBg: '#0a0a0a', darkSidebar: '#000000' } } }
        }
    </script>
</head>
<body class="antialiased bg-[#f9f8f4] text-black dark:bg-darkBg dark:text-zinc-100">

    <div @click="darkMode = !darkMode" class="iphone-toggle bg-white/40 dark:bg-zinc-800/40 border border-black/5 dark:border-white/10 hover:scale-110 active:scale-95 transition-all">
        <svg x-show="darkMode" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>
        <svg x-show="!darkMode" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
    </div>

    <aside class="sidebar-transition fixed top-0 left-0 h-full bg-white dark:bg-darkSidebar border-r border-zinc-200 dark:border-zinc-900 z-50" :class="sidebarOpen ? 'w-72' : 'w-20'">
        <div class="h-32 flex items-center px-8 border-b border-zinc-100 dark:border-zinc-900 overflow-hidden bg-white dark:bg-darkSidebar">
            <div class="text-xl font-bold tracking-[0.3em] uppercase italic whitespace-nowrap" x-show="sidebarOpen">BAPS.CO</div>
            <div class="text-2xl font-bold italic mx-auto" x-show="!sidebarOpen">S.F</div>
        </div>

        <nav class="p-8 space-y-12">
            <div>
                <p class="text-[10px] uppercase tracking-[0.4em] text-zinc-400 mb-8" x-show="sidebarOpen">Systems</p>
                <a href="{{ route('admin.users') }}" class="nav-link flex items-center gap-4 text-xs uppercase tracking-widest {{ Request::is('admin/users*') ? 'active-link' : 'text-zinc-400' }}">
                    <span class="text-zinc-300 font-light text-[14px]">01</span>
                    <span x-show="sidebarOpen">User Management</span>
                </a>
            </div>

            <div>
                <p class="text-[10px] uppercase tracking-[0.4em] text-zinc-400 mb-8" x-show="sidebarOpen">Design & Content</p>
                <a href="{{ route('admin.visual-editor') }}" class="nav-link flex items-center gap-4 text-xs uppercase tracking-widest {{ Request::is('admin/visual-editor*') || Request::is('admin/home*') ? 'active-link' : 'text-zinc-400' }}">
                    <span class="text-zinc-300 font-light text-[14px]">02</span>
                    <span x-show="sidebarOpen">Visual UI Editor</span>
                </a>
            </div>

            <div class="pt-12 border-t border-zinc-100 dark:border-zinc-900">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-4 text-xs uppercase tracking-widest text-red-400 hover:text-red-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span x-show="sidebarOpen">Log out</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="sidebar-transition min-h-screen" :class="sidebarOpen ? 'pl-72' : 'pl-20'">
        <header class="h-32 flex items-center justify-between px-12 border-b border-zinc-100 dark:border-zinc-900 sticky top-0 bg-[#f9f8f4] dark:bg-darkBg z-40">
            <div class="flex items-center gap-8">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                </button>
                <h2 class="text-xs uppercase tracking-[0.5em] text-zinc-400 font-bold">Curator Mode</h2>
            </div>
            <div class="flex items-center gap-8">
                <div class="text-right hidden sm:block">
                    <p class="text-[9px] uppercase tracking-[0.5em] text-zinc-400 leading-none mb-1 italic">Authorized Admin</p>
                    <p class="text-xs font-bold uppercase tracking-widest">{{ Auth::user()->name }}</p>
                </div>
                <div class="h-12 w-12 bg-black text-white dark:bg-white dark:text-black flex items-center justify-center rounded-full text-xs font-bold border border-zinc-200 dark:border-zinc-800">{{ substr(Auth::user()->name, 0, 1) }}</div>
            </div>
        </header>

        <div class="p-12">
            @yield('content')
        </div>
    </main>

    @include('admin.partials.modal_editor')

</body>
</html>