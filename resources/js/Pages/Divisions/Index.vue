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
    BuildingOfficeIcon,
    PlusCircleIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline';

defineProps({
    divisions: Array,
});

const confirmingDivisionDeletion = ref(false);
const confirmingDivisionAddition = ref(false);
const confirmingDivisionEdit = ref(false);
const nameInput = ref(null);
const editingDivision = ref(null);

const form = useForm({
    id: '',
    name: '',
    description: '',
});

const confirmDivisionDeletion = (division) => {
    editingDivision.value = division;
    confirmingDivisionDeletion.value = true;
};

const deleteDivision = () => {
    form.delete(route('divisions.destroy', editingDivision.value.id), {
        preserveScroll: true,
        onSuccess: () => closeDeletionModal(),
        onFinish: () => form.reset(),
    });
};

const closeDeletionModal = () => {
    confirmingDivisionDeletion.value = false;
    editingDivision.value = null;
    form.reset();
};

const showAddModal = () => {
    confirmingDivisionAddition.value = true;

    nextTick(() => nameInput.value?.focus());
};

const closeAddModal = () => {
    confirmingDivisionAddition.value = false;
    form.reset();
};

const addDivision = () => {
    form.post(route('divisions.store'), {
        preserveScroll: true,
        onSuccess: () => closeAddModal(),
    });
};

const showEditModal = (division) => {
    editingDivision.value = division;
    form.id = division.id;
    form.name = division.name;
    form.description = division.description || '';
    confirmingDivisionEdit.value = true;

    nextTick(() => nameInput.value?.focus());
};

const closeEditModal = () => {
    confirmingDivisionEdit.value = false;
    editingDivision.value = null;
    form.reset();
};

const updateDivision = () => {
    form.put(route('divisions.update', form.id), {
        preserveScroll: true,
        onSuccess: () => closeEditModal(),
    });
};
</script>

<template>
    <Head title="Manajemen Divisi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg mr-4">
                        <BuildingOfficeIcon class="h-7 w-7 text-white" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Manajemen Divisi</h2>
                        <p class="text-sm text-blue-600 mt-1">Kelola divisi dan unit kerja</p>
                    </div>
                </div>
                <PrimaryButton
                    @click="showAddModal"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                >
                    <PlusCircleIcon class="w-5 h-5 mr-2" />
                    Tambah Divisi
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <BuildingOfficeIcon class="h-5 w-5 text-blue-500 mr-2" />
                            Daftar Divisi
                        </h3>
                    </div>

                    <div class="p-6">
                        <div v-if="divisions.length === 0" class="text-center py-16">
                            <div class="bg-blue-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-4">
                                <BuildingOfficeIcon class="h-12 w-12 text-blue-400" />
                            </div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada divisi</h3>
                            <p class="mt-1 text-gray-500 max-w-md mx-auto">
                                Belum ada divisi yang ditambahkan. Silakan tambahkan divisi baru.
                            </p>
                            <div class="mt-6">
                                <button
                                    @click="showAddModal"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-600 hover:to-blue-700 shadow-md"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Tambah Divisi
                                </button>
                            </div>
                        </div>

                        <div v-else>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-blue-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                                Divisi
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                                Jumlah Dokumen
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-blue-600 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="division in divisions" :key="division.id" class="hover:bg-blue-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                        <BuildingOfficeIcon class="h-5 w-5 text-blue-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ division.name }}</div>
                                                        <div v-if="division.description" class="text-sm text-gray-500">
                                                            {{ division.description }}
                                                        </div>
                                                        <div class="text-xs text-gray-400 mt-1">
                                                            Kode: {{ division.code }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-6 w-6 rounded-md bg-orange-100 flex items-center justify-center mr-2">
                                                        <DocumentTextIcon class="h-3 w-3 text-orange-500" />
                                                    </div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ division.documents_count || 0 }} dokumen
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <button
                                                        @click="showEditModal(division)"
                                                        class="bg-yellow-50 p-2 rounded-lg text-yellow-600 hover:bg-yellow-100 transition-colors duration-150"
                                                        title="Edit"
                                                    >
                                                        <PencilIcon class="h-5 w-5" />
                                                    </button>
                                                    <button
                                                        @click="confirmDivisionDeletion(division)"
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

        <!-- Modal Tambah Divisi -->
        <Modal :show="confirmingDivisionAddition" @close="closeAddModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <PlusIcon class="h-6 w-6 text-blue-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Tambah Divisi Baru
                    </h2>
                </div>

                <p class="mb-6 text-gray-600">
                    Masukkan informasi untuk divisi atau unit kerja baru.
                </p>

                <div class="bg-gray-50 p-6 rounded-xl mb-4">
                    <InputLabel for="name" value="Nama Divisi" class="text-gray-700 font-semibold mb-2" />
                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan nama divisi"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="bg-gray-50 p-6 rounded-xl">
                    <InputLabel for="description" value="Deskripsi (Opsional)" class="text-gray-700 font-semibold mb-2" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi divisi"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeAddModal"> Batal </SecondaryButton>
                    <PrimaryButton
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="addDivision"
                    >
                        Tambah Divisi
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Modal Edit Divisi -->
        <Modal :show="confirmingDivisionEdit" @close="closeEditModal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                        <PencilIcon class="h-6 w-6 text-yellow-600" />
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Edit Divisi
                    </h2>
                </div>

                <p class="mb-6 text-gray-600">
                    Perbarui informasi untuk divisi atau unit kerja.
                </p>

                <div class="bg-gray-50 p-6 rounded-xl mb-4">
                    <InputLabel for="edit_name" value="Nama Divisi" class="text-gray-700 font-semibold mb-2" />
                    <TextInput
                        id="edit_name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan nama divisi"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="bg-gray-50 p-6 rounded-xl">
                    <InputLabel for="edit_description" value="Deskripsi (Opsional)" class="text-gray-700 font-semibold mb-2" />
                    <textarea
                        id="edit_description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi divisi"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeEditModal">Batal</SecondaryButton>
                    <PrimaryButton
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="updateDivision"
                    >
                        Perbarui Divisi
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Delete Division Modal -->
        <Modal :show="confirmingDivisionDeletion" @close="closeDeletionModal">
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
                    Apakah Anda yakin ingin menghapus divisi <span class="font-semibold text-gray-900">"{{ editingDivision?.name }}"</span>?
                </p>

                <p class="mb-6 text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                    Divisi akan dihapus secara permanen dan semua dokumen terkait mungkin akan terpengaruh.
                </p>

                <div class="flex justify-end gap-3">
                    <SecondaryButton @click="closeDeletionModal">
                        Batal
                    </SecondaryButton>
                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteDivision"
                    >
                        Hapus Divisi
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
