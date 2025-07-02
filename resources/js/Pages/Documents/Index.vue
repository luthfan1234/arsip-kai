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
    MagnifyingGlassIcon,
    PlusCircleIcon
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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mr-4">
                        <DocumentTextIcon class="h-7 w-7 text-white" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Manajemen Dokumen</h2>
                        <p class="text-sm text-orange-600 mt-1">Kelola semua arsip digital</p>
                    </div>
                </div>
                <Link
                    :href="route('documents.create')"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                >
                    <PlusCircleIcon class="w-5 h-5 mr-2" />
                    Tambah Dokumen
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Search and Filters -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <MagnifyingGlassIcon class="h-5 w-5 text-orange-500 mr-2" />
                            Cari & Filter Dokumen
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <TextInput
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Cari berdasarkan judul, nomor dokumen..."
                                        class="pl-10 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                                        @keyup.enter="search"
                                    />
                                </div>
                            </div>

                            <!-- Division Filter -->
                            <div>
                                <select
                                    v-model="selectedDivision"
                                    class="w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
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
                                    class="w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm"
                                    @change="search"
                                >
                                    <option value="">Semua Kategori</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                            <PrimaryButton @click="search" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 w-full sm:w-auto justify-center">
                                <MagnifyingGlassIcon class="h-4 w-4 mr-2" />
                                Cari Dokumen
                            </PrimaryButton>
                            <SecondaryButton @click="clearFilters" class="w-full sm:w-auto justify-center">
                                Hapus Filter
                            </SecondaryButton>
                        </div>
                    </div>
                </div>

                <!-- Documents List -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <DocumentTextIcon class="h-5 w-5 text-orange-500 mr-2" />
                            Daftar Dokumen
                        </h3>
                    </div>

                    <div class="p-6">
                        <div v-if="documents.data.length === 0" class="text-center py-16">
                            <div class="bg-orange-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-4">
                                <DocumentTextIcon class="h-12 w-12 text-orange-400" />
                            </div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada dokumen</h3>
                            <p class="mt-1 text-gray-500 max-w-md mx-auto">
                                Belum ada dokumen yang ditemukan. Silakan tambahkan dokumen baru atau ubah filter pencarian Anda.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="route('documents.create')"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-orange-600 hover:to-orange-700 shadow-md"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Tambah Dokumen
                                </Link>
                            </div>
                        </div>

                        <div v-else>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-orange-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-600 uppercase tracking-wider">
                                                Dokumen
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-600 uppercase tracking-wider">
                                                Divisi / Kategori
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-600 uppercase tracking-wider">
                                                Tanggal Upload
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-orange-600 uppercase tracking-wider">
                                                File
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-orange-600 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="document in documents.data" :key="document.id" class="hover:bg-orange-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-orange-100 flex items-center justify-center mr-3">
                                                        <DocumentTextIcon class="h-5 w-5 text-orange-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ document.title }}
                                                        </div>
                                                        <div v-if="document.description" class="text-sm text-gray-500 truncate max-w-xs">
                                                            {{ document.description }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 mt-1">
                                                            {{ document.document_number }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <div class="flex items-center">
                                                        <div class="h-6 w-6 rounded-md bg-blue-100 flex items-center justify-center mr-2">
                                                            <BuildingOfficeIcon class="h-3 w-3 text-blue-500" />
                                                        </div>
                                                        <span>{{ document.division.name }}</span>
                                                    </div>
                                                    <div class="flex items-center mt-2">
                                                        <div class="h-6 w-6 rounded-md bg-green-100 flex items-center justify-center mr-2">
                                                            <TagIcon class="h-3 w-3 text-green-500" />
                                                        </div>
                                                        <span>{{ document.category.name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <div class="flex items-center">
                                                        <div class="h-6 w-6 rounded-md bg-orange-100 flex items-center justify-center mr-2">
                                                            <CalendarIcon class="h-3 w-3 text-orange-500" />
                                                        </div>
                                                        <span>{{ formatDate(document.upload_date) }}</span>
                                                    </div>
                                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                                        <div class="h-6 w-6 rounded-md bg-purple-100 flex items-center justify-center mr-2">
                                                            <UserIcon class="h-3 w-3 text-purple-500" />
                                                        </div>
                                                        <span>{{ document.uploader.name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">
                                                    {{ document.file_name }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ formatFileSize(document.file_size) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <Link
                                                        :href="route('documents.show', document.id)"
                                                        class="bg-orange-50 p-2 rounded-lg text-orange-600 hover:bg-orange-100 transition-colors duration-150"
                                                        title="Lihat Detail"
                                                    >
                                                        <EyeIcon class="h-5 w-5" />
                                                    </Link>

                                                    <a
                                                        :href="route('documents.download', document.id)"
                                                        class="bg-green-50 p-2 rounded-lg text-green-600 hover:bg-green-100 transition-colors duration-150"
                                                        title="Download"
                                                    >
                                                        <ArrowDownTrayIcon class="h-5 w-5" />
                                                    </a>

                                                    <Link
                                                        v-if="$page.props.auth.user.role === 'admin'"
                                                        :href="route('documents.edit', document.id)"
                                                        class="bg-yellow-50 p-2 rounded-lg text-yellow-600 hover:bg-yellow-100 transition-colors duration-150"
                                                        title="Edit"
                                                    >
                                                        <PencilIcon class="h-5 w-5" />
                                                    </Link>

                                                    <button
                                                        v-if="$page.props.auth.user.role === 'admin'"
                                                        @click="confirmDocumentDeletion(document)"
                                                        class="bg-red-50 p-2 rounded-lg text-red-600 hover:bg-red-100 transition-colors duration-150"
                                                        title="Hapus"
                                                    >
                                                        <TrashIcon class="h-5 w-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div v-if="documents.links.length > 3" class="mt-6">
                                <nav class="flex flex-col sm:flex-row items-center justify-between">
                                    <div class="flex-1 flex justify-between sm:hidden w-full mb-4 sm:mb-0">
                                        <Link
                                            v-if="documents.prev_page_url"
                                            :href="documents.prev_page_url"
                                            class="relative inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                        >
                                            Previous
                                        </Link>
                                        <Link
                                            v-if="documents.next_page_url"
                                            :href="documents.next_page_url"
                                            class="ml-3 relative inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
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
                                                            ? 'z-10 bg-orange-50 border-orange-500 text-orange-600'
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
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <TrashIcon class="h-6 w-6 text-red-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Konfirmasi Penghapusan
                    </h2>
                </div>

                <p class="mb-4 text-gray-600">
                    Apakah Anda yakin ingin menghapus dokumen <span class="font-semibold text-gray-900">"{{ documentToDelete?.title }}"</span>?
                </p>

                <p class="mb-6 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                    Dokumen akan dihapus secara permanen dan tidak dapat dikembalikan.
                </p>

                <div class="flex justify-end gap-3">
                    <SecondaryButton @click="closeDeletionModal">
                        Batal
                    </SecondaryButton>
                    <DangerButton
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
