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
    statistics: {
        type: Object,
        default: () => ({
            total_documents: 0,
            total_divisions: 0,
            total_categories: 0,
            total_users: 0
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
    },
    monthly_uploads: {
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
    <Head title="Dashboard Admin PT KAI" />

    <AuthenticatedLayout>
        <template #header>
            <!-- Judul Dashboard -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Dashboard Admin</h2>
                    <p class="text-slate-500">Sistem Arsip Digital DAOP 6 Yogyakarta</p>
                </div>
                <Link
                    :href="route('documents.create')"
                    class="bg-orange-500 text-white font-bold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-orange-600 transition-colors"
                >
                    <PlusCircleIcon class="w-5 h-5" />
                    <span>TAMBAH DOKUMEN</span>
                </Link>
            </div>
        </template>

        <!-- Kartu KPI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Documents -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-orange-500 flex items-center space-x-4">
                <div class="bg-orange-100 p-3 rounded-lg">
                    <DocumentTextIcon class="w-6 h-6 text-orange-600" />
                </div>
                <div>
                    <p class="text-slate-500 text-sm">TOTAL DOKUMEN</p>
                    <p class="text-2xl font-bold text-slate-800">{{ statistics.total_documents }}</p>
                    <p class="text-xs text-slate-400">Arsip Digital KAI</p>
                </div>
            </div>

            <!-- Total Divisions -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-blue-500 flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <BuildingOfficeIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <p class="text-slate-500 text-sm">UNIT KERJA</p>
                    <p class="text-2xl font-bold text-slate-800">{{ statistics.total_divisions }}</p>
                    <p class="text-xs text-slate-400">Divisi DAOP 6</p>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500 flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <TagIcon class="w-6 h-6 text-green-600" />
                </div>
                <div>
                    <p class="text-slate-500 text-sm">KATEGORI</p>
                    <p class="text-2xl font-bold text-slate-800">{{ statistics.total_categories }}</p>
                    <p class="text-xs text-slate-400">Klasifikasi Dokumen</p>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-yellow-500 flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <UsersIcon class="w-6 h-6 text-yellow-600" />
                </div>
                <div>
                    <p class="text-slate-500 text-sm">PENGGUNA</p>
                    <p class="text-2xl font-bold text-slate-800">{{ statistics.total_users }}</p>
                    <p class="text-xs text-slate-400">Pegawai Aktif</p>
                </div>
            </div>
        </div>

        <!-- Kartu Menu -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <Link :href="route('documents.index')" class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
                <p class="font-semibold text-slate-800">Manajemen Dokumen</p>
                <p class="text-sm text-slate-500">Kelola arsip digital PT KAI</p>
            </Link>
            <Link :href="route('divisions.index')" class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
                <p class="font-semibold text-slate-800">Unit Kerja</p>
                <p class="text-sm text-slate-500">Divisi DAOP 6 Yogyakarta</p>
            </Link>
            <Link :href="route('categories.index')" class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
                <p class="font-semibold text-slate-800">Kategori Dokumen</p>
                <p class="text-sm text-slate-500">Standar klasifikasi KAI</p>
            </Link>
        </div>

        <!-- Daftar Dokumen -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Documents -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-slate-800 mb-4">Dokumen Terbaru</h3>

                <div v-if="recent_documents.length === 0" class="text-center py-8">
                    <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <p class="mt-2 text-sm text-gray-500">Belum ada dokumen</p>
                </div>

                <ul v-else>
                    <li v-for="document in recent_documents" :key="document.id" class="flex justify-between items-center py-3 border-b border-slate-100">
                        <div>
                            <p class="font-medium text-slate-700">{{ document.title }}</p>
                            <p class="text-sm text-slate-500">{{ document.division }} - {{ document.category }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <Link :href="route('documents.show', document.id)" class="text-slate-400 hover:text-blue-600">
                                <EyeIcon class="w-5 h-5" />
                            </Link>
                            <a :href="route('documents.download', document.id)" class="text-slate-400 hover:text-green-600">
                                <ArrowDownTrayIcon class="w-5 h-5" />
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Documents per Division -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-slate-800 mb-4">Dokumen per Unit Kerja</h3>

                <div v-if="documents_per_division.length === 0" class="text-center py-8">
                    <BuildingOfficeIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <p class="mt-2 text-sm text-gray-500">Belum ada data divisi</p>
                </div>

                <ul v-else>
                    <li v-for="division in documents_per_division" :key="division.id" class="py-2">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700">{{ division.name }}</span>
                            <span class="text-sm font-medium text-slate-500">{{ division.total_documents }}</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                                 :style="{ width: (division.total_documents / Math.max(...documents_per_division.map(d => d.total_documents)) * 100) + '%' }">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
                        