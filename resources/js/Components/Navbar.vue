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
    <header class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo dan Branding -->
                <Link :href="route('dashboard')" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                            <DocumentTextIcon class="h-6 w-6 text-white" />
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-semibold text-gray-900">PT Kereta Api Indonesia</h1>
                        <p class="text-xs text-orange-600 -mt-1">DAOP 6 Yogyakarta</p>
                    </div>
                </Link>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center space-x-1">
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        :class="route().current('dashboard')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                    >
                        <HomeIcon class="w-4 h-4" />
                        <span>Dashboard</span>
                    </NavLink>

                    <NavLink
                        :href="route('documents.index')"
                        :active="route().current('documents.*')"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        :class="route().current('documents.*')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                    >
                        <DocumentTextIcon class="w-4 h-4" />
                        <span>Dokumen</span>
                    </NavLink>

                    <!-- Master Data Dropdown (Admin Only) -->
                    <div v-if="$page.props.auth.user.role === 'admin'" class="relative">
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                                    :class="route().current('divisions.*') || route().current('categories.*') 
                                        ? 'text-orange-600 bg-orange-50' 
                                        : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                                >
                                    <ArchiveBoxIcon class="w-4 h-4" />
                                    <span>Master Data</span>
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <div class="py-1">
                                    <DropdownLink :href="route('divisions.index')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        <BuildingOfficeIcon class="w-4 h-4 mr-3 text-gray-400" />
                                        Unit Kerja
                                    </DropdownLink>
                                    <DropdownLink :href="route('categories.index')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        <TagIcon class="w-4 h-4 mr-3 text-gray-400" />
                                        Kategori
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </nav>

                <!-- User Menu (Desktop) -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                            {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                        </span>
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full hover:bg-orange-200 transition-colors">
                                    <UserIcon class="w-4 h-4 text-orange-600" />
                                </button>
                            </template>
                            <template #content>
                                <div class="py-1">
                                    <DropdownLink :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        <UserIcon class="w-4 h-4 mr-3 text-gray-400" />
                                        Profile
                                    </DropdownLink>
                                    <hr class="my-1">
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <ArrowRightOnRectangleIcon class="w-4 h-4 mr-3 text-red-400" />
                                        Keluar
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-50 hover:bg-orange-100 transition-colors"
                    >
                        <Bars3Icon v-if="!showingNavigationDropdown" class="w-5 h-5 text-orange-600" />
                        <XMarkIcon v-else class="w-5 h-5 text-orange-600" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="md:hidden border-t border-gray-100 bg-white">
            <!-- User Info Mobile -->
            <div class="px-4 py-4 bg-orange-50 border-b border-orange-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                        <UserIcon class="w-5 h-5 text-white" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ $page.props.auth.user.name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $page.props.auth.user.email }}</div>
                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                            {{ $page.props.auth.user.role ? $page.props.auth.user.role.toUpperCase() : 'USER' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Mobile -->
            <div class="px-4 py-4 space-y-1">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')"
                    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                    :class="route().current('dashboard')
                        ? 'text-orange-600 bg-orange-50'
                        : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                >
                    <HomeIcon class="w-4 h-4 mr-3" />
                    Dashboard
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('documents.index')" :active="route().current('documents.*')"
                    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                    :class="route().current('documents.*')
                        ? 'text-orange-600 bg-orange-50'
                        : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                >
                    <DocumentTextIcon class="w-4 h-4 mr-3" />
                    Dokumen
                </ResponsiveNavLink>

                <!-- Admin Menu Mobile -->
                <div v-if="$page.props.auth.user.role === 'admin'" class="pt-2">
                    <div class="px-3 py-1 text-xs font-medium text-orange-600 uppercase tracking-wider">Master Data</div>
                    <ResponsiveNavLink :href="route('divisions.index')" :active="route().current('divisions.*')"
                        class="flex items-center px-6 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        :class="route().current('divisions.*')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                    >
                        <BuildingOfficeIcon class="w-4 h-4 mr-3" />
                        Unit Kerja
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('categories.index')" :active="route().current('categories.*')"
                        class="flex items-center px-6 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        :class="route().current('categories.*')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50'"
                    >
                        <TagIcon class="w-4 h-4 mr-3" />
                        Kategori
                    </ResponsiveNavLink>
                </div>
            </div>

            <!-- User Actions Mobile -->
            <div class="px-4 py-4 border-t border-gray-100 space-y-1">
                <ResponsiveNavLink :href="route('profile.edit')"
                    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-orange-600 hover:bg-orange-50 transition-all duration-200"
                >
                    <UserIcon class="w-4 h-4 mr-3" />
                    Profile
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                    class="flex items-center w-full px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200"
                >
                    <ArrowRightOnRectangleIcon class="w-4 h-4 mr-3" />
                    Keluar
                </ResponsiveNavLink>
            </div>
        </div>
    </header>
</template>
