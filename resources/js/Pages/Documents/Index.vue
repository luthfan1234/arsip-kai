<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    EyeIcon,
    DocumentTextIcon,
    ArrowDownTrayIcon,
    BuildingOfficeIcon,
    TagIcon,
    CalendarIcon,
    UserIcon,
    MagnifyingGlassIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    documents: Object,
    divisions: Array,
    categories: Array,
    filters: Object,
});

const confirmingDocumentDeletion = ref(false);
const documentToDelete = ref(null);
const searchQuery = ref(props.filters.search || '');
const selectedDivision = ref(props.filters.division || '');
const selectedCategory = ref(props.filters.category || '');

const form = useForm({});

const search = () => {
    router.get(route('documents.index'), {
        search: searchQuery.value,
        division: selectedDivision.value,
        category: selectedCategory.value,
    }, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    searchQuery.value = '';
    selectedDivision.value = '';
    selectedCategory.value = '';
    search();
};

const confirmDocumentDeletion = (document) => {
    documentToDelete.value = document;
    confirmingDocumentDeletion.value = true;
};

const deleteDocument = () => {
    form.delete(route('documents.destroy', documentToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => closeDeletionModal(),
        onFinish: () => form.reset(),
    });
};

const closeDeletionModal = () => {
    confirmingDocumentDeletion.value = false;
    documentToDelete.value = null;
    form.reset();
};

const formatFileSize = (bytes) => {
    const sizes = ['B', 'KB', 'MB', 'GB'];
    if (bytes === 0) return '0 B';
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Dokumen" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <DocumentTextIcon class="h-6 w-6 text-gray-500 mr-2" />
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Dokumen</h2>
                </div>
                <Link
                    :href="route('documents.create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                >
                    <PlusIcon class="h-4 w-4 mr-2" />
                    Tambah Dokumen
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search and Filters -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <TextInput
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Cari dokumen..."
                                        class="pl-10 w-full"
                                        @keyup.enter="search"
                                    />
                                </div>
                            </div>

                            <!-- Division Filter -->
                            <div>
                                <select
                                    v-model="selectedDivision"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    @change="search"
                                >
                                    <option value="">Semua Divisi</option>
                                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                                        {{ division.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <select
                                    v-model="selectedCategory"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    @change="search"
                                >
                                    <option value="">Semua Kategori</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center space-x-2">
                            <PrimaryButton @click="search">
                                <MagnifyingGlassIcon class="h-4 w-4 mr-2" />
                                Cari
                            </PrimaryButton>
                            <SecondaryButton @click="clearFilters">
                                Hapus Filter
                            </SecondaryButton>
                        </div>
                    </div>
                </div>

                <!-- Documents List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="documents.data.length === 0" class="text-center py-12">
                            <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokumen</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan dokumen baru.</p>
                            <div class="mt-6">
                                <Link
                                    :href="route('documents.create')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Tambah Dokumen
                                </Link>
                            </div>
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dokumen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Divisi / Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Upload
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            File
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="document in documents.data" :key="document.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <DocumentTextIcon class="h-8 w-8 text-gray-400 mr-3" />
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ document.title }}
                                                    </div>
                                                    <div v-if="document.description" class="text-sm text-gray-500 truncate max-w-xs">
                                                        {{ document.description }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">
                                                        {{ document.document_number }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <BuildingOfficeIcon class="h-4 w-4 text-gray-400 mr-1" />
                                                    {{ document.division.name }}
                                                </div>
                                                <div class="flex items-center mt-1">
                                                    <TagIcon class="h-4 w-4 text-gray-400 mr-1" />
                                                    {{ document.category.name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <CalendarIcon class="h-4 w-4 text-gray-400 mr-1" />
                                                    {{ formatDate(document.upload_date) }}
                                                </div>
                                                <div class="flex items-center mt-1 text-xs text-gray-500">
                                                    <UserIcon class="h-3 w-3 text-gray-400 mr-1" />
                                                    {{ document.uploader.name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ document.file_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ formatFileSize(document.file_size) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <Link
                                                    :href="route('documents.show', document.id)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    title="Lihat Detail"
                                                >
                                                    <EyeIcon class="h-4 w-4" />
                                                </Link>

                                                <a
                                                    :href="route('documents.download', document.id)"
                                                    class="text-green-600 hover:text-green-900"
                                                    title="Download"
                                                >
                                                    <ArrowDownTrayIcon class="h-4 w-4" />
                                                </a>

                                                <Link
                                                    v-if="$page.props.auth.user.role === 'admin'"
                                                    :href="route('documents.edit', document.id)"
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                    title="Edit"
                                                >
                                                    <PencilIcon class="h-4 w-4" />
                                                </Link>

                                                <button
                                                    v-if="$page.props.auth.user.role === 'admin'"
                                                    @click="confirmDocumentDeletion(document)"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Hapus"
                                                >
                                                    <TrashIcon class="h-4 w-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div v-if="documents.links.length > 3" class="mt-6">
                                <nav class="flex items-center justify-between">
                                    <div class="flex-1 flex justify-between sm:hidden">
                                        <Link
                                            v-if="documents.prev_page_url"
                                            :href="documents.prev_page_url"
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            Previous
                                        </Link>
                                        <Link
                                            v-if="documents.next_page_url"
                                            :href="documents.next_page_url"
                                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            Next
                                        </Link>
                                    </div>
                                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Menampilkan
                                                <span class="font-medium">{{ documents.from }}</span>
                                                sampai
                                                <span class="font-medium">{{ documents.to }}</span>
                                                dari
                                                <span class="font-medium">{{ documents.total }}</span>
                                                hasil
                                            </p>
                                        </div>
                                        <div>
                                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                                <Link
                                                    v-for="link in documents.links"
                                                    :key="link.label"
                                                    :href="link.url"
                                                    :class="[
                                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                                        link.active
                                                            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                                                    ]"
                                                    v-html="link.label"
                                                />
                                            </nav>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Document Modal -->
        <Modal :show="confirmingDocumentDeletion" @close="closeDeletionModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Apakah Anda yakin ingin menghapus dokumen ini?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Dokumen "{{ documentToDelete?.title }}" akan dihapus secara permanen dan tidak dapat dikembalikan.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeDeletionModal"> Batal </SecondaryButton>
                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteDocument"
                    >
                        Hapus Dokumen
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
