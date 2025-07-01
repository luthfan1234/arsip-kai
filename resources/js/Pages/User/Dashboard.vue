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
    StarIcon
} from '@heroicons/vue/24/outline';

defineProps({
    statistics: Object,
    recent_documents: Array,
    documents_per_division: Array,
    documents_per_category: Array,
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
            <div class="flex items-center">
                <div class="bg-blue-600 p-2 rounded-lg mr-3">
                    <BookOpenIcon class="h-6 w-6 text-white" />
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">🚆 Portal Dokumen PT KAI</h2>
                    <p class="text-sm text-gray-600">Sistem Arsip Digital DAOP 6 Yogyakarta</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Welcome Hero Section -->
                <div class="bg-blue-700 overflow-hidden shadow-xl sm:rounded-lg mb-8">
                    <div class="p-8 text-white relative">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute transform rotate-45 -top-8 -right-8">
                                <DocumentTextIcon class="h-32 w-32" />
                            </div>
                            <div class="absolute transform -rotate-12 top-1/2 left-1/4">
                                <FolderIcon class="h-24 w-24" />
                            </div>
                            <!-- Train Icon Pattern -->
                            <div class="absolute text-6xl opacity-5 top-4 right-16">🚆</div>
                            <div class="absolute text-4xl opacity-5 bottom-8 left-8">🏢</div>
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h1 class="text-4xl font-bold mb-2">🚆 Sistem Arsip Digital PT KAI</h1>
                                    <h2 class="text-2xl font-semibold mb-2">Daerah Operasi 6 Yogyakarta</h2>
                                    <p class="text-blue-100 text-lg mb-4">Akses dokumen operasional untuk pelayanan kereta api yang optimal</p>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="bg-white/20 px-3 py-1 rounded-full">🔍 Pencarian Mudah</span>
                                        <span class="bg-white/20 px-3 py-1 rounded-full">📁 Kategori Terstruktur</span>
                                        <span class="bg-white/20 px-3 py-1 rounded-full">⬇️ Download Cepat</span>
                                    </div>
                                </div>
                                <div class="hidden md:block ml-8">
                                    <!-- Logo/Branding Slot DAOP 6 -->
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 text-center">
                                        <!-- Placeholder untuk logo KAI DAOP 6 -->
                                        <div class="w-32 h-32 mx-auto mb-4 bg-white/30 rounded-xl flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-6xl mb-2">🚆</div>
                                                <div class="text-sm font-bold text-white">LOGO</div>
                                                <div class="text-xs text-blue-200">KAI DAOP 6</div>
                                            </div>
                                        </div>
                                        <h3 class="text-lg font-bold mb-1">PT KAI DAOP 6</h3>
                                        <p class="text-sm text-blue-200">Yogyakarta</p>
                                        <div class="mt-3 text-xs bg-orange-500/20 px-2 py-1 rounded-full">
                                            Digital Archive System
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats for Users -->
                            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-orange-300">
                                    <div class="flex items-center">
                                        <div class="bg-orange-500 p-3 rounded-full mr-4">
                                            <DocumentTextIcon class="h-8 w-8 text-white" />
                                        </div>
                                        <div>
                                            <p class="text-blue-100 text-sm">📄 Total Dokumen</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_documents }}</p>
                                            <p class="text-xs text-blue-200">Dokumen tersimpan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-blue-300">
                                    <div class="flex items-center">
                                        <div class="bg-blue-500 p-3 rounded-full mr-4">
                                            <FolderIcon class="h-8 w-8 text-white" />
                                        </div>
                                        <div>
                                            <p class="text-orange-100 text-sm">🏢 Unit Kerja</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_divisions }}</p>
                                            <p class="text-xs text-orange-200">Divisi aktif</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 hover:bg-white/30 transition-all duration-200 border-l-4 border-white">
                                    <div class="flex items-center">
                                        <div class="bg-white p-3 rounded-full mr-4">
                                            <TagIcon class="h-8 w-8 text-blue-700" />
                                        </div>
                                        <div>
                                            <p class="text-blue-100 text-sm">🏷️ Kategori</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_categories }}</p>
                                            <p class="text-xs text-blue-200">Jenis dokumen</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Branding Section -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Company Branding Cards -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-600">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <div class="text-2xl">🚆</div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900">PT KAI</h3>
                            <p class="text-xs text-blue-600">Kereta Api Indonesia</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-orange-500">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center">
                                <div class="text-2xl">🏢</div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900">DAOP 6</h3>
                            <p class="text-xs text-orange-600">Daerah Operasi 6</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-500">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <div class="text-2xl">🏛️</div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900">Yogyakarta</h3>
                            <p class="text-xs text-blue-600">Daerah Istimewa</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-orange-600">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center">
                                <div class="text-2xl">📋</div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900">Arsip Digital</h3>
                            <p class="text-xs text-orange-600">Sistem Terintegrasi</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Search Documents -->
                    <Link :href="route('documents.index')" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border-l-4 border-orange-500 hover:shadow-xl transition-all duration-200">
                        <div class="p-8">
                            <div class="flex items-center mb-4">
                                <div class="bg-orange-100 p-4 rounded-full group-hover:bg-orange-200 transition-colors duration-200">
                                    <MagnifyingGlassIcon class="h-8 w-8 text-orange-600" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-semibold text-gray-900">🔍 Pencarian Dokumen</h3>
                                    <p class="text-gray-600">Temukan dokumen operasional dengan cepat</p>
                                </div>
                            </div>
                            <p class="text-sm text-orange-600 group-hover:text-orange-800">
                                ⚡ Akses dokumen KAI DAOP 6 →
                            </p>
                        </div>
                    </Link>

                    <!-- Recent Activity -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-l-4 border-blue-600">
                        <div class="p-8">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-4 rounded-full">
                                    <ClockIcon class="h-8 w-8 text-blue-600" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-semibold text-gray-900">🕒 Aktivitas Terbaru</h3>
                                    <p class="text-gray-600">Update dokumen operasional terkini</p>
                                </div>
                            </div>
                            <p class="text-sm text-blue-600">
                                📊 {{ recent_documents.length }} dokumen baru tersedia
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Recent Documents - Larger for users -->
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-orange-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <StarIcon class="h-5 w-5 text-orange-500 mr-2" />
                                    <h3 class="text-xl font-semibold text-gray-900">🚆 Dokumen Terbaru KAI DAOP 6</h3>
                                </div>
                                <Link
                                    :href="route('documents.index')"
                                    class="text-sm text-blue-600 hover:text-orange-600 font-medium bg-blue-50 hover:bg-orange-50 px-3 py-1 rounded-full transition-colors duration-200"
                                >
                                    Lihat Semua →
                                </Link>
                            </div>

                            <div v-if="recent_documents.length === 0" class="text-center py-16">
                                <div class="text-6xl mb-4">🚆</div>
                                <DocumentTextIcon class="mx-auto h-16 w-16 text-gray-400" />
                                <h3 class="mt-4 text-lg font-medium text-gray-900">📄 Belum ada dokumen</h3>
                                <p class="mt-2 text-gray-500">Dokumen operasional akan muncul di sini</p>
                            </div>

                            <div v-else class="space-y-4">
                                <div
                                    v-for="document in recent_documents.slice(0, 6)"
                                    :key="document.id"
                                    class="flex items-center justify-between p-6 border border-gray-200 rounded-xl hover:shadow-md hover:border-orange-300 transition-all duration-200 group"
                                >
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center mb-3">
                                            <div class="bg-blue-100 p-2 rounded-lg mr-3 group-hover:bg-orange-100 transition-colors duration-200">
                                                <DocumentTextIcon class="h-5 w-5 text-blue-600 group-hover:text-orange-600" />
                                            </div>
                                            <Link
                                                :href="route('documents.show', document.id)"
                                                class="text-base font-semibold text-gray-900 hover:text-orange-600 truncate group-hover:text-blue-700"
                                            >
                                                {{ document.title }}
                                            </Link>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-500 space-x-4 mb-2">
                                            <span class="inline-flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                🏢 {{ document.division }}
                                            </span>
                                            <span class="inline-flex items-center bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                                                🏷️ {{ document.category }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            📅 {{ formatDate(document.created_at) }} • 💾 {{ document.file_size }} • 👤 {{ document.uploader }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 ml-4">
                                        <Link
                                            :href="route('documents.show', document.id)"
                                            class="p-3 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-all duration-200"
                                            title="👁️ Lihat Detail"
                                        >
                                            <EyeIcon class="h-5 w-5" />
                                        </Link>
                                        <a
                                            :href="route('documents.download', document.id)"
                                            class="p-3 text-orange-600 hover:text-orange-800 hover:bg-orange-50 rounded-full transition-all duration-200"
                                            title="⬇️ Download"
                                        >
                                            <ArrowDownTrayIcon class="h-5 w-5" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="space-y-6">
                        <!-- Documents by Division -->
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-blue-600">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <FolderIcon class="h-5 w-5 text-blue-600 mr-2" />
                                    <h3 class="text-lg font-semibold text-gray-900">🏢 Dokumen per Unit Kerja</h3>
                                </div>

                                <div v-if="documents_per_division.length === 0" class="text-center py-8">
                                    <div class="text-4xl mb-2">🚆</div>
                                    <FolderIcon class="mx-auto h-12 w-12 text-gray-400" />
                                    <p class="mt-2 text-sm text-gray-500">🏢 Belum ada data unit kerja</p>
                                </div>

                                <div v-else class="space-y-4">
                                    <div
                                        v-for="division in documents_per_division.slice(0, 5)"
                                        :key="division.id"
                                        class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                    >
                                        <div class="flex items-center flex-1">
                                            <div
                                                class="w-4 h-4 rounded-full mr-3 border-2 border-white shadow-sm"
                                                :style="{ backgroundColor: division.color }"
                                            ></div>
                                            <span class="text-sm text-gray-700 truncate font-medium">{{ division.name }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-white bg-blue-500 px-3 py-1 rounded-full">{{ division.total_documents }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents by Category -->
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-orange-500">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <TagIcon class="h-5 w-5 text-orange-600 mr-2" />
                                    <h3 class="text-lg font-semibold text-gray-900">🏷️ Dokumen per Kategori</h3>
                                </div>

                                <div v-if="documents_per_category.length === 0" class="text-center py-8">
                                    <div class="text-4xl mb-2">📋</div>
                                    <TagIcon class="mx-auto h-12 w-12 text-gray-400" />
                                    <p class="mt-2 text-sm text-gray-500">🏷️ Belum ada data kategori</p>
                                </div>

                                <div v-else class="space-y-4">
                                    <div
                                        v-for="category in documents_per_category.slice(0, 5)"
                                        :key="category.id"
                                        class="flex items-center justify-between p-3 rounded-lg hover:bg-orange-50 transition-colors duration-200"
                                    >
                                        <div class="flex items-center flex-1">
                                            <div
                                                class="w-4 h-4 rounded-full mr-3 border-2 border-white shadow-sm"
                                                :style="{ backgroundColor: category.color }"
                                            ></div>
                                            <span class="text-sm text-gray-700 truncate font-medium">{{ category.name }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-white bg-orange-500 px-3 py-1 rounded-full">{{ category.total_documents }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PT KAI Info Card -->
                        <div class="bg-blue-50 overflow-hidden shadow-lg sm:rounded-xl border-2 border-blue-200">
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-600 p-2 rounded-full mr-3">
                                        <BookOpenIcon class="h-5 w-5 text-white" />
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">🚆 Tentang Sistem</h3>
                                </div>
                                <div class="text-center mb-4">
                                    <div class="text-4xl mb-2">🚆</div>
                                    <h4 class="font-bold text-blue-700">PT Kereta Api Indonesia</h4>
                                    <p class="text-sm text-orange-600 font-medium">Daerah Operasi 6 Yogyakarta</p>
                                </div>
                                <p class="text-sm text-gray-700 mb-4 text-center">
                                    Sistem Manajemen Arsip Digital untuk mendukung operasional kereta api yang efisien dan terpadu.
                                </p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        <span class="text-blue-700">🔍 Pencarian dokumen operasional</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                        <span class="text-orange-700">🏷️ Kategorisasi berdasarkan unit kerja</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        <span class="text-blue-700">⬇️ Download dokumen standar KAI</span>
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

