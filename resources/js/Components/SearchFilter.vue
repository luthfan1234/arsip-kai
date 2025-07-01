<template>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    Pencarian
                </label>
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                    <input
                        id="search"
                        v-model="localFilters.search"
                        type="text"
                        placeholder="Cari berdasarkan judul, nomor dokumen..."
                        class="pl-10 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        @input="handleSearchChange"
                    />
                </div>
            </div>

            <!-- Division Filter -->
            <div>
                <label for="division" class="block text-sm font-medium text-gray-700 mb-2">
                    Divisi
                </label>
                <select
                    id="division"
                    v-model="localFilters.division_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    @change="handleFilterChange"
                >
                    <option value="">Semua Divisi</option>
                    <option v-for="division in divisions" :key="division.id" :value="division.id">
                        {{ division.name }}
                    </option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>
                <select
                    id="category"
                    v-model="localFilters.category_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    @change="handleFilterChange"
                >
                    <option value="">Semua Kategori</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Clear Filters Button -->
        <div class="mt-4 flex justify-end" v-if="hasActiveFilters">
            <button
                @click="clearFilters"
                class="text-sm text-gray-600 hover:text-gray-800 flex items-center"
            >
                <XMarkIcon class="h-4 w-4 mr-1" />
                Hapus Filter
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

const props = defineProps({
    filters: Object,
    divisions: Array,
    categories: Array,
});

const localFilters = ref({
    search: props.filters.search || '',
    division_id: props.filters.division_id || '',
    category_id: props.filters.category_id || '',
});

const hasActiveFilters = computed(() => {
    return localFilters.value.search ||
           localFilters.value.division_id ||
           localFilters.value.category_id;
});

const debouncedSearch = debounce(() => {
    updateFilters();
}, 500);

const handleSearchChange = () => {
    debouncedSearch();
};

const handleFilterChange = () => {
    updateFilters();
};

const updateFilters = () => {
    const filters = {};

    if (localFilters.value.search) {
        filters.search = localFilters.value.search;
    }
    if (localFilters.value.division_id) {
        filters.division_id = localFilters.value.division_id;
    }
    if (localFilters.value.category_id) {
        filters.category_id = localFilters.value.category_id;
    }

    router.get(route('documents.index'), filters, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    localFilters.value = {
        search: '',
        division_id: '',
        category_id: '',
    };

    router.get(route('documents.index'), {}, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
