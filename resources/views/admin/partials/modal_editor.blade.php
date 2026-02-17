{{-- Container Utama Modal dengan Alpine.js --}}
<div x-data="{ 
        openModal: false, 
        editLabel: '', 
        editType: '', 
        editKey: '', 
        editValue: '',
        fileName: '' 
    }" 
    @open-editor.window="
        openModal = true; 
        editLabel = $event.detail.label; 
        editType = $event.detail.type; 
        editKey = $event.detail.key; 
        editValue = $event.detail.value;
        fileName = '';
    "
    x-show="openModal" 
    class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-black/95 backdrop-blur-md" 
    x-cloak>
    
    <div class="bg-[#f9f8f4] dark:bg-zinc-900 w-full max-w-xl rounded-[2.5rem] overflow-hidden border border-zinc-200 shadow-2xl" @click.away="openModal = false">
        <div class="p-10">
            <h3 class="serif text-3xl dark:text-white italic mb-8" x-text="editLabel"></h3>
            
            <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Kita kirimkan Key secara dinamis, 'page' tidak lagi wajib jika database Anda hanya berdasarkan Key --}}
                <input type="hidden" name="key" :value="editKey">
                
                <div class="bg-white dark:bg-black rounded-3xl p-6 border border-zinc-100 dark:border-zinc-800">
                    
                    {{-- Input Tipe Text --}}
                    <template x-if="editType === 'text'">
                        <input type="text" name="value" x-model="editValue" class="w-full bg-transparent focus:outline-none dark:text-white text-lg font-medium">
                    </template>

                    {{-- Input Tipe Textarea --}}
                    <template x-if="editType === 'textarea'">
                        <textarea name="value" x-model="editValue" rows="6" class="w-full bg-transparent focus:outline-none dark:text-white leading-relaxed"></textarea>
                    </template>

                    {{-- Input Tipe Image --}}
                    <template x-if="editType === 'image' || editType === 'media'">
                        <div class="text-center py-12">
                            <label class="cursor-pointer group">
                                <div class="h-20 w-20 bg-zinc-100 dark:bg-zinc-800 rounded-full mx-auto flex items-center justify-center group-hover:bg-black group-hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <input type="file" name="value" class="hidden" @change="fileName = $event.target.files[0].name">
                                <p class="mt-4 text-[10px] text-zinc-500 uppercase tracking-widest font-bold" x-text="fileName || 'Click to Select File'"></p>
                            </label>
                        </div>
                    </template>

                </div>

                <div class="mt-10 flex gap-4">
                    <button type="button" @click="openModal = false" class="flex-1 px-8 py-5 border border-zinc-200 rounded-full text-[10px] font-bold tracking-[0.4em] uppercase dark:text-white">Cancel</button>
                    <button type="submit" class="flex-1 bg-black dark:bg-[#d4af37] text-white dark:text-black px-8 py-5 rounded-full text-[10px] font-bold tracking-[0.4em] uppercase shadow-xl hover:scale-105 transition-all">Publish Update</button>
                </div>
            </form>
        </div>
    </div>
</div>