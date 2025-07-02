<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    TagIcon,
    PlusCircleIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline';

defineProps({
    categories: Array,
});

const confirmingCategoryDeletion = ref(false);
const confirmingCategoryAddition = ref(false);
const confirmingCategoryEdit = ref(false);
const nameInput = ref(null);
const editingCategory = ref(null);

const form = useForm({
    id: '',
    name: '',
    description: '',
});

const confirmCategoryDeletion = (category) => {
    editingCategory.value = category;
    confirmingCategoryDeletion.value = true;
};

const deleteCategory = () => {
    form.delete(route('categories.destroy', editingCategory.value.id), {
        preserveScroll: true,
        onSuccess: () => closeDeletionModal(),
        onFinish: () => form.reset(),
    });
};

const closeDeletionModal = () => {
    confirmingCategoryDeletion.value = false;
    editingCategory.value = null;
    form.reset();
};

const showAddModal = () => {
    confirmingCategoryAddition.value = true;

    nextTick(() => nameInput.value?.focus());
};

const closeAddModal = () => {
    confirmingCategoryAddition.value = false;
    form.reset();
};

const addCategory = () => {
    form.post(route('categories.store'), {
        preserveScroll: true,
        onSuccess: () => closeAddModal(),
    });
};

const showEditModal = (category) => {
    editingCategory.value = category;
    form.id = category.id;
    form.name = category.name;
    form.description = category.description || '';
    confirmingCategoryEdit.value = true;

    nextTick(() => nameInput.value?.focus());
};

const closeEditModal = () => {
    confirmingCategoryEdit.value = false;
    editingCategory.value = null;
    form.reset();
};

const updateCategory = () => {
    form.put(route('categories.update', form.id), {
        preserveScroll: true,
        onSuccess: () => closeEditModal(),
    });
};
</script>

<template>
    <Head title="Manajemen Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-lg mr-4">
                        <TagIcon class="h-7 w-7 text-white" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Manajemen Kategori</h2>
                        <p class="text-sm text-green-600 mt-1">Kelola kategori dokumen</p>
                    </div>
                </div>
                <PrimaryButton
                    @click="showAddModal"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                >
                    <PlusCircleIcon class="w-5 h-5 mr-2" />
                    Tambah Kategori
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <TagIcon class="h-5 w-5 text-green-500 mr-2" />
                            Daftar Kategori
                        </h3>
                    </div>

                    <div class="p-6">
                        <div v-if="categories.length === 0" class="text-center py-16">
                            <div class="bg-green-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-4">
                                <TagIcon class="h-12 w-12 text-green-400" />
                            </div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada kategori</h3>
                            <p class="mt-1 text-gray-500 max-w-md mx-auto">
                                Belum ada kategori yang ditambahkan. Silakan tambahkan kategori baru.
                            </p>
                            <div class="mt-6">
                                <button
                                    @click="showAddModal"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-green-600 hover:to-green-700 shadow-md"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Tambah Kategori
                                </button>
                            </div>
                        </div>

                        <div v-else>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-green-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">
                                                Jumlah Dokumen
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-green-600 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="category in categories" :key="category.id" class="hover:bg-green-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                                        <TagIcon class="h-5 w-5 text-green-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ category.name }}</div>
                                                        <div v-if="category.description" class="text-sm text-gray-500">
                                                            {{ category.description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-6 w-6 rounded-md bg-blue-100 flex items-center justify-center mr-2">
                                                        <DocumentTextIcon class="h-3 w-3 text-blue-500" />
                                                    </div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ category.documents_count || 0 }} dokumen
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <button
                                                        @click="showEditModal(category)"
                                                        class="bg-yellow-50 p-2 rounded-lg text-yellow-600 hover:bg-yellow-100 transition-colors duration-150"
                                                        title="Edit"
                                                    >
                                                        <PencilIcon class="h-5 w-5" />
                                                    </button>
                                                    <button
                                                        @click="confirmCategoryDeletion(category)"
                                                        class="bg-red-50 p-2 rounded-lg text-red-600 hover:bg-red-100 transition-colors duration-150"
                                                        title="Hapus"
                                                    >
                                                        <TrashIcon class="h-5 w-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Kategori -->
        <Modal :show="confirmingCategoryAddition" @close="closeAddModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <PlusIcon class="h-6 w-6 text-green-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Tambah Kategori Baru
                    </h2>
                </div>

                <p class="mb-6 text-gray-600">
                    Masukkan informasi untuk kategori dokumen baru.
                </p>

                <div class="bg-gray-50 p-6 rounded-xl mb-4">
                    <InputLabel for="name" value="Nama Kategori" class="text-gray-700 font-semibold mb-2" />
                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="Masukkan nama kategori"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="bg-gray-50 p-6 rounded-xl">
                    <InputLabel for="description" value="Deskripsi (Opsional)" class="text-gray-700 font-semibold mb-2" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi kategori"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeAddModal"> Batal </SecondaryButton>
                    <PrimaryButton
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="addCategory"
                    >
                        Tambah Kategori
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Modal Edit Kategori -->
        <Modal :show="confirmingCategoryEdit" @close="closeEditModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                        <PencilIcon class="h-6 w-6 text-yellow-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Edit Kategori
                    </h2>
                </div>

                <p class="mb-6 text-gray-600">
                    Perbarui informasi untuk kategori dokumen.
                </p>

                <div class="bg-gray-50 p-6 rounded-xl mb-4">
                    <InputLabel for="edit_name" value="Nama Kategori" class="text-gray-700 font-semibold mb-2" />
                    <TextInput
                        id="edit_name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="Masukkan nama kategori"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="bg-gray-50 p-6 rounded-xl">
                    <InputLabel for="edit_description" value="Deskripsi (Opsional)" class="text-gray-700 font-semibold mb-2" />
                    <textarea
                        id="edit_description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi kategori"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeEditModal">Batal</SecondaryButton>
                    <PrimaryButton
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="updateCategory"
                    >
                        Perbarui Kategori
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Delete Category Modal -->
        <Modal :show="confirmingCategoryDeletion" @close="closeDeletionModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <TrashIcon class="h-6 w-6 text-red-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Konfirmasi Penghapusan
                    </h2>
                </div>

                <p class="mb-4 text-gray-600">
                    Apakah Anda yakin ingin menghapus kategori <span class="font-semibold text-gray-900">"{{ editingCategory?.name }}"</span>?
                </p>

                <p class="mb-6 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                    Kategori akan dihapus secara permanen dan tidak dapat dikembalikan.
                </p>

                <div class="flex justify-end gap-3">
                    <SecondaryButton @click="closeDeletionModal">
                        Batal
                    </SecondaryButton>
                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteCategory"
                    >
                        Hapus Kategori
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
