<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: props.category.name,
    code: props.category.code,
    description: props.category.description,
    is_active: props.category.is_active,
});

const submit = () => {
    form.put(route('categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Kategori" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
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
                            <div class="mb-4">
                                <label for="is_active" class="flex items-center">
                                    <input type="checkbox" v-model="form.is_active" id="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                </label>
                                <div v-if="form.errors.is_active" class="text-red-600 text-sm mt-1">{{ form.errors.is_active }}</div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('categories.index')" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</Link>
                                <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
