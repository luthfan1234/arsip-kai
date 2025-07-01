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
    Cog6ToothIcon,
    ClipboardDocumentListIcon
} from '@heroicons/vue/24/outline';

defineProps({
    statistics: Object,
    recent_documents: Array,
    documents_per_division: Array,
    documents_per_category: Array,
    monthly_uploads: Array,
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
    <Head title="Dashboard Admin PT KAI" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-600 to-orange-500 p-2 rounded-lg mr-3">
                        <ChartBarIcon class="h-6 w-6 text-white" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">🚆 Dashboard Admin PT KAI</h2>
                        <p class="text-sm text-gray-600">Manajemen Sistem Arsip DAOP 6 Yogyakarta</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('documents.create')"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-orange-600 hover:to-blue-700 transition duration-150 ease-in-out"
                    >
                        <PlusCircleIcon class="h-4 w-4 mr-2" />
                        Tambah Dokumen
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Documents -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-orange-100 p-3 rounded-full">
                                        <DocumentTextIcon class="h-8 w-8 text-orange-600" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Dokumen KAI</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ statistics.total_documents }}</p>
                                    <p class="text-xs text-orange-600">📄 Dokumen operasional</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Divisions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-600">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <BuildingOfficeIcon class="h-8 w-8 text-blue-600" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Unit Kerja DAOP 6</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ statistics.total_divisions }}</p>
                                    <p class="text-xs text-blue-600">🏢 Divisi operasional</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Categories -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <TagIcon class="h-8 w-8 text-blue-600" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Kategori Dokumen</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ statistics.total_categories }}</p>
                                    <p class="text-xs text-blue-600">🏷️ Jenis standar KAI</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-600">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-orange-100 p-3 rounded-full">
                                        <UsersIcon class="h-8 w-8 text-orange-600" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Pengguna Sistem</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ statistics.total_users }}</p>
                                    <p class="text-xs text-orange-600">👥 Pegawai KAI aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Management Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <Link :href="route('documents.index')" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200 border-t-4 border-orange-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-orange-100 p-3 rounded-full group-hover:bg-orange-200 transition-colors duration-200">
                                    <ClipboardDocumentListIcon class="h-6 w-6 text-orange-600" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Kelola Dokumen</h3>
                                    <p class="text-sm text-gray-500">📋 Manajemen dokumen operasional</p>
                                </div>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('divisions.index')" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200 border-t-4 border-blue-600">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors duration-200">
                                    <BuildingOfficeIcon class="h-6 w-6 text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Kelola Unit Kerja</h3>
                                    <p class="text-sm text-gray-500">🏢 Divisi DAOP 6 Yogyakarta</p>
                                </div>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('categories.index')" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200 border-t-4 border-blue-500">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors duration-200">
                                    <TagIcon class="h-6 w-6 text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Kelola Kategori</h3>
                                    <p class="text-sm text-gray-500">🏷️ Standar klasifikasi KAI</p>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Documents -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-orange-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <FolderOpenIcon class="h-5 w-5 text-orange-600 mr-2" />
                                    <h3 class="text-lg font-medium text-gray-900">🚆 Dokumen Terbaru DAOP 6</h3>
                                </div>
                                <Link :href="route('documents.index')" class="text-sm text-blue-600 hover:text-orange-600">
                                    Lihat Semua →
                                </Link>
                            </div>

                            <div v-if="recent_documents.length === 0" class="text-center py-8">
                                <div class="text-4xl mb-2">🚆</div>
                                <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                                <p class="mt-2 text-sm text-gray-500">📄 Belum ada dokumen</p>
                            </div>

                            <div v-else class="space-y-4">
                                <div v-for="document in recent_documents" :key="document.id"
                                     class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 hover:border-orange-300">
                                    <div class="flex-1">
                                        <Link :href="route('documents.show', document.id)"
                                              class="text-sm font-medium text-gray-900 hover:text-orange-600">
                                            📄 {{ document.title }}
                                        </Link>
                                        <p class="text-xs text-gray-500">
                                            🏢 {{ document.division }} • 🏷️ {{ document.category }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            📅 {{ formatDate(document.created_at) }} oleh 👤 {{ document.uploader }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Link :href="route('documents.show', document.id)"
                                              class="text-blue-600 hover:text-blue-800">
                                            <EyeIcon class="h-4 w-4" />
                                        </Link>
                                        <a :href="route('documents.download', document.id)"
                                           class="text-orange-600 hover:text-orange-800">
                                            <ArrowDownTrayIcon class="h-4 w-4" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents per Division Chart -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-600">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <ChartBarIcon class="h-5 w-5 text-blue-600 mr-2" />
                                <h3 class="text-lg font-medium text-gray-900">📊 Dokumen per Unit Kerja</h3>
                            </div>

                            <div v-if="documents_per_division.length === 0" class="text-center py-8">
                                <BuildingOfficeIcon class="mx-auto h-12 w-12 text-gray-400" />
                                <p class="mt-2 text-sm text-gray-500">🏢 Belum ada data divisi</p>
                            </div>

                            <div v-else class="space-y-3">
                                <div v-for="division in documents_per_division" :key="division.id" class="flex items-center">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">🏢 {{ division.name }}</span>
                                            <span class="text-sm text-gray-500">{{ division.total_documents }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-orange-500"
                                                 :style="{
                                                    width: (division.total_documents / Math.max(...documents_per_division.map(d => d.total_documents)) * 100) + '%'
                                                 }">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Upload Chart -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-orange-500">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <CalendarIcon class="h-5 w-5 text-orange-600 mr-2" />
                            <h3 class="text-lg font-medium text-gray-900">📈 Upload Dokumen DAOP 6 (6 Bulan Terakhir)</h3>
                        </div>

                        <div class="flex items-end space-x-2 h-48">
                            <div v-for="month in monthly_uploads" :key="month.month"
                                 class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-gradient-to-t from-orange-500 to-blue-500 rounded-t hover:from-orange-600 hover:to-blue-600 transition-colors duration-200"
                                     :style="{ height: (month.count / Math.max(...monthly_uploads.map(m => m.count)) * 160) + 'px' }">
                                </div>
                                <div class="mt-2 text-xs text-gray-500 text-center">
                                    📅 {{ month.month }}
                                </div>
                                <div class="text-xs font-medium text-gray-700">
                                    {{ month.count }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents per Category -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <TagIcon class="h-5 w-5 text-blue-600 mr-2" />
                            <h3 class="text-lg font-medium text-gray-900">🏷️ Dokumen per Kategori KAI</h3>
                        </div>

                        <div v-if="documents_per_category.length === 0" class="text-center py-8">
                            <TagIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <p class="mt-2 text-sm text-gray-500">🏷️ Belum ada data kategori</p>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="category in documents_per_category" :key="category.id"
                                 class="p-4 border border-gray-200 rounded-lg hover:shadow-md hover:border-orange-300 transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">🏷️ {{ category.name }}</h4>
                                        <p class="text-sm text-gray-500">📄 {{ category.total_documents }} dokumen</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold bg-gradient-to-r from-blue-500 to-orange-500">
                                        {{ category.total_documents }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
