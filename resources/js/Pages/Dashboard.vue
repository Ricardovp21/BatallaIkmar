<script setup>
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth?.user ?? { name: 'Invitado' };

// Datos simulados
const stats = {
    victorias: 12,
    derrotas: 5
};

const historial = [
    { id: 1, fecha: '2025-06-15', resultado: 'Victoria' },
    { id: 2, fecha: '2025-06-14', resultado: 'Derrota' },
    { id: 3, fecha: '2025-06-13', resultado: 'Victoria' }
];
</script>

<template>
  <Head title="dashboard" />

  <!-- Header directo -->
  <header class="flex items-center justify-between p-4 bg-white shadow">
    <h1 class="text-2xl font-bold text-blue-700">IKMAR Battleship Pro</h1>
    <div class="flex items-center gap-4">
      <span class="font-semibold text-gray-700">Hola, {{ user.name }}</span>
      <form method="post" action="/logout">
        <button type="submit" class="font-bold text-red-500">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <!-- Contenido -->
  <div class="px-4 py-8 mx-auto max-w-7xl">
    <div class="mb-8">
      <h2 class="text-3xl font-bold text-gray-900">¡Prepara tu flota para la batalla!</h2>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
      <button class="w-full py-4 text-xl text-white transition bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700">
        Iniciar Partida
      </button>
      <button class="w-full py-4 text-xl text-white transition bg-green-600 rounded-lg shadow-lg hover:bg-green-700">
        Unirse a Partida
      </button>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-8">
      <div class="p-6 text-center bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-green-600">{{ stats.victorias }}</h2>
        <p class="text-gray-600">Victorias</p>
      </div>
      <div class="p-6 text-center bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-red-600">{{ stats.derrotas }}</h2>
        <p class="text-gray-600">Derrotas</p>
      </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
      <h3 class="mb-4 text-xl font-bold text-gray-800">Historial de Partidas</h3>
      <ul class="divide-y divide-gray-200">
        <li v-for="partida in historial" :key="partida.id" class="flex justify-between py-2">
          <span>{{ partida.fecha }}</span>
          <span :class="partida.resultado === 'Victoria' ? 'text-green-600' : 'text-red-600'">
            {{ partida.resultado }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>
