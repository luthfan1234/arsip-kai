<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    ArrowLeftIcon,
    ArrowDownTrayIcon,
    PencilIcon,
    TrashIcon,
    DocumentTextIcon,
    CalendarIcon,
    UserIcon,
    BuildingOfficeIcon,
    TagIcon,
    DocumentIcon
} from '@heroicons/vue/24/outline';

defineProps({
    document: Object,
});

const formatFileSize = (bytes) => {
    const sizes = ['B', 'KB', 'MB', 'GB'];
    if (bytes === 0) return '0 B';
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
};

const deleteDocument = () => {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        router.delete(route('documents.destroy', document.id));
    }
};
</script>

<template>
    <Head :title="document.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mr-4">
                    <DocumentTextIcon class="h-7 w-7 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Dokumen</h2>
                    <p class="text-sm text-orange-600 mt-1">{{ document.title }}</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <!-- Back Button -->
                <div class="mb-6">
                    <Link :href="route('documents.index')"
                          class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition-all duration-200">
                        <ArrowLeftIcon class="h-4 w-4 mr-2" />
                        Kembali ke Daftar Dokumen
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <!-- Document Header -->
                    <div class="p-6 sm:p-8 bg-gradient-to-br from-orange-50 to-white border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="h-12 w-12 rounded-xl bg-orange-100 flex items-center justify-center mr-4">
                                        <DocumentTextIcon class="h-7 w-7 text-orange-500" />
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ document.title }}</h1>
                                        <p class="text-sm text-gray-500 mt-1">{{ document.document_number }}</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                        Versi {{ document.version }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <a :href="route('documents.download', document.id)"
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-green-600 hover:to-green-700 shadow-md transition-all duration-200 w-full sm:w-auto justify-center">
                                    <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                    Download
                                </a>

                                <Link v-if="$page.props.auth.user.role === 'admin'"
                                      :href="route('documents.edit', document.id)"
                                      class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-orange-600 hover:to-orange-700 shadow-md transition-all duration-200 w-full sm:w-auto justify-center">
                                    <PencilIcon class="h-4 w-4 mr-2" />
                                    Edit
                                </Link>

                                <button v-if="$page.props.auth.user.role === 'admin'"
                                        @click="deleteDocument"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-red-600 hover:to-red-700 shadow-md transition-all duration-200 w-full sm:w-auto justify-center">
                                    <TrashIcon class="h-4 w-4 mr-2" />
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                                            <BuildingOfficeIcon class="h-5 w-5 text-blue-500" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Divisi</p>
                                            <p class="text-base font-semibold text-gray-900">{{ document.division.name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                            <TagIcon class="h-5 w-5 text-green-500" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Kategori</p>
                                            <p class="text-base font-semibold text-gray-900">{{ document.category.name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                                            <UserIcon class="h-5 w-5 text-purple-500" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Diupload oleh</p>
                                            <p class="text-base font-semibold text-gray-900">{{ document.uploader.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center mr-4">
                                            <CalendarIcon class="h-5 w-5 text-orange-500" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Tanggal Upload</p>
                                            <p class="text-base font-semibold text-gray-900">{{ formatDate(document.upload_date) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center mr-4">
                                            <DocumentIcon class="h-5 w-5 text-orange-500" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">File</p>
                                            <p class="text-base font-semibold text-gray-900">{{ document.file_name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ formatFileSize(document.file_size) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div v-if="document.description" class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ document.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
