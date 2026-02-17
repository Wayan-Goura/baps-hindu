<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition.co | Archival Entrance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=Tenor+Sans&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --heading: 'Cormorant Garamond', serif;
            --body: 'Tenor Sans', sans-serif;
        }
        body { font-family: var(--body); background-color: #ffffff; color: #000000; }
        h1, h2, .serif { font-family: var(--heading); }
        
        /* Animasi Fade In */
        .fade-in { opacity: 0; animation: fadeIn ease 2s forwards; }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased selection:bg-black selection:text-white">

    <nav class="flex justify-between items-center p-10 absolute w-full z-20">
        <div class="text-xl font-light tracking-[0.3em] serif italic">EXHIBITION.CO</div>
        <div class="flex gap-8 items-center">
            <a href="/login" class="text-xs uppercase tracking-widest font-bold border-b border-black pb-1 hover:opacity-50 transition-all">Member Access</a>
        </div>
    </nav>

    <main class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] select-none pointer-events-none">
            <h1 class="text-[35vw] font-black leading-none">6500</h1>
        </div>

        <div class="relative z-10 text-center px-6 fade-in">
            <span class="block text-xs uppercase tracking-[1em] mb-12 text-zinc-600 font-bold">The Preservation Project // 2026</span>
            
            <h2 class="text-[12vw] md:text-[8vw] leading-[0.8] mb-16 italic">
                Eternal <br> <span class="not-italic">Silence.</span>
            </h2>
            
            <div class="flex flex-col md:flex-row gap-12 justify-center items-center">
                <a href="/register" class="bg-black text-white px-16 py-7 text-xs uppercase tracking-[0.6em] font-bold hover:bg-zinc-800 transition-all shadow-2xl">
                    Create Archival ID
                </a>
            </div>
        </div>

        <div class="absolute bottom-12 left-12 hidden lg:block">
            <p class="text-[10px] uppercase tracking-widest text-zinc-400 leading-loose">
                Established <br> MMXVI — Archive
            </p>
        </div>
        <div class="absolute bottom-12 right-12 hidden lg:block">
            <p class="text-[10px] uppercase tracking-widest text-zinc-400 text-right leading-loose">
                Fine Art & <br> Ancient History
            </p>
        </div>
    </main>

</body>
</html>