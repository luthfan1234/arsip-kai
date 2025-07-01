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
    ArchiveBoxIcon
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <!-- Header Utama -->
    <header class="bg-blue-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="bg-white p-1 rounded-md">
                    <!-- Logo PT KAI -->
                    <div class="h-8 w-20 bg-gray-200 rounded flex items-center justify-center">
                        <span class="text-xs text-gray-600 font-bold">LOGO KAI</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-lg font-bold">PT KERETA API INDONESIA</h1>
                    <p class="text-sm">DAOP 6 Yogyakarta</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <p class="font-semibold">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs text-blue-200">{{ $page.props.auth.user.email }}</p>
                </div>
                <div class="bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
                    {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                </div>

                <!-- Desktop Dropdown -->
                <div class="hidden md:block">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="text-white hover:text-blue-200 transition-colors">
                                <Bars3Icon class="w-6 h-6" />
                            </button>
                        </template>
                        <template #content>
                            <div class="py-2">
                                <DropdownLink :href="route('profile.edit')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                    <UserIcon class="w-4 h-4 mr-3 text-gray-400" />
                                    Profile Saya
                                </DropdownLink>
                                <hr class="my-1">
                                <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                    <ArrowRightOnRectangleIcon class="w-4 h-4 mr-3 text-red-400" />
                                    Keluar
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="text-white hover:text-blue-200 transition-colors"
                    >
                        <Bars3Icon v-if="!showingNavigationDropdown" class="w-6 h-6" />
                        <XMarkIcon v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigasi Sekunder -->
    <nav class="bg-white shadow-sm">
        <div class="container mx-auto px-6">
            <div class="flex items-center space-x-8 overflow-x-auto">
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    class="flex items-center space-x-2 border-b-2 py-4 text-sm font-semibold whitespace-nowrap transition-colors"
                    :class="route().current('dashboard')
                        ? 'border-blue-600 text-blue-600'
                        : 'border-transparent text-slate-500 hover:text-blue-600'"
                >
                    <HomeIcon class="w-5 h-5" />
                    <span>Dashboard</span>
                </NavLink>

                <NavLink
                    :href="route('documents.index')"
                    :active="route().current('documents.*')"
                    class="flex items-center space-x-2 border-b-2 py-4 text-sm font-medium whitespace-nowrap transition-colors"
                    :class="route().current('documents.*')
                        ? 'border-blue-600 text-blue-600'
                        : 'border-transparent text-slate-500 hover:text-blue-600'"
                >
                    <DocumentTextIcon class="w-5 h-5" />
                    <span>Dokumen</span>
                </NavLink>

                <!-- Master Data Dropdown (Admin Only) -->
                <div v-if="$page.props.auth.user.role === 'admin'" class="relative flex items-center">
                    <Dropdown align="left" width="56">
                        <template #content>
                            <div class="py-2">
                                <DropdownLink :href="route('divisions.index')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">
                                    <BuildingOfficeIcon class="w-4 h-4 mr-3 text-gray-400" />
                                    Unit Kerja
                                </DropdownLink>
                                <DropdownLink :href="route('categories.index')" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">
                                    <TagIcon class="w-4 h-4 mr-3 text-gray-400" />
                                    Kategori
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="md:hidden border-t border-gray-200 bg-gray-50">
            <!-- User Info Mobile -->
            <div class="px-4 py-4 bg-blue-600">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <UserIcon class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">{{ $page.props.auth.user.name }}</div>
                        <div class="text-xs text-blue-200">{{ $page.props.auth.user.email }}</div>
                        <span class="inline-block mt-1 px-2 py-1 text-xs bg-orange-500 text-white rounded-full font-bold">
                            {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Mobile -->
            <div class="px-2 py-3 space-y-1">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')"
                    class="flex items-center px-3 py-3 rounded-lg text-base font-medium transition-all duration-200"
                    :class="route().current('dashboard')
                        ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600'
                        : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'"
                >
                    <HomeIcon class="w-5 h-5 mr-3" />
                    Dashboard
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('documents.index')" :active="route().current('documents.*')"
                    class="flex items-center px-3 py-3 rounded-lg text-base font-medium transition-all duration-200"
                    :class="route().current('documents.*')
                        ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600'
                        : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'"
                >
                    <DocumentTextIcon class="w-5 h-5 mr-3" />
                    Dokumen
                </ResponsiveNavLink>

                <!-- Admin Menu Mobile -->
                <div v-if="$page.props.auth.user.role === 'admin'" class="pt-2">
                    <ResponsiveNavLink :href="route('divisions.index')" :active="route().current('divisions.*')"
                        class="flex items-center px-6 py-3 rounded-lg text-base font-medium transition-all duration-200"
                        :class="route().current('divisions.*')
                            ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600'
                            : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'"
                    >
                        <BuildingOfficeIcon class="w-5 h-5 mr-3" />
                        Unit Kerja
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('categories.index')" :active="route().current('categories.*')"
                        class="flex items-center px-6 py-3 rounded-lg text-base font-medium transition-all duration-200"
                        :class="route().current('categories.*')
                            ? 'text-blue-600 bg-blue-50 border-l-4 border-blue-600'
                            : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'"
                    >
                        <TagIcon class="w-5 h-5 mr-3" />
                        Kategori
                    </ResponsiveNavLink>
                </div>

                <!-- User Actions Mobile -->
                <div class="pt-4 border-t border-gray-200 mt-4">
                    <ResponsiveNavLink :href="route('profile.edit')"
                        class="flex items-center px-3 py-3 rounded-lg text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                    >
                        <UserIcon class="w-5 h-5 mr-3" />
                        Profile Saya
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                        class="flex items-center w-full px-3 py-3 rounded-lg text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200"
                    >
                        <ArrowRightOnRectangleIcon class="w-5 h-5 mr-3" />
                        Keluar
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
