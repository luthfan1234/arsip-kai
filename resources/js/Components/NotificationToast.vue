<template>
    <div
        v-if="show"
        class="fixed top-4 right-4 z-50 max-w-sm w-full"
    >
        <div
            :class="[
                'rounded-lg p-4 shadow-lg border',
                {
                    'bg-green-50 border-green-200 text-green-800': type === 'success',
                    'bg-red-50 border-red-200 text-red-800': type === 'error',
                    'bg-yellow-50 border-yellow-200 text-yellow-800': type === 'warning',
                    'bg-blue-50 border-blue-200 text-blue-800': type === 'info',
                }
            ]"
            role="alert"
        >
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <CheckCircleIcon v-if="type === 'success'" class="h-5 w-5 text-green-500" />
                    <XCircleIcon v-else-if="type === 'error'" class="h-5 w-5 text-red-500" />
                    <ExclamationTriangleIcon v-else-if="type === 'warning'" class="h-5 w-5 text-yellow-500" />
                    <InformationCircleIcon v-else="type === 'info'" class="h-5 w-5 text-blue-500" />
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">{{ message }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button
                        @click="hide"
                        class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <XMarkIcon class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import {
    CheckCircleIcon,
    XCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    type: {
        type: String,
        default: 'info',
        validator: (value) => ['success', 'error', 'warning', 'info'].includes(value),
    },
    message: {
        type: String,
        required: true,
    },
    duration: {
        type: Number,
        default: 5000,
    },
});

const show = ref(false);

const hide = () => {
    show.value = false;
};

onMounted(() => {
    show.value = true;

    if (props.duration > 0) {
        setTimeout(() => {
            hide();
        }, props.duration);
    }
});
</script>
