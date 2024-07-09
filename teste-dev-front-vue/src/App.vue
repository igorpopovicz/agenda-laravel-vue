<template>
  <div id="app" class="font-sans text-center p-6 bg-gray-100 min-h-screen">
    <header class="bg-white shadow-md py-4 mb-8">
      <h1 class="text-3xl font-bold text-blue-600">TESTE TECNICO CONSULTH TECH</h1>
      <nav class="mt-4">
        <router-link to="/" class="mx-4 text-blue-500 hover:text-blue-700">Home</router-link>
        <router-link to="/contacts" class="mx-4 text-blue-500 hover:text-blue-700">Criar Contato</router-link>
        <router-link to="/reservations" class="mx-4 text-blue-500 hover:text-blue-700">Agendar</router-link>
      </nav>
    </header>
    <main class="mt-8">
      <router-view />
    </main>
  </div>
</template>

<script setup>
</script>

<style scoped>
/* Tailwind CSS é utilizado diretamente no template, sem necessidade de estilos adicionais aqui */
</style>
