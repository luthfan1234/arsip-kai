<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    DocumentTextIcon,
    BuildingOfficeIcon,
    TagIcon,
    UsersIcon,
    ArrowTrendingUpIcon,
    DocumentIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total_documents: 0,
            total_divisions: 0,
            total_categories: 0,
            total_users: 0,
        })
    },
    recent_documents: {
        type: Array,
        default: () => []
    },
    documents_by_division: {
        type: Array,
        default: () => []
    },
    documents_by_category: {
        type: Array,
        default: () => []
    },
});

// Get page props using Inertia's usePage composable
const page = usePage();

// Check if user is admin
const isAdmin = () => {
    return page.props.auth?.user?.roles?.some(role => role.name === 'admin') || false;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <DocumentTextIcon class="h-6 w-6 text-blue-600" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Dokumen</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_documents || 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <BuildingOfficeIcon class="h-6 w-6 text-green-600" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Divisi</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_divisions || 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                                <TagIcon class="h-6 w-6 text-yellow-600" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_categories || 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 mr-4">
                                <UsersIcon class="h-6 w-6 text-purple-600" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total User</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_users || 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Documents -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Dokumen Terbaru</h3>
                                <Link :href="route('documents.index')"
                                      class="text-sm text-blue-600 hover:text-blue-500">
                                    Lihat Semua
                                </Link>
                            </div>

                            <div v-if="recent_documents && recent_documents.length > 0" class="space-y-3">
                                <div v-for="document in recent_documents" :key="document.id"
                                     class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                                    <DocumentIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ document.title }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ document.division?.name || 'No Division' }} • {{ document.category?.name || 'No Category' }}
                                        </p>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ new Date(document.upload_date || document.created_at).toLocaleDateString('id-ID') }}
                                    </div>
                                </div>
                            </div>

                            <div v-else class="text-center py-8">
                                <DocumentIcon class="h-12 w-12 text-gray-300 mx-auto mb-4" />
                                <p class="text-gray-500 text-sm">Belum ada dokumen</p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents by Division Chart -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen per Divisi</h3>

                            <div v-if="documents_by_division && documents_by_division.length > 0" class="space-y-3">
                                <div v-for="item in documents_by_division" :key="item.name"
                                     class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ item.name }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full"
                                                 :style="{ width: stats.total_documents > 0 ? (item.total / stats.total_documents * 100) + '%' : '0%' }"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 w-8">{{ item.total }}</span>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="text-center py-8">
                                <BuildingOfficeIcon class="h-12 w-12 text-gray-300 mx-auto mb-4" />
                                <p class="text-gray-500 text-sm">Belum ada data divisi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <Link v-if="isAdmin()"
                                  :href="route('documents.create')"
                                  class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <DocumentTextIcon class="h-6 w-6 text-blue-600 mr-3" />
                                <span class="text-sm font-medium text-gray-900">Upload Dokumen</span>
                            </Link>

                            <Link :href="route('documents.index')"
                                  class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <DocumentIcon class="h-6 w-6 text-green-600 mr-3" />
                                <span class="text-sm font-medium text-gray-900">Lihat Dokumen</span>
                            </Link>

                            <Link v-if="isAdmin()"
                                  :href="route('divisions.index')"
                                  class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <BuildingOfficeIcon class="h-6 w-6 text-yellow-600 mr-3" />
                                <span class="text-sm font-medium text-gray-900">Kelola Divisi</span>
                            </Link>

                            <Link v-if="isAdmin()"
                                  :href="route('categories.index')"
                                  class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                <TagIcon class="h-6 w-6 text-purple-600 mr-3" />
                                <span class="text-sm font-medium text-gray-900">Kelola Kategori</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
