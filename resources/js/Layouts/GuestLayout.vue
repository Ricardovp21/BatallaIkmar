<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Bienvenido from '@/Components/Bienvenido.vue'; // Asegúrate de que la ruta sea correcta
</script>

<template>
    <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 text-gray-500 fill-current" />
            </Link>
        </div>

        <Bienvenido /> <!-- Aquí se muestra el componente Bienvenido -->

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
