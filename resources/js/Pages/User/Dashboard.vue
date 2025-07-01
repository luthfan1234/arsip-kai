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
    ArchiveBoxIcon
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
    <Head title="Portal Dokumen PT KAI" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg">
                    <BookOpenIcon class="h-7 w-7 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Portal Dokumen</h1>
                    <p class="text-sm text-orange-600 mt-1">Sistem Arsip Digital DAOP 6 Yogyakarta</p>
                </div>
            </div>
        </template>

        <div class="space-y-8">
            <!-- Welcome Hero Section -->
            <div class="bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 text-white relative">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <DocumentTextIcon class="absolute transform rotate-12 top-4 right-8 h-32 w-32" />
                        <FolderIcon class="absolute transform -rotate-12 bottom-4 left-8 h-24 w-24" />
                        <ArchiveBoxIcon class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-40 w-40 opacity-5" />
                    </div>

                    <div class="relative z-10">
                        <div class="max-w-4xl">
                            <h2 class="text-4xl font-bold mb-3">Selamat Datang di Arsip Digital</h2>
                            <p class="text-orange-100 text-xl mb-3">PT Kereta Api Indonesia DAOP 6 Yogyakarta</p>
                            <p class="text-orange-100 mb-8 text-lg">Akses dokumen operasional dengan mudah dan cepat melalui sistem yang terintegrasi.</p>

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                                    <div class="flex items-center">
                                        <DocumentTextIcon class="w-12 h-12 text-white mr-4" />
                                        <div>
                                            <p class="text-orange-100 text-sm font-medium">Total Dokumen</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_documents }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                                    <div class="flex items-center">
                                        <BuildingLibraryIcon class="w-12 h-12 text-white mr-4" />
                                        <div>
                                            <p class="text-orange-100 text-sm font-medium">Unit Kerja</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_divisions }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                                    <div class="flex items-center">
                                        <TagIcon class="w-12 h-12 text-white mr-4" />
                                        <div>
                                            <p class="text-orange-100 text-sm font-medium">Kategori</p>
                                            <p class="text-3xl font-bold">{{ statistics.total_categories }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <Link :href="route('documents.index')" class="group bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl hover:border-orange-300 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <MagnifyingGlassIcon class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-orange-700">Cari Dokumen</h3>
                            <p class="text-orange-600 mt-2 font-medium">Temukan dokumen dengan cepat</p>
                        </div>
                    </div>
                </Link>

                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <ClockIcon class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">Aktivitas Terbaru</h3>
                            <p class="text-blue-600 mt-2 font-medium">{{ recent_documents.length }} dokumen tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Recent Documents -->
                <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-200 shadow-lg">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <StarIcon class="h-6 w-6 text-orange-500 mr-3" />
                                <h3 class="text-xl font-bold text-gray-900">Dokumen Terbaru KAI DAOP 6</h3>
                            </div>
                            <Link :href="route('documents.index')" class="text-sm font-semibold text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-lg transition-all duration-200">
                                Lihat Semua →
                            </Link>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="recent_documents.length === 0" class="text-center py-20">
                            <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <DocumentTextIcon class="w-12 h-12 text-orange-400" />
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Belum ada dokumen</h3>
                            <p class="text-gray-500 mt-2">Dokumen operasional akan muncul di sini</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="document in recent_documents.slice(0, 6)" :key="document.id"
                                 class="flex items-center justify-between p-6 rounded-2xl hover:bg-orange-50 transition-all duration-300 border border-transparent hover:border-orange-200 group hover:shadow-lg">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors">
                                            <DocumentTextIcon class="w-5 h-5 text-orange-600" />
                                        </div>
                                        <Link :href="route('documents.show', document.id)"
                                              class="text-base font-bold text-gray-900 hover:text-orange-600 truncate group-hover:text-orange-700">
                                            {{ document.title }}
                                        </Link>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                            {{ document.division }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            {{ document.category }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 font-medium">
                                        {{ formatDate(document.created_at) }} • {{ document.file_size }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3 ml-6">
                                    <Link :href="route('documents.show', document.id)"
                                          class="p-3 text-gray-400 hover:text-orange-600 hover:bg-orange-100 rounded-xl transition-all duration-200">
                                        <EyeIcon class="w-5 h-5" />
                                    </Link>
                                    <a :href="route('documents.download', document.id)"
                                       class="p-3 text-gray-400 hover:text-green-600 hover:bg-green-100 rounded-xl transition-all duration-200">
                                        <ArrowDownTrayIcon class="w-5 h-5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Categories -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h4 class="text-sm font-bold text-gray-900">Kategori Dokumen</h4>
                        </div>
                        <div class="p-4">
                            <div v-if="documents_per_category.length === 0" class="text-center py-8">
                                <TagIcon class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                                <p class="text-xs text-gray-500">Belum ada kategori</p>
                            </div>
                            <div v-else class="space-y-3">
                                <div v-for="category in documents_per_category.slice(0, 5)" :key="category.id"
                                     class="flex items-center justify-between p-3 rounded-xl hover:bg-orange-50 transition-colors">
                                    <span class="text-xs font-semibold text-gray-700 truncate">{{ category.name }}</span>
                                    <span class="text-xs font-bold bg-orange-100 text-orange-900 px-3 py-1 rounded-full">
                                        {{ category.total_documents }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl border border-orange-200 shadow-lg">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <DocumentTextIcon class="w-8 h-8 text-white" />
                            </div>
                            <h4 class="text-sm font-bold text-gray-900 mb-2">Sistem Arsip Digital</h4>
                            <p class="text-xs text-orange-600 mb-4 font-semibold">PT KAI DAOP 6 Yogyakarta</p>
                            <div class="space-y-2 text-xs text-gray-600">
                                <div class="flex items-center justify-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    <span className="font-medium">Sistem Aktif</span>
                                </div>
                                <div class="flex items-center justify-center">
                                    <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                    <span className="font-medium">Version 1.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
                    
