<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    DocumentTextIcon,
    ArrowDownTrayIcon,
    EyeIcon,
    MagnifyingGlassIcon,
    CalendarIcon,
    FolderIcon,
    TagIcon,
    BookOpenIcon,
    ClockIcon,
    StarIcon,
    BuildingLibraryIcon,
    GlobeAltIcon,
    ArchiveBoxIcon,
    UserGroupIcon
} from '@heroicons/vue/24/outline';

defineProps({
    statistics: {
        type: Object,
        default: () => ({
            total_documents: 0,
            total_divisions: 0,
            total_categories: 0
        })
    },
    recent_documents: {
        type: Array,
        default: () => []
    },
    documents_per_division: {
        type: Array,
        default: () => []
    },
    documents_per_category: {
        type: Array,
        default: () => []
    }
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Portal Dokumen PT KAI" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Portal Dokumen</h2>
                    <p class="text-slate-500">Sistem Arsip Digital DAOP 6 Yogyakarta</p>
                </div>
            </div>
        </template>

        <!-- Welcome Hero Section -->
        <div class="bg-blue-700 overflow-hidden shadow-xl rounded-lg mb-8">
            <div class="p-8 text-white relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <DocumentTextIcon class="absolute transform rotate-45 -top-8 -right-8 h-32 w-32" />
                    <FolderIcon class="absolute transform -rotate-12 top-1/2 left-1/4 h-24 w-24" />
                </div>

                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex-1">
                            <h1 class="text-3xl lg:text-4xl font-bold mb-3">Sistem Arsip Digital PT KAI</h1>
                            <h2 class="text-xl lg:text-2xl font-semibold mb-3">Daerah Operasi 6 Yogyakarta</h2>
                            <p class="text-blue-100 text-lg mb-6">Akses dokumen operasional untuk pelayanan kereta api yang optimal</p>
                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                <span class="bg-white/20 px-4 py-2 rounded-full flex items-center">
                                    <MagnifyingGlassIcon class="h-4 w-4 mr-2" />
                                    Pencarian Mudah
                                </span>
                                <span class="bg-white/20 px-4 py-2 rounded-full flex items-center">
                                    <FolderIcon class="h-4 w-4 mr-2" />
                                    Kategori Terstruktur
                                </span>
                                <span class="bg-white/20 px-4 py-2 rounded-full flex items-center">
                                    <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                    Download Cepat
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats for Users -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-orange-300">
                            <div class="flex items-center">
                                <div class="bg-orange-500 p-4 rounded-full mr-4">
                                    <DocumentTextIcon class="h-8 w-8 text-white" />
                                </div>
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">Total Dokumen</p>
                                    <p class="text-3xl font-bold mt-1">{{ statistics.total_documents }}</p>
                                    <p class="text-xs text-blue-200 mt-1">Dokumen tersimpan</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-blue-300">
                            <div class="flex items-center">
                                <div class="bg-blue-500 p-4 rounded-full mr-4">
                                    <BuildingLibraryIcon class="h-8 w-8 text-white" />
                                </div>
                                <div>
                                    <p class="text-orange-100 text-sm font-medium">Unit Kerja</p>
                                    <p class="text-3xl font-bold mt-1">{{ statistics.total_divisions }}</p>
                                    <p class="text-xs text-orange-200 mt-1">Divisi aktif</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-white">
                            <div class="flex items-center">
                                <div class="bg-white p-4 rounded-full mr-4">
                                    <TagIcon class="h-8 w-8 text-blue-700" />
                                </div>
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">Kategori</p>
                                    <p class="text-3xl font-bold mt-1">{{ statistics.total_categories }}</p>
                                    <p class="text-xs text-blue-200 mt-1">Jenis dokumen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rest of the content using same pattern as HTML design -->
        <div class="space-y-8">
            <!-- Enhanced Branding Section with New Colors -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- PT KAI Card -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-800 hover:shadow-xl transition-shadow duration-200">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                            <BuildingLibraryIcon class="h-8 w-8 text-blue-800" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">PT KAI</h3>
                        <p class="text-xs text-blue-800">Kereta Api Indonesia</p>
                    </div>
                </div>

                <!-- DAOP 6 Card (Navy Blue) -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-900 hover:shadow-xl transition-shadow duration-200">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                            <BuildingLibraryIcon class="h-8 w-8 text-blue-900" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">DAOP 6</h3>
                        <p class="text-xs text-blue-900">Daerah Operasi 6</p>
                    </div>
                </div>

                <!-- Yogyakarta Card (Green) -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-green-700 hover:shadow-xl transition-shadow duration-200">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                            <GlobeAltIcon class="h-8 w-8 text-green-700" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">Yogyakarta</h3>
                        <p class="text-xs text-green-700">Daerah Istimewa</p>
                    </div>
                </div>

                <!-- Digital Archive Card (Golden) -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-amber-600 hover:shadow-xl transition-shadow duration-200">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-full flex items-center justify-center">
                            <ArchiveBoxIcon class="h-8 w-8 text-amber-600" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">Arsip Digital</h3>
                        <p class="text-xs text-amber-600">Sistem Terintegrasi</p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Quick Actions with New Color Scheme -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Search Documents (Green) -->
                <Link :href="route('documents.index')" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border-l-4 border-green-600 hover:shadow-xl transition-all duration-200">
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-4 rounded-full group-hover:bg-green-200 transition-colors duration-200">
                                <MagnifyingGlassIcon class="h-8 w-8 text-green-700" />
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-semibold text-gray-900">Pencarian Dokumen</h3>
                                <p class="text-gray-600 mt-1">Temukan dokumen operasional dengan cepat</p>
                            </div>
                        </div>
                        <p class="text-sm text-green-700 group-hover:text-green-800 font-medium">
                            Akses dokumen KAI DAOP 6 →
                        </p>
                    </div>
                </Link>

                <!-- Recent Activity (Navy Blue) -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-l-4 border-blue-900">
                    <div class="p-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-4 rounded-full">
                                <ClockIcon class="h-8 w-8 text-blue-900" />
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-semibold text-gray-900">Aktivitas Terbaru</h3>
                                <p class="text-gray-600 mt-1">Update dokumen operasional terkini</p>
                            </div>
                        </div>
                        <p class="text-sm text-blue-900 font-medium">
                            {{ recent_documents.length }} dokumen baru tersedia
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Documents - Enhanced with new colors -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-amber-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <StarIcon class="h-6 w-6 text-amber-600 mr-3" />
                                <h3 class="text-xl font-semibold text-gray-900">Dokumen Terbaru KAI DAOP 6</h3>
                            </div>
                            <Link
                                :href="route('documents.index')"
                                class="text-sm text-blue-900 hover:text-green-700 font-medium bg-blue-50 hover:bg-green-50 px-4 py-2 rounded-lg transition-colors duration-200"
                            >
                                Lihat Semua →
                            </Link>
                        </div>

                        <div v-if="recent_documents.length === 0" class="text-center py-16">
                            <div class="bg-gray-100 rounded-full p-8 w-32 h-32 mx-auto mb-4 flex items-center justify-center">
                                <DocumentTextIcon class="h-16 w-16 text-gray-400" />
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada dokumen</h3>
                            <p class="mt-2 text-gray-500">Dokumen operasional akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="document in recent_documents.slice(0, 6)"
                                :key="document.id"
                                class="flex items-center justify-between p-6 border border-gray-200 rounded-xl hover:shadow-md hover:border-amber-300 transition-all duration-200 group"
                            >
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3 group-hover:bg-amber-100 transition-colors duration-200">
                                            <DocumentTextIcon class="h-5 w-5 text-blue-900 group-hover:text-amber-600" />
                                        </div>
                                        <Link
                                            :href="route('documents.show', document.id)"
                                            class="text-base font-semibold text-gray-900 hover:text-amber-600 truncate group-hover:text-blue-800"
                                        >
                                            {{ document.title }}
                                        </Link>
                                    </div>
                                    <div class="flex flex-wrap items-center text-sm text-gray-500 gap-3 mb-2">
                                        <!-- Unit Kerja Badge (Navy Blue) -->
                                        <span class="inline-flex items-center bg-blue-100 text-blue-900 px-3 py-1 rounded-full">
                                            <BuildingLibraryIcon class="h-3 w-3 mr-1" />
                                            {{ document.division }}
                                        </span>
                                        <!-- Category Badge (Green) -->
                                        <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                            <TagIcon class="h-3 w-3 mr-1" />
                                            {{ document.category }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ formatDate(document.created_at) }} • {{ document.file_size }} • {{ document.uploader }}
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <Link
                                        :href="route('documents.show', document.id)"
                                        class="p-3 text-blue-900 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-all duration-200"
                                        title="Lihat Detail"
                                    >
                                        <EyeIcon class="h-5 w-5" />
                                    </Link>
                                    <a
                                        :href="route('documents.download', document.id)"
                                        class="p-3 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-full transition-all duration-200"
                                        title="Download"
                                    >
                                        <ArrowDownTrayIcon class="h-5 w-5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar Info with New Color Scheme -->
                <div class="space-y-6">
                    <!-- Documents by Division (Navy Blue) -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-900">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <FolderIcon class="h-6 w-6 text-blue-900 mr-3" />
                                <h3 class="text-lg font-semibold text-gray-900">Unit Kerja</h3>
                            </div>

                            <div v-if="documents_per_division.length === 0" class="text-center py-8">
                                <div class="bg-gray-100 rounded-full p-4 w-16 h-16 mx-auto mb-2 flex items-center justify-center">
                                    <FolderIcon class="h-8 w-8 text-gray-400" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Belum ada data unit kerja</p>
                            </div>

                            <div v-else class="space-y-4">
                                <div
                                    v-for="division in documents_per_division.slice(0, 5)"
                                    :key="division.id"
                                    class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                >
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="w-4 h-4 rounded-full mr-3 border-2 border-white shadow-sm bg-blue-800"
                                        ></div>
                                        <span class="text-sm text-gray-700 truncate font-medium">{{ division.name }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-white bg-blue-900 px-3 py-1 rounded-full">{{ division.total_documents }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents by Category (Green) -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-green-700">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <TagIcon class="h-6 w-6 text-green-700 mr-3" />
                                <h3 class="text-lg font-semibold text-gray-900">Kategori</h3>
                            </div>

                            <div v-if="documents_per_category.length === 0" class="text-center py-8">
                                <div class="bg-gray-100 rounded-full p-4 w-16 h-16 mx-auto mb-2 flex items-center justify-center">
                                    <TagIcon class="h-8 w-8 text-gray-400" />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Belum ada data kategori</p>
                            </div>

                            <div v-else class="space-y-4">
                                <div
                                    v-for="category in documents_per_category.slice(0, 5)"
                                    :key="category.id"
                                    class="flex items-center justify-between p-3 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                >
                                    <div class="flex items-center flex-1">
                                        <div
                                            class="w-4 h-4 rounded-full mr-3 border-2 border-white shadow-sm bg-green-700"
                                        ></div>
                                        <span class="text-sm text-gray-700 truncate font-medium">{{ category.name }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-white bg-green-700 px-3 py-1 rounded-full">{{ category.total_documents }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced PT KAI Info Card -->
                    <div class="bg-blue-50 overflow-hidden shadow-lg sm:rounded-xl border-2 border-blue-200">
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-800 p-2 rounded-full mr-3">
                                    <BookOpenIcon class="h-5 w-5 text-white" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tentang Sistem</h3>
                            </div>
                            <div class="text-center mb-4">
                                <!-- Photo placeholder for DAOP 6 building/team -->
                                <div class="bg-blue-100 rounded-xl p-4 w-20 h-20 mx-auto mb-3 flex items-center justify-center overflow-hidden border border-blue-300">
                                    <BuildingLibraryIcon class="h-10 w-10 text-blue-800" />
                                    <!-- Replace with: <img src="/path/to/daop6-building.jpg" alt="DAOP 6" class="w-full h-full object-cover rounded-lg" /> -->
                                </div>
                                <h4 class="font-bold text-blue-800">PT Kereta Api Indonesia</h4>
                                <p class="text-sm text-amber-600 font-medium">Daerah Operasi 6 Yogyakarta</p>
                            </div>
                            <p class="text-sm text-gray-700 mb-4 text-center">
                                Sistem Manajemen Arsip Digital untuk mendukung operasional kereta api yang efisien dan terpadu.
                            </p>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-green-700 rounded-full mr-2"></span>
                                    <span class="text-green-800">Pencarian dokumen operasional</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-blue-900 rounded-full mr-2"></span>
                                    <span class="text-blue-900">Kategorisasi berdasarkan unit kerja</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-amber-600 rounded-full mr-2"></span>
                                    <span class="text-amber-700">Download dokumen standar KAI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

                        