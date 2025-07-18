<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { BuildingOfficeIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    code: '',
    description: '',
});

const submit = () => {
    form.post(route('divisions.store'));
};
</script>

<template>
    <Head title="Tambah Divisi" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg mr-4">
                    <BuildingOfficeIcon class="h-7 w-7 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Divisi Baru</h2>
                    <p class="text-sm text-blue-600 mt-1">Buat divisi atau unit kerja baru</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Back Button -->
                <div class="mb-6">
                    <Link :href="route('divisions.index')"
                          class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition-all duration-200">
                        <ArrowLeftIcon class="h-4 w-4 mr-2" />
                        Kembali ke Daftar Divisi
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gradient-to-br from-blue-50 to-white p-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <BuildingOfficeIcon class="h-5 w-5 text-blue-500 mr-2" />
                            Form Tambah Divisi
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Isi informasi untuk divisi atau unit kerja baru</p>
                    </div>

                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Name -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="name" value="Nama Divisi" class="text-gray-700 font-semibold mb-2" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                    placeholder="Masukkan nama divisi"
                                />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <!-- Code -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="code" value="Kode Divisi" class="text-gray-700 font-semibold mb-2" />
                                <div class="flex items-center mb-3">
                                    <BuildingOfficeIcon class="h-5 w-5 text-blue-500 mr-2" />
                                    <p class="text-sm text-gray-500">Kode unik untuk divisi ini</p>
                                </div>
                                <TextInput
                                    id="code"
                                    v-model="form.code"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required
                                    placeholder="Contoh: SDM, KEU, TI, dll"
                                />
                                <InputError :message="form.errors.code" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="description" value="Deskripsi" class="text-gray-700 font-semibold mb-2" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    rows="4"
                                    placeholder="Deskripsi divisi (opsional)"
                                ></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4 border-t border-gray-200">
                                <Link :href="route('divisions.index')" class="w-full sm:w-auto">
                                    <SecondaryButton type="button" class="w-full justify-center">
                                        Batal
                                    </SecondaryButton>
                                </Link>

                                <PrimaryButton
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 w-full sm:w-auto justify-center"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Menyimpan...</span>
                                    <span v-else>Simpan Divisi</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
