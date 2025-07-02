<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { DocumentPlusIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    divisions: Array,
    categories: Array,
});

const fileInput = ref(null);

const form = useForm({
    title: '',
    description: '',
    division_id: '',
    category_id: '',
    version: '1.0',
    file: null,
});

const submit = () => {
    form.post(route('documents.store'), {
        onFinish: () => form.reset('file'),
    });
};

const handleFileChange = (event) => {
    form.file = event.target.files[0];
};
</script>

<template>
    <Head title="Tambah Dokumen" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mr-4">
                    <DocumentPlusIcon class="h-7 w-7 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Dokumen Baru</h2>
                    <p class="text-sm text-orange-600 mt-1">Buat entri dokumen baru dalam sistem</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Back Button -->
                <div class="mb-6">
                    <Link :href="route('documents.index')"
                          class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition-all duration-200">
                        <ArrowLeftIcon class="h-4 w-4 mr-2" />
                        Kembali ke Daftar Dokumen
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gradient-to-br from-orange-50 to-white p-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <DocumentPlusIcon class="h-5 w-5 text-orange-500 mr-2" />
                            Form Tambah Dokumen
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Isi semua informasi yang diperlukan untuk menambahkan dokumen baru</p>
                    </div>

                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Title -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="title" value="Judul Dokumen" class="text-gray-700 font-semibold mb-2" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                    required
                                    autofocus
                                    placeholder="Masukkan judul dokumen"
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="description" value="Deskripsi" class="text-gray-700 font-semibold mb-2" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                                    rows="4"
                                    placeholder="Deskripsi dokumen (opsional)"
                                ></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <!-- Division and Category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-6 rounded-xl">
                                    <InputLabel for="division_id" value="Divisi" class="text-gray-700 font-semibold mb-2" />
                                    <div class="flex items-center mb-3">
                                        <BuildingOfficeIcon class="h-5 w-5 text-blue-500 mr-2" />
                                        <p class="text-sm text-gray-500">Pilih divisi atau unit kerja</p>
                                    </div>
                                    <select
                                        id="division_id"
                                        v-model="form.division_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                                        required
                                    >
                                        <option value="">Pilih Divisi</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">
                                            {{ division.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.division_id" class="mt-2" />
                                </div>

                                <div class="bg-gray-50 p-6 rounded-xl">
                                    <InputLabel for="category_id" value="Kategori" class="text-gray-700 font-semibold mb-2" />
                                    <div class="flex items-center mb-3">
                                        <TagIcon class="h-5 w-5 text-green-500 mr-2" />
                                        <p class="text-sm text-gray-500">Pilih kategori dokumen</p>
                                    </div>
                                    <select
                                        id="category_id"
                                        v-model="form.category_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                                        required
                                    >
                                        <option value="">Pilih Kategori</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.category_id" class="mt-2" />
                                </div>
                            </div>

                            <!-- Version -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="version" value="Versi Dokumen" class="text-gray-700 font-semibold mb-2" />
                                <div class="flex items-center mb-3">
                                    <DocumentIcon class="h-5 w-5 text-orange-500 mr-2" />
                                    <p class="text-sm text-gray-500">Format versi: angka.angka (contoh: 1.0, 2.1)</p>
                                </div>
                                <TextInput
                                    id="version"
                                    v-model="form.version"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                    required
                                    placeholder="Contoh: 1.0, 2.1, etc."
                                />
                                <InputError :message="form.errors.version" class="mt-2" />
                            </div>

                            <!-- File Upload -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <InputLabel for="file" value="File Dokumen" class="text-gray-700 font-semibold mb-2" />
                                <div class="flex items-center mb-3">
                                    <DocumentIcon class="h-5 w-5 text-orange-500 mr-2" />
                                    <p class="text-sm text-gray-500">Unggah file dokumen</p>
                                </div>
                                <input
                                    ref="fileInput"
                                    id="file"
                                    type="file"
                                    @change="handleFileChange"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx"
                                    required
                                />
                                <p class="mt-3 text-xs text-gray-500 bg-gray-100 p-3 rounded-lg">
                                    Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maksimal 10MB)
                                </p>
                                <InputError :message="form.errors.file" class="mt-2" />
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4 border-t border-gray-200">
                                <Link :href="route('documents.index')" class="w-full sm:w-auto">
                                    <SecondaryButton type="button" class="w-full justify-center">
                                        Batal
                                    </SecondaryButton>
                                </Link>

                                <PrimaryButton
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 w-full sm:w-auto justify-center"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Menyimpan...</span>
                                    <span v-else>Simpan Dokumen</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
