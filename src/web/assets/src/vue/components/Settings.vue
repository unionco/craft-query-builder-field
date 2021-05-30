<template>
  <div>
    This is Settings {{ JSON.stringify(categoryGoups)}}
    <ul>
      <li :key="group.handle" v-for="group in categoryGroups">
        {{ group.name }}
      </li>
    </ul>
    <ul>
      <li :key="channel.handle" v-for="channel in channels">
        {{ channel.name }}
      </li>
    </ul>
     <ul>
      <li :key="structure.handle" v-for="structure in structures">
        {{ structure.name }}
      </li>
    </ul>
    <!-- {{ $props}} -->
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export interface Element {
  id: string;
  handle: string;
  name: string;
}

export interface SettingsProps {
  categoryGroups?: Element[];
}

// function Settings(props, context) {

// }

export default defineComponent({
  // props: {
  //   categoryGroups: {
  //     type: Array,
  //     required: true,
  //   }
  // },
  // data() {
  //   return {
  //     categoryGroups:
  //   };
  // },
  setup(props, context) {
    const root = document.querySelector('[data-querybuilder-settings]');
    const categoryGroups = JSON.parse(root.dataset.categoryGroups);
    const channels = JSON.parse(root.dataset.channels);
    const structures = JSON.parse(root.dataset.structures);
    // console.log('settings setup', props, context);
    // const { categoryGroups } = toRefs(props);
    console.log('props: categoryGoups', categoryGroups);

    return {
      categoryGroups,
      channels,
      structures,
    };
  },
  mounted() {
    console.log('mounted');
  }
});
</script>
