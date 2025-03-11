<template>
  <div class="h-screen w-screen bg-gray-50">
    <!-- En-tête -->
    <header class="bg-white shadow">
      <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Testtttt</h1>
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
          Inscrivez-vous pour accéder à une galerie d'images, liker et disliker vos photos
          préférées.
        </p>
      </section>

      <!-- Galerie d'images -->
      <section>
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Galerie d'images</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          <div
            v-for="image in images"
            :key="image.id"
            class="bg-white rounded shadow overflow-hidden"
          >
            <img :src="image.src" :alt="image.alt" class="w-full h-48 object-cover" />
            <div class="p-4">
              <div class="flex justify-between items-center">
                <button @click="likeImage(image.id)" class="text-green-600 hover:text-green-800">
                  👍 {{ image.likes }}
                </button>
                <button @click="dislikeImage(image.id)" class="text-red-600 hover:text-red-800">
                  👎 {{ image.dislikes }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Pied de page -->
    <footer class="bg-gray-100 py-4 mt-12">
      <div class="container mx-auto px-4 text-center text-gray-600">© 2025 INSTAAAGRAM.</div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'

import { useAuth,  } from '@/composables/useAuth';

const { isAuthenticated, removeToken } = useAuth();

console.log(isAuthenticated)


onMounted(() => {
  const apiUrl = import.meta.env.VITE_API_URL
  console.log(apiUrl + 'api/')
  fetch(apiUrl + 'api/')
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
    })
})

interface Image {
  id: number
  src: string
  alt: string
  likes: number
  dislikes: number
}

const images = ref<Image[]>([
  {
    id: 1,
    src: 'https://via.placeholder.com/400x300',
    alt: 'Image 1',
    likes: 0,
    dislikes: 0,
  },
  {
    id: 2,
    src: 'https://via.placeholder.com/400x300',
    alt: 'Image 2',
    likes: 0,
    dislikes: 0,
  },
  {
    id: 3,
    src: 'https://via.placeholder.com/400x300',
    alt: 'Image 3',
    likes: 0,
    dislikes: 0,
  },
])

function goTo(page: string): void {
  // Simuler une navigation vers la page 'login' ou 'register'
  alert(`Navigation vers la page ${page}`)
}

function likeImage(id: number): void {
  const image = images.value.find((img) => img.id === id)
  if (image) {
    image.likes++
    // Ajouter ici la logique pour stocker cette interaction de manière persistante
  }
}

function dislikeImage(id: number): void {
  const image = images.value.find((img) => img.id === id)
  if (image) {
    image.dislikes++
    // Ajouter ici la logique pour stocker cette interaction de manière persistante
  }
}
</script>

<style scoped>
/* Ajoutez ici vos styles personnalisés si nécessaire */
</style>
