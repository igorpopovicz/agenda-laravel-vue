<template>
  <form @submit.prevent="handleSubmit" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="mb-4">
      <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome:</label>
      <input type="text" v-model="form.name" id="name" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail:</label>
      <input type="email" v-model="form.email" id="email" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="mb-4">
      <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone:</label>
      <input type="text" v-model="form.phone" id="phone" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="mb-4">
      <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Endereço:</label>
      <textarea v-model="form.address" id="address" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>
    <div class="flex justify-between items-center">
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Criar Contato
      </button>
      <button type="button" @click="resetForm" class="px-4 py-2 bg-gray-300 text-gray-700 font-semibold rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
        Limpar Formulário
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
});

const handleSubmit = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/contacts', form.value);
    console.log('Contact created:', response.data);
    alert('Contato criado com sucesso!');
    resetForm();
  } catch (error) {
    console.error('Failed to create contact', error);
    alert('Erro ao criar contato!');
  }
};

const resetForm = () => {
  form.value = {
    name: '',
    email: '',
    phone: '',
    address: '',
  };
};

</script>
