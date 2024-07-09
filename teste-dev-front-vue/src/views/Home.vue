<template>
  <div class="p-6 bg-gray-50 min-h-screen flex flex-col items-center">

    <div class="w-full max-w-4xl">
      <section class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-2xl font-semibold text-blue-600">Contatos</h3>
        <div v-if="contacts.length > 0" class="mt-4">
          <ul>
            <li v-for="contact in contacts" :key="contact.id" class="border border-gray-300 p-4 rounded-lg shadow-md bg-white mb-4">
              <h4 class="text-xl font-bold text-blue-700">{{ contact.name }}</h4>
              <p class="text-gray-700"><span class="font-semibold">Email:</span> {{ contact.email }}</p>
              <p class="text-gray-700"><span class="font-semibold">Phone:</span> {{ contact.phone }}</p>
              <p class="text-gray-700"><span class="font-semibold">Address:</span> {{ contact.address }}</p>
            </li>
          </ul>
        </div>
        <div v-else class="mt-4 text-red-500">
          <p>nenhum contato encontrado.</p>
        </div>
      </section>

      <section class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-blue-600">Agendamentos</h3>
        <div v-if="reservations.length > 0" class="mt-4">
          <ul>
            <li v-for="reservation in reservations" :key="reservation.id" class="border border-gray-300 p-4 rounded-lg shadow-md bg-white mb-4">
              <h4 class="text-xl font-bold text-blue-700">{{ reservation.contact.name }}</h4>
              <p class="text-gray-700"><span class="font-semibold">Date:</span> {{ reservation.date }}</p>
              <p class="text-gray-700"><span class="font-semibold">Time:</span> {{ reservation.time }}</p>
              <p class="text-gray-700"><span class="font-semibold">Description:</span> {{ reservation.description }}</p>
            </li>
          </ul>
        </div>
        <div v-else class="mt-4 text-red-500">
          <p>Nenhum agendamento encontrado.</p>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const contacts = ref([]);
const reservations = ref([]);

const fetchContacts = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/contacts');
    contacts.value = response.data;
  } catch (error) {
    console.error('Failed to fetch contacts', error);
  }
};

const fetchReservations = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/reservations');
    reservations.value = response.data;
  } catch (error) {
    console.error('Failed to fetch reservations', error);
  }
};

onMounted(() => {
  fetchContacts();
  fetchReservations();
});
</script>

<style scoped>
h2 {
  margin-bottom: 20px;
}

h3 {
  margin-top: 30px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  border: 1px solid #ccc;
  margin-bottom: 10px;
  padding: 10px;
}

p {
  margin: 5px 0;
}
</style>
