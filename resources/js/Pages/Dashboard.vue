<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    DocumentTextIcon,
    BuildingOfficeIcon,
    TagIcon,
    UsersIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderOpenIcon,
    PlusCircleIcon,
    ClipboardDocumentListIcon
} from '@heroicons/vue/24/outline';

defineProps({
    statistics: Object,
    recent_documents: Array,
    documents_per_division: Array,
    documents_per_category: Array,
    monthly_uploads: Array,
});

// Format date function
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>
    <Head title="Dashboard Admin PT KAI" />

    <AuthenticatedLayout>
        <template #header>
            <!-- Dashboard Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg">
                        <ChartBarIcon class="h-7 w-7 text-white" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
                        <p class="text-sm text-orange-600 mt-1">Sistem Arsip Digital DAOP 6 Yogyakarta</p>
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

        <div class="space-y-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Documents -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl border border-orange-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <DocumentTextIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-xs font-bold text-orange-600 uppercase tracking-wide">Total Dokumen</p>
                            <p class="text-3xl font-bold text-orange-900 mt-1">{{ statistics.total_documents }}</p>
                            <p class="text-xs text-orange-700 mt-1 font-medium">Dokumen tersimpan</p>
                        </div>
                    </div>
                </div>

                <!-- Total Divisions -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <BuildingOfficeIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wide">Unit Kerja</p>
                            <p class="text-3xl font-bold text-blue-900 mt-1">{{ statistics.total_divisions }}</p>
                            <p class="text-xs text-blue-700 mt-1 font-medium">Divisi aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border border-green-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <TagIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-xs font-bold text-green-600 uppercase tracking-wide">Kategori</p>
                            <p class="text-3xl font-bold text-green-900 mt-1">{{ statistics.total_categories }}</p>
                            <p class="text-xs text-green-700 mt-1 font-medium">Jenis dokumen</p>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl border border-purple-200 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <UsersIcon class="w-8 h-8 text-white" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-xs font-bold text-purple-600 uppercase tracking-wide">Pengguna</p>
                            <p class="text-3xl font-bold text-purple-900 mt-1">{{ statistics.total_users }}</p>
                            <p class="text-xs text-purple-700 mt-1 font-medium">Pegawai aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <Link :href="route('documents.index')" class="group bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl hover:border-orange-300 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <ClipboardDocumentListIcon class="w-7 h-7 text-white" />
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-bold text-gray-900">Kelola Dokumen</h3>
                            <p class="text-sm text-orange-600 mt-1 font-medium">Manajemen arsip digital</p>
                        </div>
                    </div>
                </Link>

                <Link :href="route('divisions.index')" class="group bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <BuildingOfficeIcon class="w-7 h-7 text-white" />
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-bold text-gray-900">Unit Kerja</h3>
                            <p class="text-sm text-blue-600 mt-1 font-medium">Divisi DAOP 6</p>
                        </div>
                    </div>
                </Link>

                <Link :href="route('categories.index')" class="group bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl hover:border-green-300 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <TagIcon class="w-7 h-7 text-white" />
                        </div>
                        <div class="ml-6">
                            <h3 class="text-lg font-bold text-gray-900">Kategori</h3>
                            <p class="text-sm text-green-600 mt-1 font-medium">Klasifikasi dokumen</p>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Content Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Documents -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <FolderOpenIcon class="h-6 w-6 text-orange-600 mr-3" />
                                <h3 class="text-xl font-bold text-gray-900">Dokumen Terbaru</h3>
                            </div>
                            <Link :href="route('documents.index')" class="text-sm font-semibold text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-lg transition-all duration-200">
                                Lihat Semua →
                            </Link>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="recent_documents.length === 0" class="text-center py-16">
                            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <DocumentTextIcon class="w-10 h-10 text-orange-400" />
                            </div>
                            <p class="text-lg font-semibold text-gray-900">Belum ada dokumen</p>
                            <p class="text-sm text-gray-500 mt-2">Dokumen akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="document in recent_documents" :key="document.id"
                                 class="flex items-center justify-between p-5 rounded-xl hover:bg-orange-50 transition-all duration-200 border border-transparent hover:border-orange-200 group">
                                <div class="flex-1 min-w-0">
                                    <Link :href="route('documents.show', document.id)"
                                          class="text-base font-semibold text-gray-900 hover:text-orange-600 truncate block group-hover:text-orange-700">
                                        {{ document.title }}
                                    </Link>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ document.division }} • {{ document.category }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ formatDate(document.created_at) }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <Link :href="route('documents.show', document.id)"
                                          class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-100 rounded-lg transition-all duration-200">
                                        <EyeIcon class="w-5 h-5" />
                                    </Link>
                                    <a :href="route('documents.download', document.id)"
                                       class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-100 rounded-lg transition-all duration-200">
                                        <ArrowDownTrayIcon class="w-5 h-5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents per Division Chart -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <ChartBarIcon class="h-6 w-6 text-blue-600 mr-3" />
                            <h3 class="text-xl font-bold text-gray-900">Dokumen per Unit Kerja</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="documents_per_division.length === 0" class="text-center py-16">
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <BuildingOfficeIcon class="w-10 h-10 text-blue-400" />
                            </div>
                            <p class="text-lg font-semibold text-gray-900">Belum ada data</p>
                            <p class="text-sm text-gray-500 mt-2">Data divisi akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="division in documents_per_division" :key="division.id" class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-700">{{ division.name }}</span>
                                    <span class="text-sm font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-full">{{ division.total_documents }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full bg-gradient-to-r from-orange-500 to-orange-600 transition-all duration-500 shadow-sm"
                                         :style="{ width: (division.total_documents / Math.max(...documents_per_division.map(d => d.total_documents)) * 100) + '%' }">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Upload Chart -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <CalendarIcon class="h-6 w-6 text-orange-600 mr-3" />
                        <h3 class="text-xl font-bold text-gray-900">Upload Dokumen (6 Bulan Terakhir)</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div v-if="monthly_uploads.length === 0" class="text-center py-16">
                        <CalendarIcon class="mx-auto h-16 w-16 text-gray-400" />
                        <p class="mt-4 text-lg font-semibold text-gray-900">Belum ada data upload</p>
                        <p class="mt-2 text-sm text-gray-500">Data upload akan muncul di sini</p>
                    </div>

                    <div v-else class="relative">
                        <!-- Chart Container -->
                        <div class="flex items-end justify-center space-x-4 h-80 px-4">
                            <div v-for="month in monthly_uploads" :key="month.month" 
                                 class="flex-1 flex flex-col items-center max-w-20 group">
                                <!-- Bar -->
                                <div class="w-full bg-gradient-to-t from-orange-500 to-orange-400 rounded-t-xl hover:from-orange-600 hover:to-orange-500 transition-all duration-300 shadow-lg hover:shadow-xl group-hover:scale-105 min-h-4 relative" 
                                     :style="{ height: Math.max(20, (month.count / Math.max(...monthly_uploads.map(m => m.count)) * 250)) + 'px' }">
                                    <!-- Value Label -->
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <span class="bg-gray-900 text-white text-xs px-2 py-1 rounded-lg shadow-lg">
                                            {{ month.count }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Month Label -->
                                <div class="mt-4 text-xs text-gray-600 text-center font-semibold">
                                    {{ month.month }}
                                </div>
                                <!-- Count -->
                                <div class="text-sm font-bold text-gray-800 mt-1">
                                    {{ month.count }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Y-axis labels -->
                        <div class="absolute left-0 top-0 h-80 flex flex-col justify-between text-xs text-gray-400 -ml-8">
                            <span>{{ Math.max(...monthly_uploads.map(m => m.count)) }}</span>
                            <span>{{ Math.round(Math.max(...monthly_uploads.map(m => m.count)) / 2) }}</span>
                            <span>0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents per Category -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <TagIcon class="h-6 w-6 text-green-600 mr-3" />
                        <h3 class="text-xl font-bold text-gray-900">Dokumen per Kategori</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div v-if="documents_per_category.length === 0" class="text-center py-16">
                        <TagIcon class="mx-auto h-16 w-16 text-gray-400" />
                        <p class="mt-4 text-lg font-semibold text-gray-900">Belum ada data kategori</p>
                        <p class="mt-2 text-sm text-gray-500">Data kategori akan muncul setelah ditambahkan</p>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="category in documents_per_category" :key="category.id" 
                             class="p-6 border border-gray-200 rounded-2xl hover:shadow-lg hover:border-green-300 transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg group-hover:text-green-700">{{ category.name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ category.total_documents }} dokumen</p>
                                </div>
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-bold text-xl bg-gradient-to-br from-green-500 to-green-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {{ category.total_documents }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
