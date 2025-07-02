<script setup>
import Navbar from '@/Components/Navbar.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="min-h-screen bg-gray-50/50">
        <!-- Navbar Component -->
        <Navbar />

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Heading -->
            <div v-if="$slots.header" class="py-8">
                <slot name="header" />
            </div>

            <!-- Main Content -->
            <div class="pb-12">
                <slot />
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                                <DocumentTextIcon class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">PT Kereta Api Indonesia</h3>
                                <p class="text-sm text-orange-600 font-medium">DAOP 6 Yogyakarta</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed max-w-md">
                            Sistem Manajemen Arsip Digital untuk mendukung operasional kereta api yang efisien, terorganisir, dan mudah diakses oleh seluruh unit kerja.
                        </p>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-100 mt-8 pt-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                        <p class="text-xs text-gray-500">
                            © {{ new Date().getFullYear() }} PT Kereta Api Indonesia (Persero). Hak Cipta Dilindungi.
                        </p>
                        <div class="flex space-x-4 text-xs text-gray-500">
                            <a href="#" class="hover:text-orange-600 transition-colors">Bantuan</a>
                            <a href="#" class="hover:text-orange-600 transition-colors">Kontak</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

