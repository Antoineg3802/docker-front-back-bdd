<template>
  <div v-for="image in images" :key="image.id" class="bg-white rounded shadow overflow-hidden">
    <img :src="'data:image/png;base64, ' + image.imageData" class="w-full h-48 object-cover" />
    <div class="p-4">
      <div class="flex justify-between items-center">
        <button @click="likeImage(image.id)" class="text-green-600 hover:text-green-800">👍</button>
        <button @click="dislikeImage(image.id)" class="text-red-600 hover:text-red-800">👎</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">

interface Image {
  id: number
  imageData: string
}

defineProps<{
  images: Image[] | []
}>()

function likeImage(imageId: number) {
  console.log('likeImage')
}

function dislikeImage(imageId: number) {
  console.log('dislikeImage')
}
</script>
