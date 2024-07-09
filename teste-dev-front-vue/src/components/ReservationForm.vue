<template>
  <form @submit.prevent="handleSubmit" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="mb-4">
      <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-2">Contato:</label>
      <select v-model="form.contact_id" id="contact_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option v-for="contact in contacts" :key="contact.id" :value="contact.id">
          {{ contact.name }}
        </option>
      </select>
    </div>
    <div class="mb-4">
      <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Data:</label>
      <input type="date" v-model="form.date" id="date" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="mb-4">
      <label for="time" class="block text-sm font-medium text-gray-700 mb-2">Horário:</label>
      <input type="time" v-model="form.time" id="time" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="mb-4">
      <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição:</label>
      <textarea v-model="form.description" id="description" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>
    <div class="flex justify-between items-center">
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        {{ isEditing ? 'Atualizar Agendamento' : 'Criar Agendamento'}}
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
  contact_id: null,
  date: '',
  time: '',
  description: '',
});

const contacts = ref([]);

const fetchContacts = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/contacts');
    contacts.value = response.data;
  } catch (error) {
    console.error('Failed to fetch contacts', error);
    alert('Erro ao buscar contatos!');
  }
};

fetchContacts();

let isEditing = false;
let reservationId = null;

const handleSubmit = async () => {
  try {
    const endpoint = isEditing ? `http://localhost:8000/api/reservations/${reservationId}` : 'http://localhost:8000/api/reservations';
    const method = isEditing ? 'put' : 'post';
    const response = await axios[method](endpoint, form.value);
    if (isEditing) {
      // Update existing reservation in local state
      const updatedReservation = response.data;
      const index = reservations.value.findIndex(r => r.id === updatedReservation.id);
      if (index !== -1) {
        reservations.value.splice(index, 1, updatedReservation);
      }
    } else {
      reservations.value.push(response.data);
      alert('Agendamento criado com sucesso!');

    }
    resetForm();
  } catch (error) {
    console.error(`Failed to ${isEditing ? 'update' : 'create'} reservation`, error);
    alert(`Erro ao ${isEditing ? 'atualizar' : 'criar'} agendamento!`);
  }
};

const resetForm = () => {
  form.value = {
    contact_id: null,
    date: '',
    time: '',
    description: '',
  };
  isEditing = false;
  reservationId = null;
};
</script>
