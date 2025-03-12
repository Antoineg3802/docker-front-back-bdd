<template>
  <div class="h-screen w-screen bg-gray-50 relative overflow-x-hidden">
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

      <div v-if="isAuthenticated" class="flex flex-col gap-12">
        <!-- Mes images -->
        <section v-if="isAuthenticated">
          <h3 class="text-2xl font-semibold text-gray-800 mb-6">Mes images</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <ImageComponent :images="userImages" @like="handleLike" @dislike="handleDislike" />
            <p v-if="!userImages">Pas encore d'images...</p>
          </div>
        </section>

        <!-- Galerie d'images -->
        <section>
          <h3 class="text-2xl font-semibold text-gray-800 mb-6">Images de la communauté</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <ImageComponent :images="allImages" @like="handleLike" @dislike="handleDislike" />
            <p v-if="!allImages">Pas encore d'images...</p>
          </div>
        </section>
      </div>
      <div
        class="flex flex-col items-center p-6 border-[1px] border-red-900 bg-red-200 rounded-xl"
        v-else
      >
        <p class="text-center text-red-600">Connectez-vous pour accéder à la plateforme.</p>
        <a
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hover:cursor-pointer"
          href="/login"
          >Se connecter</a
        >
      </div>
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
import { apiUrl } from '@/composables/useApi'

const { isAuthenticated, removeToken } = useAuth()
const imageFormVisible = ref(false)

interface Image {
  id: number
  imageData: string
  user: string
  likes: number
  canUserLike: boolean
  dislikes: number
  canUserDislike: boolean
}

let userImages = ref<Image[] | undefined>([])
let allImages = ref<Image[] | undefined>([])

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
        userImages.value = data.userImages
        allImages.value = data.allImages
      }
    })
}

function handleDisplayImageForm(): void {
  imageFormVisible.value = !imageFormVisible.value
}

function closeForm() {
  imageFormVisible.value = false
}

async function handleLike(imageId: number) {
    let image = allImages.value.find((img) => img.id === imageId)
    if (!image) {
      image = userImages.value.find((img) => img.id === imageId)
    }
  
    if (image && image.canUserLike) {
      image.likes += 1
      image.canUserLike = false
  
      await fetch(apiUrl + 'image/' + imageId.toString() + '/like', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token.value}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          imageId: imageId,
        }),
      })
    }else if (image && !image.canUserLike){
      image.likes -= 1
      image.canUserLike = true
  
      await fetch(apiUrl + 'image/' + imageId.toString() + '/unlike', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token.value}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          imageId: imageId,
        }),
      })
    }
}

async function handleDislike(imageId: number) {
    let image = allImages.value.find((img) => img.id === imageId)
    if (!image) {
      image = userImages.value.find((img) => img.id === imageId)
    }
  
    if (image && image.canUserDislike) {
      image.dislikes += 1
      image.canUserDislike = false
  
      await fetch(apiUrl + 'image/' + imageId.toString() + '/dislike', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token.value}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          imageId: imageId,
        }),
      })
    }else if (image && !image.canUserDislike){
      image.dislikes -= 1
      image.canUserDislike = true
  
      await fetch(apiUrl + 'image/' + imageId.toString() + '/undislike', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token.value}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          imageId: imageId,
        }),
      })
    }
}
</script>
