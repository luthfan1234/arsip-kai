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
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <Link :href="route('documents.index')"
                          class="mr-4 text-gray-500 hover:text-gray-700">
                        <ArrowLeftIcon class="h-5 w-5" />
                    </Link>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Dokumen</h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Document Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <DocumentTextIcon class="h-8 w-8 text-gray-400 mr-3" />
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ document.title }}</h1>
                                        <p class="text-sm text-gray-500">{{ document.document_number }}</p>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Versi {{ document.version }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <a :href="route('documents.download', document.id)"
                                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                    Download
                                </a>

                                <Link v-if="$page.props.auth.user.role === 'admin'"
                                      :href="route('documents.edit', document.id)"
                                      class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                    <PencilIcon class="h-4 w-4 mr-2" />
                                    Edit
                                </Link>

                                <button v-if="$page.props.auth.user.role === 'admin'"
                                        @click="deleteDocument"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    <TrashIcon class="h-4 w-4 mr-2" />
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <BuildingOfficeIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Divisi</p>
                                        <p class="text-sm text-gray-900">{{ document.division.name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <TagIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Kategori</p>
                                        <p class="text-sm text-gray-900">{{ document.category.name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <UserIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Diupload oleh</p>
                                        <p class="text-sm text-gray-900">{{ document.uploader.name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <CalendarIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tanggal Upload</p>
                                        <p class="text-sm text-gray-900">{{ formatDate(document.upload_date) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <DocumentIcon class="h-5 w-5 text-gray-400 mr-3" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">File</p>
                                        <p class="text-sm text-gray-900">{{ document.file_name }}</p>
                                        <p class="text-xs text-gray-500">{{ formatFileSize(document.file_size) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div v-if="document.description" class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ document.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
