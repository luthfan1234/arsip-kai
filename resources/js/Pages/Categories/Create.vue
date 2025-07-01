<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    code: '',
    description: '',
});

const submit = () => {
    form.post(route('categories.store'));
};
</script>

<template>
    <Head title="Tambah Kategori" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kategori Baru</h2>
        </template>
        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <input v-model="form.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="code" class="block text-sm font-medium text-gray-700">Kode</label>
                                <input v-model="form.code" type="text" id="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <div v-if="form.errors.code" class="text-red-600 text-sm mt-1">{{ form.errors.code }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea v-model="form.description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('categories.index')" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</Link>
                                <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
