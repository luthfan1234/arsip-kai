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
    HomeIcon,
    ArchiveBoxIcon,
    ChevronDownIcon,
    ClipboardDocumentListIcon,
    Bars3Icon,
    XMarkIcon
} from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <Link :href="route('dashboard')" class="flex items-center hover:opacity-80 transition-opacity">
                    <img src="/images/Logo_PT_KAI.svg" class="h-8 w-auto" />
                </Link>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        :class="route().current('dashboard')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-700 hover:text-orange-600 hover:bg-gray-50'"
                    >
                        <HomeIcon class="w-5 h-5" />
                        <span>Dashboard</span>
                    </NavLink>

                    <NavLink
                        :href="route('documents.index')"
                        :active="route().current('documents.*')"
                        class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        :class="route().current('documents.*')
                            ? 'text-orange-600 bg-orange-50'
                            : 'text-gray-700 hover:text-orange-600 hover:bg-gray-50'"
                    >
                        <ClipboardDocumentListIcon class="w-5 h-5" />
                        <span>Dokumen</span>
                    </NavLink>

                    <!-- Master Data Dropdown (Admin Only) -->
                    <div v-if="$page.props.auth.user.role === 'admin'">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                                    :class="route().current('divisions.*') || route().current('categories.*')
                                        ? 'text-blue-600 bg-blue-50'
                                        : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'"
                                >
                                    <ArchiveBoxIcon class="w-5 h-5" />
                                    <span>Master Data</span>
                                    <ChevronDownIcon class="w-4 h-4" />
                                </button>
                            </template>
                            <template #content>
                                <div class="py-1">
                                    <DropdownLink
                                        :href="route('divisions.index')"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                    >
                                        <BuildingOfficeIcon class="w-4 h-4 mr-3 text-gray-400" />
                                        Unit Kerja
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('categories.index')"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                    >
                                        <TagIcon class="w-4 h-4 mr-3 text-gray-400" />
                                        Kategori
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </nav>

                <!-- User Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- User Info -->
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500">{{ $page.props.auth.user.role?.toUpperCase() || 'USER' }}</p>
                    </div>

                    <!-- User Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center justify-center w-10 h-10 bg-orange-500 rounded-full hover:bg-orange-600 transition-colors">
                                <UserIcon class="w-5 h-5 text-white" />
                            </button>
                        </template>
                        <template #content>
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                                    <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                                </div>
                                <DropdownLink
                                    :href="route('profile.edit')"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                >
                                    <UserIcon class="w-4 h-4 mr-3 text-gray-400" />
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                >
                                    <ArrowRightOnRectangleIcon class="w-4 h-4 mr-3 text-red-400" />
                                    Logout
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="flex items-center justify-center w-10 h-10 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
                    >
                        <Bars3Icon v-if="!showingNavigationDropdown" class="w-6 h-6" />
                        <XMarkIcon v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div
            :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="lg:hidden border-t border-gray-200 bg-white"
        >
            <!-- User Info Mobile -->
            <div class="px-4 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                        <UserIcon class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</div>
                        <div class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links Mobile -->
            <div class="px-4 py-4 space-y-1">
                <ResponsiveNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium"
                >
                    <HomeIcon class="w-5 h-5" />
                    <span>Dashboard</span>
                </ResponsiveNavLink>

                <ResponsiveNavLink
                    :href="route('documents.index')"
                    :active="route().current('documents.*')"
                    class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium"
                >
                    <ClipboardDocumentListIcon class="w-5 h-5" />
                    <span>Dokumen</span>
                </ResponsiveNavLink>

                <!-- Admin Menu Mobile -->
                <div v-if="$page.props.auth.user.role === 'admin'" class="pt-2">
                    <div class="px-3 py-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Master Data</p>
                    </div>

                    <ResponsiveNavLink
                        :href="route('divisions.index')"
                        :active="route().current('divisions.*')"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium ml-4"
                    >
                        <BuildingOfficeIcon class="w-5 h-5" />
                        <span>Unit Kerja</span>
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('categories.index')"
                        :active="route().current('categories.*')"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium ml-4"
                    >
                        <TagIcon class="w-5 h-5" />
                        <span>Kategori</span>
                    </ResponsiveNavLink>
                </div>

                <!-- User Actions Mobile -->
                <div class="pt-4 border-t border-gray-200">
                    <ResponsiveNavLink
                        :href="route('profile.edit')"
                        class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium text-gray-700"
                    >
                        <UserIcon class="w-5 h-5" />
                        <span>Profile</span>
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex items-center space-x-3 w-full px-3 py-2 rounded-md text-base font-medium text-red-600"
                    >
                        <ArrowRightOnRectangleIcon class="w-5 h-5" />
                        <span>Logout</span>
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </header>
</template>
