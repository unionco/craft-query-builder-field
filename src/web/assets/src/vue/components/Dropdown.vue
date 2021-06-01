<template>
  <div class="select">
    <select
      v-if="options"
      :id="id('input')"
      :name="name"
      :aria-describedby="id('instructions')"
    >
      <option
        v-for="option in options"
        :value="option.id"
        :key="option.handle"
      >
        {{option.name}}
      </option>
    </select>
  </div>
</template>
<script lang="ts">
import { defineComponent, toRef } from 'vue';

export default defineComponent({
  props: {
    name: {
      type: String,
      required: true,
    },
    options: {
      type: Array,
      required: true,
    }
  },
  setup(props) {
    const name = toRef(props, 'name');
    const options = toRef(props, 'options');
    console.log('[Dropdown]::setup', options.value);
    return {
      name,
      options,
    };
  },
  methods: {
    id(selector: string) {
      const nameProp = this.name;
      if (!nameProp) {
        throw new Error('[Dropdown]name.value is empty');
      }
      switch (selector) {
        case 'input':
          return nameProp;
        case 'instructions':
          return nameProp + '-instructions';
      }
    },
  },
});
</script>
