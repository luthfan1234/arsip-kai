<script setup>
import Navbar from '@/Components/Navbar.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="min-h-screen bg-slate-100">
        <!-- Navbar Component -->
        <Navbar />

        <!-- Konten Utama -->
        <main class="container mx-auto p-6">
            <!-- Page Heading -->
            <div v-if="$slots.header" class="mb-6">
                <slot name="header" />
            </div>

            <!-- Page Content -->
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-16">
            <div class="container mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">PT Kereta Api Indonesia</h3>
                                <p class="text-orange-300 text-sm">DAOP 6 Yogyakarta</p>
                            </div>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Melayani perjalanan kereta api di wilayah Daerah Istimewa Yogyakarta dan sekitarnya dengan komitmen pada keselamatan, kenyamanan, dan ketepatan waktu.
                        </p>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-orange-300">Kontak & Layanan</h3>
                        <div class="space-y-3 text-sm text-gray-300">
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>Call Center: 121</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>cs@kai.id</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                                </svg>
                                <span>www.kai.id</span>
                            </div>
                        </div>
                    </div>

                    <!-- System Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-orange-300">Sistem Informasi</h3>
                        <div class="space-y-2 text-sm text-gray-300">
                            <p>Sistem Manajemen Dokumen Digital</p>
                            <p>DAOP 6 Yogyakarta</p>
                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <p class="text-xs text-gray-400">
                                    Version 1.0.0<br>
                                    Build {{ new Date().getFullYear() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-700 mt-8 pt-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">
                        <p class="text-gray-400 text-sm">
                            © {{ new Date().getFullYear() }} PT Kereta Api Indonesia (Persero). Hak Cipta Dilindungi.
                        </p>
                        <div class="flex space-x-6 text-sm text-gray-400">
                            <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                            <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                            <a href="#" class="hover:text-white transition-colors">Bantuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

