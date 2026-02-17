<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300&family=Tenor+Sans&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Tenor Sans', sans-serif; background-color: #f9f8f4; color: #000; overflow: hidden; }
    .serif { font-family: 'Cormorant Garamond', serif; }
    /* Menghilangkan scrollbar tapi tetap bisa scroll jika benar-benar darurat di layar sangat kecil */
    ::-webkit-scrollbar { display: none; }
</style>

<div class="min-h-screen flex items-center justify-center p-4 md:p-12">
    <div class="w-full max-w-4xl bg-white border border-zinc-200 p-8 md:p-14 shadow-[0_10px_50px_rgba(0,0,0,0.03)]">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <span class="text-xs uppercase tracking-[0.8em] text-zinc-400 block mb-3 font-bold">Authentication</span>
                <h2 class="text-5xl md:text-6xl serif italic leading-none">Member <span class="not-italic">Access</span></h2>
            </div>
            <p class="text-[10px] uppercase tracking-widest text-zinc-400 italic md:text-right">
                New Guardian? <br> 
                <a href="/register" class="text-black font-bold border-b border-black hover:opacity-50 transition-all">Request Access</a>
            </p>
        </div>
        
        <form action="/login" method="POST">
            @csrf
            <div class="grid md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="group">
                    <label class="block text-xs uppercase tracking-widest text-zinc-500 font-bold mb-2">Username</label>
                    <input type="text" name="username" 
                        class="w-full bg-transparent border-b border-zinc-200 py-3 focus:border-black outline-none transition-all serif italic text-xl md:text-2xl" 
                        placeholder="Identify yourself" required>
                </div>
                
                <div class="group">
                    <label class="block text-xs uppercase tracking-widest text-zinc-500 font-bold mb-2">Password</label>
                    <input type="password" name="password" 
                        class="w-full bg-transparent border-b border-zinc-200 py-3 focus:border-black outline-none transition-all serif italic text-xl md:text-2xl" 
                        placeholder="Secret key" required>
                </div>
            </div>

            <div class="mt-12">
                <button type="submit" class="w-full bg-black text-white py-6 text-sm uppercase tracking-[0.5em] font-bold hover:bg-zinc-800 transition-all">
                    Verify & Enter Gallery
                </button>
            </div>
        </form>
    </div>
</div>