@extends('layouts.admin_panel')

@section('content')
<div x-data="{ 
    openEditModal: false,
    editId: '',
    editName: '',
    editUsername: '',

    prepareEdit(user) {
        this.editId = user.id;
        this.editName = user.name;
        this.editUsername = user.username;
        this.openEditModal = true;
    }
}" class="bg-white dark:bg-darkBg min-h-screen p-8 antialiased">
    
    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-xs uppercase tracking-[0.5em] text-zinc-500 font-bold mb-2">Administrative</h2>
                <h1 class="text-5xl italic tracking-tighter text-black dark:text-white">Access Control.</h1>
            </div>
            
            <button @click="$dispatch('open-add-modal')" 
                class="px-8 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full text-[10px] font-bold uppercase tracking-widest hover:scale-105 transition-transform shadow-xl">
                Add New Admin
            </button>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-8 p-4 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-xs uppercase tracking-widest font-bold text-center italic text-black dark:text-white">
                {{ session('success') }}
            </div>
        @endif

        {{-- Users Table --}}
        <div class="bg-white dark:bg-zinc-900 rounded-[2rem] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-bold text-zinc-500">Name</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-bold text-zinc-500">Username</th>
                        <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-bold text-zinc-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($users as $user)
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-8 py-6">
                            <span class="text-lg italic text-black dark:text-white">{{ $user->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400 font-mono">{{ $user->username }}</span>
                        </td>
                        <td class="px-8 py-6 text-right space-x-4">
                            {{-- Edit Button --}}
                            <button @click="prepareEdit({{ json_encode($user) }})" 
                                class="text-[10px] uppercase tracking-widest font-bold text-zinc-400 hover:text-black dark:hover:text-white transition-colors">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this administrator?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] uppercase tracking-widest font-bold text-zinc-400 hover:text-red-600 transition-colors">
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL: EDIT USER --}}
    <div x-show="openEditModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-black/90 backdrop-blur-md" x-transition style="display: none;">
        <div class="bg-white dark:bg-zinc-900 w-full max-w-md rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-zinc-800" @click.away="openEditModal = false">
            <div class="p-10">
                <h3 class="text-3xl dark:text-white italic mb-8">Update Admin.</h3>
                <form :action="'/admin/users/update/' + editId" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block">Full Name</label>
                            <input type="text" name="name" x-model="editName" required class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block">Username</label>
                            <input type="text" name="username" x-model="editUsername" required class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white font-mono">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block text-red-400">New Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white">
                        </div>
                    </div>
                    <div class="mt-10 flex gap-4">
                        <button type="button" @click="openEditModal = false" class="flex-1 px-6 py-4 border border-zinc-200 dark:border-zinc-800 rounded-full text-[10px] font-bold uppercase tracking-widest dark:text-white">Cancel</button>
                        <button type="submit" class="flex-1 bg-black dark:bg-white text-white dark:text-black px-6 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: ADD USER (Menggunakan event listener sederhana) --}}
    <div x-data="{ openAdd: false }" @open-add-modal.window="openAdd = true" x-show="openAdd" class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-black/90 backdrop-blur-md" x-transition style="display: none;">
        <div class="bg-white dark:bg-zinc-900 w-full max-w-md rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-zinc-800 shadow-2xl" @click.away="openAdd = false">
            <div class="p-10">
                <h3 class="text-3xl dark:text-white italic mb-8">New Admin.</h3>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block">Full Name</label>
                            <input type="text" name="name" required class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block">Username</label>
                            <input type="text" name="username" required class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white font-mono">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold text-zinc-500 mb-2 block">Password</label>
                            <input type="password" name="password" required class="w-full bg-zinc-50 dark:bg-black border border-zinc-100 dark:border-zinc-800 rounded-2xl px-6 py-4 focus:outline-none dark:text-white">
                        </div>
                    </div>
                    <div class="mt-10 flex gap-4">
                        <button type="button" @click="openAdd = false" class="flex-1 px-6 py-4 border border-zinc-200 dark:border-zinc-800 rounded-full text-[10px] font-bold uppercase tracking-widest dark:text-white">Cancel</button>
                        <button type="submit" class="flex-1 bg-black dark:bg-white text-white dark:text-black px-6 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-xl">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection