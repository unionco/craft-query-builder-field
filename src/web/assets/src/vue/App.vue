<template>
    <confetti></confetti>
</template>

<script lang="ts">
// Async load the Vue 3 APIs we need from the Vue ESM
import {defineAsyncComponent, defineComponent } from 'vue';
import Settings from '@/vue/components/Settings.vue';
import Input from '@/vue/components/Input.vue';
// import Confetti from '@/vue/Confetti.vue';
export default defineComponent({
  components: {
    'settings': Settings,
    'input': Input,
  },
  data: () => ({
  }),
  methods: {
  },
  mounted() {
  },
});
</script>
