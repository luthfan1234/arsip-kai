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

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- Recent Documents - Takes 2 columns -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg h-full">
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
                </div>

                <!-- Monthly Uploads Summary -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <CalendarIcon class="h-6 w-6 text-orange-600 mr-3" />
                            <h3 class="text-xl font-bold text-gray-900">Upload Bulanan</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="monthly_uploads.length === 0" class="text-center py-12">
                            <CalendarIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <p class="mt-4 text-base font-semibold text-gray-900">Belum ada data</p>
                            <p class="mt-2 text-sm text-gray-500">Data upload akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="month in monthly_uploads.slice(0, 6)" :key="month.month"
                                 class="flex items-center justify-between p-4 rounded-xl bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ month.month }}</p>
                                    <p class="text-sm text-gray-600">Upload dokumen</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-orange-600">{{ month.count }}</p>
                                    <p class="text-xs text-gray-500">dokumen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Documents per Division -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <BuildingOfficeIcon class="h-6 w-6 text-blue-600 mr-3" />
                            <h3 class="text-xl font-bold text-gray-900">Distribusi per Unit Kerja</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="documents_per_division.length === 0" class="text-center py-12">
                            <BuildingOfficeIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <p class="mt-4 text-base font-semibold text-gray-900">Belum ada data</p>
                            <p class="mt-2 text-sm text-gray-500">Data divisi akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-6">
                            <div v-for="division in documents_per_division.slice(0, 8)" :key="division.id">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-gray-700 truncate">{{ division.name }}</span>
                                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full ml-2">
                                        {{ division.total_documents }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-700"
                                         :style="{ width: (division.total_documents / Math.max(...documents_per_division.map(d => d.total_documents)) * 100) + '%' }">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents per Category -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <TagIcon class="h-6 w-6 text-green-600 mr-3" />
                            <h3 class="text-xl font-bold text-gray-900">Distribusi per Kategori</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="documents_per_category.length === 0" class="text-center py-12">
                            <TagIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <p class="mt-4 text-base font-semibold text-gray-900">Belum ada data kategori</p>
                            <p class="mt-2 text-sm text-gray-500">Data kategori akan muncul setelah ditambahkan</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="category in documents_per_category.slice(0, 6)" :key="category.id"
                                 class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ category.name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ category.total_documents }} dokumen</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold bg-gradient-to-br from-green-500 to-green-600 shadow-md">
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
