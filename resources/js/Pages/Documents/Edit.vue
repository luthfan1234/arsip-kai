<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PencilIcon, DocumentIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    document: Object,
    divisions: Array,
    categories: Array,
});

const fileInput = ref(null);

const form = useForm({
    document_number: props.document.document_number,
    title: props.document.title,
    description: props.document.description || '',
    division_id: props.document.division_id,
    category_id: props.document.category_id,
    version: props.document.version,
    file: null,
});

const submit = () => {
    form.put(route('documents.update', props.document.id), {
        onFinish: () => form.reset('file'),
    });
};

const handleFileChange = (event) => {
    form.file = event.target.files[0];
};
</script>

<template>
    <Head title="Edit Dokumen" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <PencilIcon class="h-6 w-6 text-gray-500 mr-2" />
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Dokumen</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Document Number -->
                            <div>
                                <InputLabel for="document_number" value="Nomor Dokumen" />
                                <TextInput
                                    id="document_number"
                                    v-model="form.document_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    placeholder="Nomor dokumen"
                                />
                                <InputError :message="form.errors.document_number" class="mt-2" />
                            </div>

                            <!-- Title -->
                            <div>
                                <InputLabel for="title" value="Judul Dokumen" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    placeholder="Masukkan judul dokumen"
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <InputLabel for="description" value="Deskripsi" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="3"
                                    placeholder="Deskripsi dokumen (opsional)"
                                ></textarea>
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>

                            <!-- Division and Category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="division_id" value="Divisi" />
                                    <select
                                        id="division_id"
                                        v-model="form.division_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required
                                    >
                                        <option value="">Pilih Divisi</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">
                                            {{ division.name }}
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.division_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="category_id" value="Kategori" />
                                    <select
                                        id="category_id"
                                        v-model="form.category_id"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
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
                            <div>
                                <InputLabel for="version" value="Versi Dokumen" />
                                <TextInput
                                    id="version"
                                    v-model="form.version"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    placeholder="Contoh: 1.0, 2.1, etc."
                                />
                                <InputError :message="form.errors.version" class="mt-2" />
                            </div>

                            <!-- Current File Info -->
                            <div v-if="document.file_name" class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <DocumentIcon class="h-5 w-5 text-gray-400 mr-2" />
                                    <span class="text-sm text-gray-600">File saat ini: {{ document.file_name }}</span>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div>
                                <InputLabel for="file" value="Ganti File Dokumen (Opsional)" />
                                <input
                                    ref="fileInput"
                                    id="file"
                                    type="file"
                                    @change="handleFileChange"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx"
                                />
                                <p class="mt-1 text-sm text-gray-500">
                                    Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maksimal 10MB)
                                </p>
                                <InputError :message="form.errors.file" class="mt-2" />
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end space-x-4">
                                <Link :href="route('documents.index')">
                                    <SecondaryButton type="button">
                                        Batal
                                    </SecondaryButton>
                                </Link>

                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Memperbarui...</span>
                                    <span v-else">Perbarui Dokumen</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
