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
    BuildingOfficeIcon
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
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Divisi</h2>
                <PrimaryButton @click="showAddModal">
                    <PlusIcon class="h-4 w-4 mr-2" />
                    Tambah Divisi
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Divisi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Dokumen
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="division in divisions" :key="division.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <BuildingOfficeIcon class="h-5 w-5 text-gray-400 mr-3" />
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ division.name }}</div>
                                                    <div v-if="division.description" class="text-sm text-gray-500">
                                                        {{ division.description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ division.documents_count || 0 }} dokumen
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button
                                                    @click="showEditModal(division)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    title="Edit"
                                                >
                                                    <PencilIcon class="h-4 w-4" />
                                                </button>
                                                <button
                                                    @click="confirmDivisionDeletion(division)"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Hapus"
                                                >
                                                    <TrashIcon class="h-4 w-4" />
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

        <!-- Modal Tambah Divisi -->
        <Modal :show="confirmingDivisionAddition" @close="closeAddModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Tambah Divisi Baru
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Masukkan informasi divisi yang akan ditambahkan.
                </p>

                <div class="mt-6">
                    <InputLabel for="name" value="Nama Divisi" />
                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Masukkan nama divisi"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="description" value="Deskripsi (Opsional)" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi divisi"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeAddModal"> Batal </SecondaryButton>
                    <PrimaryButton
                        class="ml-3"
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
                <h2 class="text-lg font-medium text-gray-900">
                    Edit Divisi
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Ubah informasi divisi.
                </p>

                <div class="mt-6">
                    <InputLabel for="edit_name" value="Nama Divisi" />
                    <TextInput
                        id="edit_name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Masukkan nama divisi"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="edit_description" value="Deskripsi (Opsional)" />
                    <textarea
                        id="edit_description"
                        v-model="form.description"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        rows="3"
                        placeholder="Masukkan deskripsi divisi"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeEditModal"> Batal </SecondaryButton>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="updateDivision"
                    >
                        Update Divisi
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- Modal Konfirmasi Hapus -->
        <Modal :show="confirmingDivisionDeletion" @close="closeDeletionModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Hapus Divisi
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus divisi ini? Semua dokumen yang terkait dengan divisi ini juga akan terpengaruh.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeDeletionModal"> Batal </SecondaryButton>
                    <DangerButton
                        class="ml-3"
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
