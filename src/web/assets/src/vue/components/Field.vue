<template>
  <div :id="id('parent')" :class="classname">
    <div class="heading">
      <label :id="id('label')" :for="id('input')">{{label}}</label>
    </div>
    <div :id="id('instructions')">
      <p v-if="hasInstructions">{instructions}</p>
    </div>
    <div class="input ltr">
      <slot></slot>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, toRef, toRefs } from 'vue';

export default defineComponent({
  props: {
    instructions: {
      type: String,
      required: false,
    },
    name: {
      type: String,
      required: true,
    },
  },
  setup(props, { attrs, slots, emit }) {
    console.log('Field::setup', toRefs(props), { attrs, slots, emit })
    const name = toRef(props, 'name');
    const instructions = toRef(props, 'instructions');

    return {
      name,
      instructions,
    };
  },
  methods: {
    id(selector: string) {
      const nameProp = this.name;
      if (!nameProp) {
        throw new Error('[Field] name.value is empty');
      }
      switch (selector) {
        case 'parent':
          return (nameProp) + '-field';
        case 'label':
          return (nameProp) + '-label';
        case 'input':
          return (nameProp);
        case 'instructions':
          return (nameProp) + '-instructions';
        default:
          return 'na';
      }
    }
  }
})
</script>
