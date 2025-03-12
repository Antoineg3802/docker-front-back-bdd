<!-- faire un form d'ajout d'image -->
<template>
  <div
    v-if="visible"
    class="absolute top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center w-full z-20"
  >
    <div class="bg-white p-8 rounded-lg shadow-lg opacity-100 relative w-1/3 h-1/2">
      <button class="absolute top-2 right-2 hover:cursor-pointer" @click="$emit('closeModale')">
        ❌
      </button>
      <form
        class="h-full w-full flex flex-col items-center justify-center gap-4 mt-4"
        @submit.prevent="handleSubmit"
      >
        <h1 class="text-2xl font-bold">Ajouter une image</h1>
        <div>
          <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Choisissez un fichier :</label
          >
          <input
            id="file"
            type="file"
            accept="image/png, image/jpeg"
            class="hover:cursor-pointer block p-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            required
            @change="handleFileChange"
          />
        </div>
        <div>
          <label
            for="first_name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >First name</label
          >
          <input
            type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Image incroyable"
            required
            v-model="title"
          />
        </div>
        <div class="w-1/2">
          <button
            type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold hover:cursor-pointer text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Ajouter
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { token } from '@/composables/useAuth'

defineProps({
  visible: Boolean,
})

const emit = defineEmits(['closeModale'])

const title = ref('')
const file = ref<File | null>(null)
const apiUrl = import.meta.env.VITE_API_URL

function handleFileChange(event: Event) {
  const files = (event.target as HTMLInputElement).files
  if (files) {
    file.value = files[0]
  }
}

async function handleSubmit() {
  if (!file.value) {
    alert('Veuillez choisir un fichier')
    return
  }

  const formData = new FormData()
  formData.append('title', title.value)
  formData.append('image', file.value)

  fetch(apiUrl + 'image', {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${token.value}`,
    },
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        alert("Erreur lors de l'ajout de l'image")
        return
      }
      alert('Image ajoutée avec succès')
      emit('closeModale')
    })
}
</script>
