<template>
  <div v-for="(image, key) in images" :key="image.id" class="bg-white rounded shadow overflow-hidden">
    <img :src="'data:image/png;base64, ' + image.imageData" class="w-full h-48 object-cover" />
    <div class="p-4">
      <div class="flex justify-between items-center">
        <button
          @click="emitLike(image.id)"
          class="text-green-600 hover:text-green-800 hover:cursor-pointer"
        >
          👍 {{ image.likes }}
        </button>
        <button
          @click="emitDislike(image.id)"
          class="text-red-600 hover:text-red-800 hover:cursor-pointer"
        >
          👎 {{ image.dislikes }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { toRef } from 'vue'

interface Image {
  id: number
  imageData: string
  likes: number
  dislikes: number
}

let props = defineProps<{
  images: Image[] | undefined
}>()

let images = toRef(props, 'images')

const emit = defineEmits<{
  (e: 'like', imageId: number): void
  (e: 'dislike', imageId: number): void
}>()

function emitLike(imageId: number) {
  emit('like', imageId)
}

function emitDislike(imageId: number) {
  emit('dislike', imageId)
}
</script>
