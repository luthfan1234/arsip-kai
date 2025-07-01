<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
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
    UserIcon
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
                <DocumentTextIcon class="h-6 w-6 text-blue-600 mr-2" />
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jelajahi Dokumen</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search and Filters -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search Input -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <TextInput
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Cari dokumen berdasarkan judul atau nomor..."
                                        class="pl-10 w-full"
                                        @keyup.enter="search"
                                    />
                                </div>
                            </div>

                            <!-- Division Filter -->
                            <div>
                                <select
                                    v-model="selectedDivision"
                                    @change="search"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
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
                                    @change="search"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="">Semua Kategori</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button
                                    @click="search"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                                >
                                    <MagnifyingGlassIcon class="h-4 w-4 mr-2" />
                                    Cari
                                </button>

                                <button
                                    @click="clearFilters"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300"
                                >
                                    <FunnelIcon class="h-4 w-4 mr-2" />
                                    Reset Filter
                                </button>
                            </div>

                            <div class="text-sm text-gray-500">
                                Menampilkan {{ documents.data.length }} dari {{ documents.total }} dokumen
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Grid -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="documents.data.length === 0" class="text-center py-12">
                            <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokumen ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Coba ubah kata kunci pencarian atau filter yang digunakan.
                            </p>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="document in documents.data"
                                :key="document.id"
                                class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200"
                            >
                                <!-- Document Card Header -->
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center mb-2">
                                                <DocumentTextIcon class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" />
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    v{{ document.version }}
                                                </span>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1 line-clamp-2">
                                                {{ document.title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 mb-2">{{ document.document_number }}</p>
                                        </div>
                                    </div>

                                    <!-- Document Meta Info -->
                                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                                        <div class="flex items-center">
                                            <FolderIcon class="h-4 w-4 mr-2 text-gray-400" />
                                            <span>{{ document.division.name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <TagIcon class="h-4 w-4 mr-2 text-gray-400" />
                                            <span>{{ document.category.name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <CalendarIcon class="h-4 w-4 mr-2 text-gray-400" />
                                            <span>{{ formatDate(document.upload_date) }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <UserIcon class="h-4 w-4 mr-2 text-gray-400" />
                                            <span>{{ document.uploader.name }}</span>
                                        </div>
                                    </div>

                                    <!-- File Info -->
                                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">{{ document.file_name }}</span>
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
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors duration-200"
                                        >
                                            <EyeIcon class="h-4 w-4 mr-2" />
                                            Lihat Detail
                                        </Link>

                                        <a
                                            :href="route('documents.download', document.id)"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors duration-200"
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
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    Menampilkan {{ documents.from }} sampai {{ documents.to }} dari {{ documents.total }} hasil
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Link
                                        v-if="documents.prev_page_url"
                                        :href="documents.prev_page_url"
                                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                                    >
                                        Sebelumnya
                                    </Link>

                                    <span class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md">
                                        {{ documents.current_page }} dari {{ documents.last_page }}
                                    </span>

                                    <Link
                                        v-if="documents.next_page_url"
                                        :href="documents.next_page_url"
                                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                                    >
                                        Selanjutnya
                                    </Link>
                                </div>
                            </div>
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
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>
