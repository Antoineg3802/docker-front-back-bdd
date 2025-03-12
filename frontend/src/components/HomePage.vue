<template>
  <div class="h-screen w-screen bg-gray-50 relative">
    <div
      v-if="imageFormVisible"
      class="bg-black opacity-25 absolute top-0 bottom-0 left-0 right-0 z-10"
    ></div>
    <!-- En-tête -->
    <header class="bg-white shadow">
      <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">INSTAAAGRAM</h1>
        <nav class="space-x-4" v-if="!isAuthenticated">
          <a
            href="/login"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hover:cursor-pointer"
          >
            Connexion
          </a>
          <a
            href="/register"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 hover:cursor-pointer"
          >
            Inscription
          </a>
        </nav>
        <nav class="space-x-4" v-else>
          <button
            @click="removeToken"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
          >
            Déconnexion
          </button>
        </nav>
      </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-12">
      <!-- Section d'accueil / Hero -->
      <section class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur notre plateforme</h2>
        <p class="text-lg text-gray-600">
          Inscrivez-vous pour accéder à une galerie d'images, ajouter des photos, liker et disliker
          vos photos préférées.
        </p>
        <button
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hover:cursor-pointer"
          v-if="isAuthenticated"
          @click="handleDisplayImageForm"
        >
          Ajouter une photo
        </button>
      </section>

      <!-- Mes images -->
      <section v-if="isAuthenticated">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Mes images</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <ImageComponent :images="userImages" class="bg-white rounded shadow overflow-hidden" />
        </div>
      </section>

      <!-- Galerie d'images -->
      <section>
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Galerie d'images</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <ImageComponent :images="allImages" class="bg-white rounded shadow overflow-hidden" />
        </div>
      </section>
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-100 py-4 mt-12">
      <div class="container mx-auto px-4 text-center text-gray-600">© 2025 INSTAAAGRAM.</div>
    </footer>
    <ImageUploaderForm :visible="imageFormVisible" @closeModale="closeForm" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuth, token } from '@/composables/useAuth'
import ImageUploaderForm from '@/components/ImageUploaderForm.vue'
import ImageComponent from '@/components/ImageComponent.vue'

const apiUrl = import.meta.env.VITE_API_URL as string

const { isAuthenticated, removeToken } = useAuth()
const imageFormVisible = ref(false)

interface Image {
  id: number
  imageData: string
  user: string
}

let userImages = ref<Image[]>([])
let allImages = ref<Image[]>([])

if (isAuthenticated) {
  fetch(apiUrl + 'image', {
    headers: {
      Authorization: `Bearer ${token.value}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        userImages.value = []
      } else {
        userImages.value = data
      }
      console.log(data.error)
      console.log(userImages)
    })

  fetch(apiUrl + 'image/all', {
    headers: {
      Authorization: `Bearer ${token.value}`,
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        allImages.value = []
      } else {
        allImages.value = data
      }
    })
}

function likeImage(id: number): void {
  // const image = images.value.find((img) => img.id === id)
  // if (image) {
  //   image.likes++
  //   // Ajouter ici la logique pour stocker cette interaction de manière persistante
  // }
}

function dislikeImage(id: number): void {
  // const image = images.value.find((img) => img.id === id)
  // if (image) {
  //   image.dislikes++
  //   // Ajouter ici la logique pour stocker cette interaction de manière persistante
  // }
}

function handleDisplayImageForm(): void {
  imageFormVisible.value = !imageFormVisible.value
}

function closeForm() {
  imageFormVisible.value = false
}
</script>

<style scoped>
/* Ajoutez ici vos styles personnalisés si nécessaire */
</style>
