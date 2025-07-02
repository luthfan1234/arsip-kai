<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    EyeIcon,
    ArrowDownTrayIcon,
    DocumentTextIcon,
    MagnifyingGlassIcon,
    FunnelIcon,
    CalendarIcon,
    FolderIcon,
    TagIcon,
    UserIcon,
    BuildingOfficeIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    documents: Object,
    divisions: Array,
    categories: Array,
    filters: Object,
});

const searchQuery = ref(props.filters.search || '');
const selectedDivision = ref(props.filters.division || '');
const selectedCategory = ref(props.filters.category || '');

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
    <Head title="Jelajahi Dokumen" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mr-4">
                    <DocumentTextIcon class="h-7 w-7 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Jelajahi Dokumen</h2>
                    <p class="text-sm text-orange-600 mt-1">Temukan dan unduh dokumen arsip</p>
                </div>
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
                                <FunnelIcon class="h-4 w-4 mr-2" />
                                Hapus Filter
                            </SecondaryButton>
                        </div>
                    </div>
                </div>

                <!-- Documents Grid -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <DocumentTextIcon class="h-5 w-5 text-orange-500 mr-2" />
                            Koleksi Dokumen
                        </h3>
                    </div>

                    <div class="p-6">
                        <div v-if="documents.data.length === 0" class="text-center py-16">
                            <div class="bg-orange-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-4">
                                <DocumentTextIcon class="h-12 w-12 text-orange-400" />
                            </div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada dokumen ditemukan</h3>
                            <p class="mt-1 text-gray-500 max-w-md mx-auto">
                                Coba ubah kata kunci pencarian atau filter yang digunakan.
                            </p>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="document in documents.data"
                                :key="document.id"
                                class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-orange-200 transition-all duration-200"
                            >
                                <!-- Document Card Header -->
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <div class="h-8 w-8 rounded-lg bg-orange-100 flex items-center justify-center mr-2">
                                                    <DocumentTextIcon class="h-4 w-4 text-orange-500" />
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    v{{ document.version }}
                                                </span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">
                                                {{ document.title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 mb-2">{{ document.document_number }}</p>
                                        </div>
                                    </div>

                                    <!-- Document Meta Info -->
                                    <div class="space-y-3 text-sm text-gray-600 mb-4">
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-md bg-blue-100 flex items-center justify-center mr-2">
                                                <BuildingOfficeIcon class="h-3 w-3 text-blue-500" />
                                            </div>
                                            <span>{{ document.division.name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-md bg-green-100 flex items-center justify-center mr-2">
                                                <TagIcon class="h-3 w-3 text-green-500" />
                                            </div>
                                            <span>{{ document.category.name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-md bg-orange-100 flex items-center justify-center mr-2">
                                                <CalendarIcon class="h-3 w-3 text-orange-500" />
                                            </div>
                                            <span>{{ formatDate(document.upload_date) }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-md bg-purple-100 flex items-center justify-center mr-2">
                                                <UserIcon class="h-3 w-3 text-purple-500" />
                                            </div>
                                            <span>{{ document.uploader.name }}</span>
                                        </div>
                                    </div>

                                    <!-- File Info -->
                                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600 truncate max-w-[70%]">{{ document.file_name }}</span>
                                            <span class="text-gray-500">{{ formatFileSize(document.file_size) }}</span>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div v-if="document.description" class="mb-4">
                                        <p class="text-sm text-gray-600 line-clamp-3">{{ document.description }}</p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-center space-x-3 pt-4 border-t border-gray-200">
                                        <Link
                                            :href="route('documents.show', document.id)"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-md transition-all duration-200"
                                        >
                                            <EyeIcon class="h-4 w-4 mr-2" />
                                            Lihat Detail
                                        </Link>

                                        <a
                                            :href="route('documents.download', document.id)"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 shadow-md transition-all duration-200"
                                        >
                                            <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="documents.data.length > 0" class="mt-8">
                            <nav class="flex flex-col sm:flex-row items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden w-full mb-4 sm:mb-0">
                                    <Link
                                        v-if="documents.prev_page_url"
                                        :href="documents.prev_page_url"
                                        class="relative inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Sebelumnya
                                    </Link>
                                    <Link
                                        v-if="documents.next_page_url"
                                        :href="documents.next_page_url"
                                        class="ml-3 relative inline-flex items-center justify-center px-4 py-2 w-full border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Selanjutnya
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
    </AuthenticatedLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
