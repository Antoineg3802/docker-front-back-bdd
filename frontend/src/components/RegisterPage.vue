<template>
  <div class="h-screen w-screen flex justify-center items-center">
    <div class="flex min-h-full w-1/2 flex-col justify-center align-middle px-6 py-12 lg:px-8">
      <h2 class="mt-10 w-full text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Enregistez-vous !
      </h2>

      <div class="mt-10 sm:mx-auto sm:w-full">
        <form class="flex flex-col gap-4" @submit.prevent="handleSubmit">
          <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-900"
              >Adresse Email</label
            >
            <div class="mt-2">
              <input
                type="email"
                name="email"
                id="email"
                autocomplete="email"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                v-model="email"
                required
              />
            </div>
          </div>

          <div>
            <label for="username" class="block text-sm/6 font-medium text-gray-900"
              >Nom d'utilisateur</label
            >
            <div class="mt-2">
              <input
                type="username"
                name="username"
                id="username"
                autocomplete="username"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                v-model="username"
                required
              />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm/6 font-medium text-gray-900"
              >Mot de passe</label
            >
            <div class="mt-2">
              <input
                type="password"
                name="password"
                id="password"
                autocomplete="current-password"
                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                v-model="password"
                required
              />
            </div>
          </div>

          <div class>
            <button
              type="submit"
              class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              S'enregister
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { apiUrl } from '@/composables/useApi'

let email = ref('')
let username = ref('')
let password = ref('')

function handleSubmit() {
  let newUser = {
    email: email.value,
    username: username.value,
    password: password.value,
  }

  fetch(`${apiUrl}register`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(newUser),
  })
  .then((response) => response.json())
  .then((data)=>{
    if (!data.error){
      window.location.href = '/login'
    } else {
      alert('Error creating user')
    }
  })
}
</script>
