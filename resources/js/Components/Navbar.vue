<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import {
    BuildingOfficeIcon,
    TagIcon,
    UserIcon,
    ArrowRightOnRectangleIcon,
    ChartBarIcon,
    DocumentTextIcon,
    Bars3Icon,
    XMarkIcon,
    HomeIcon,
    ArchiveBoxIcon,
    ChevronDownIcon,
    ClipboardDocumentListIcon
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <!-- Header Utama -->
    <header class="bg-white border-b border-gray-200 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo dan Branding -->
                <Link :href="route('dashboard')" class="flex items-center space-x-4 hover:opacity-90 transition-all duration-200">
                    <img src="/images/Logo_PT_KAI.svg"  class="h-8 w-auto" />
                </Link>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden lg:flex items-center space-x-2">
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center justify-start space-x-3 px-6 py-3 h-12 rounded-2xl text-sm font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                        :class="route().current('dashboard')
                            ? 'text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-200'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50 border border-transparent hover:border-orange-200'"
                    >
                        <HomeIcon class="w-5 h-5 flex-shrink-0 self-center" />
                        <span class="whitespace-nowrap self-center">Dashboard</span>
                    </NavLink>

                    <NavLink
                        :href="route('documents.index')"
                        :active="route().current('documents.*')"
                        class="flex items-center justify-start space-x-3 px-6 py-3 h-12 rounded-2xl text-sm font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                        :class="route().current('documents.*')
                            ? 'text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-200'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50 border border-transparent hover:border-orange-200'"
                    >
                        <ClipboardDocumentListIcon class="w-5 h-5 flex-shrink-0 self-center" />
                        <span class="whitespace-nowrap self-center">Dokumen</span>
                    </NavLink>

                    <!-- Master Data Dropdown (Admin Only) -->
                    <div v-if="$page.props.auth.user.role === 'admin'" class="relative">
                        <Dropdown align="right" width="64">
                            <template #trigger>
                                <button
                                    class="flex items-center justify-center space-x-3 px-6 py-3 h-12 rounded-2xl text-sm font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 border border-transparent"
                                    :class="route().current('divisions.*') || route().current('categories.*')
                                        ? 'text-white bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-200'
                                        : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200'"
                                >
                                    <ArchiveBoxIcon class="w-5 h-5 flex-shrink-0" />
                                    <span class="whitespace-nowrap">Master Data</span>
                                    <ChevronDownIcon class="w-4 h-4 flex-shrink-0" />
                                </button>
                            </template>
                            <template #content>
                                <div class="py-2 bg-white rounded-2xl shadow-xl border border-gray-100">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Data Master</p>
                                    </div>
                                    <DropdownLink
                                        :href="route('divisions.index')"
                                        :class="route().current('divisions.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600'"
                                        class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 mx-2 rounded-xl"
                                    >
                                        <BuildingOfficeIcon class="w-5 h-5 mr-3" :class="route().current('divisions.*') ? 'text-blue-500' : 'text-gray-400'" />
                                        <div>
                                            <div class="font-semibold">Unit Kerja</div>
                                            <div class="text-xs text-gray-500">Kelola divisi DAOP 6</div>
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('categories.index')"
                                        :class="route().current('categories.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600'"
                                        class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 mx-2 rounded-xl"
                                    >
                                        <TagIcon class="w-5 h-5 mr-3" :class="route().current('categories.*') ? 'text-blue-500' : 'text-gray-400'" />
                                        <div>
                                            <div class="font-semibold">Kategori</div>
                                            <div class="text-xs text-gray-500">Klasifikasi dokumen</div>
                                        </div>
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </nav>

                <!-- User Menu (Desktop) -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- User Info Card -->
                    <div class="flex items-center space-x-4 bg-gradient-to-r from-gray-50 to-orange-50 rounded-2xl px-4 py-2 border border-gray-200">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex flex-col items-end">
                                <span class="px-3 py-1 text-xs font-bold bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full shadow-sm">
                                    {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <Dropdown align="right" width="56">
                        <template #trigger>
                            <button class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl hover:shadow-lg hover:shadow-orange-200 transition-all duration-300 hover:scale-105 group">
                                <UserIcon class="w-6 h-6 text-white group-hover:scale-110 transition-transform duration-200" />
                            </button>
                        </template>
                        <template #content>
                            <div class="py-2 bg-white rounded-2xl shadow-xl border border-gray-100">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900">{{ $page.props.auth.user.name }}</p>
                                    <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                                </div>
                                <DropdownLink
                                    :href="route('profile.edit')"
                                    class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 mx-2 rounded-xl"
                                >
                                    <UserIcon class="w-5 h-5 mr-3 text-gray-400" />
                                    <div>
                                        <div class="font-semibold">Profile Saya</div>
                                        <div class="text-xs text-gray-500">Kelola akun</div>
                                    </div>
                                </DropdownLink>
                                <hr class="my-2 mx-2">
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200 mx-2 rounded-xl"
                                >
                                    <ArrowRightOnRectangleIcon class="w-5 h-5 mr-3 text-red-400" />
                                    <div class="text-left">
                                        <div class="font-semibold">Keluar</div>
                                        <div class="text-xs text-red-400">Logout dari sistem</div>
                                    </div>
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 hover:shadow-lg hover:shadow-orange-200 transition-all duration-300"
                    >
                        <Bars3Icon v-if="!showingNavigationDropdown" class="w-6 h-6 text-white" />
                        <XMarkIcon v-else class="w-6 h-6 text-white" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="lg:hidden border-t border-gray-200 bg-white">
            <!-- User Info Mobile -->
            <div class="px-6 py-6 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-orange-200">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <UserIcon class="w-7 h-7 text-white" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-base font-bold text-gray-900 truncate">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm text-gray-600 truncate">{{ $page.props.auth.user.email }}</div>
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-bold bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full shadow-sm">
                            {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Mobile -->
            <div class="px-6 py-6 space-y-2">
                <div class="mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Menu Utama</p>
                </div>

                <ResponsiveNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    class="flex items-center px-4 py-4 rounded-2xl text-base font-semibold transition-all duration-200 shadow-sm"
                    :class="route().current('dashboard')
                        ? 'text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg'
                        : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50 border border-gray-200 hover:border-orange-200'"
                >
                    <HomeIcon class="w-6 h-6 mr-4" />
                    <div>
                        <div class="font-semibold">Dashboard</div>
                        <div class="text-xs opacity-75">Halaman utama</div>
                    </div>
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    :href="route('documents.index')"
                    :active="route().current('documents.*')"
                    class="flex items-center px-4 py-4 rounded-2xl text-base font-semibold transition-all duration-200 shadow-sm"
                    :class="route().current('documents.*')
                        ? 'text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg'
                        : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50 border border-gray-200 hover:border-orange-200'"
                >
                    <ClipboardDocumentListIcon class="w-6 h-6 mr-4" />
                    <div>
                        <div class="font-semibold">Dokumen</div>
                        <div class="text-xs opacity-75">Arsip digital</div>
                    </div>
                </ResponsiveNavLink>

                <!-- Admin Menu Mobile -->
                <div v-if="$page.props.auth.user.role === 'admin'" class="pt-4">
                    <div class="mb-3">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wide">Master Data</p>
                    </div>

                    <ResponsiveNavLink
                        :href="route('divisions.index')"
                        :active="route().current('divisions.*')"
                        class="flex items-center px-4 py-4 rounded-2xl text-base font-semibold transition-all duration-200 shadow-sm ml-4"
                        :class="route().current('divisions.*')
                            ? 'text-white bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg'
                            : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50 border border-gray-200 hover:border-blue-200'"
                    >
                        <BuildingOfficeIcon class="w-6 h-6 mr-4" />
                        <div>
                            <div class="font-semibold">Unit Kerja</div>
                            <div class="text-xs opacity-75">Kelola divisi</div>
                        </div>
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('categories.index')"
                        :active="route().current('categories.*')"
                        class="flex items-center px-4 py-4 rounded-2xl text-base font-semibold transition-all duration-200 shadow-sm ml-4 mt-2"
                        :class="route().current('categories.*')
                            ? 'text-white bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg'
                            : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50 border border-gray-200 hover:border-blue-200'"
                    >
                        <TagIcon class="w-6 h-6 mr-4" />
                        <div>
                            <div class="font-semibold">Kategori</div>
                            <div class="text-xs opacity-75">Klasifikasi dokumen</div>
                        </div>
                    </ResponsiveNavLink>
                </div>
            </div>

            <!-- User Actions Mobile -->
            <div class="px-6 py-6 border-t border-gray-200 space-y-2 bg-gray-50">
                <div class="mb-3">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pengaturan</p>
                </div>

                <ResponsiveNavLink
                    :href="route('profile.edit')"
                    class="flex items-center px-4 py-4 rounded-2xl text-base font-semibold text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200 border border-gray-200 hover:border-orange-200 shadow-sm"
                >
                    <UserIcon class="w-6 h-6 mr-4" />
                    <div>
                        <div class="font-semibold">Profile Saya</div>
                        <div class="text-xs text-gray-500">Kelola akun</div>
                    </div>
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex items-center w-full px-4 py-4 rounded-2xl text-base font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200 border border-red-200 hover:border-red-300 shadow-sm"
                >
                    <ArrowRightOnRectangleIcon class="w-6 h-6 mr-4" />
                    <div class="text-left">
                        <div class="font-semibold">Keluar</div>
                        <div class="text-xs text-red-400">Logout dari sistem</div>
                    </div>
                </ResponsiveNavLink>
            </div>
        </div>
    </header>
</template>
