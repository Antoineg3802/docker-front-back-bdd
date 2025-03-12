<template>
  <div class="h-screen w-screen bg-gray-50 relative">
    <div v-if="imageFormVisible" class="bg-black opacity-25 absolute top-0 bottom-0 left-0 right-0 z-10"></div>
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
          Inscrivez-vous pour accéder à une galerie d'images, ajouter des photos, liker et disliker vos photos
          préférées.
        </p>
        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hover:cursor-pointer" v-if="isAuthenticated" @click="handleDisplayImageForm">Ajouter une photo</button>
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
    <ImageUploaderForm :visible="imageFormVisible" @closeModale="closeForm" />
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useAuth,  } from '@/composables/useAuth';
import ImageUploaderForm from '@/components/ImageUploaderForm.vue';

const { isAuthenticated, removeToken } = useAuth();
const imageFormVisible = ref(false);

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

function handleDisplayImageForm(): void {
  imageFormVisible.value = !imageFormVisible.value;
  // Ajouter ici la logique pour ajouter une image
}

function closeForm(){
  imageFormVisible.value = false;
}
</script>

<style scoped>
/* Ajoutez ici vos styles personnalisés si nécessaire */
</style>
