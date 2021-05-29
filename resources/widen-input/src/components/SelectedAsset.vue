<template>
  <div class="element small hasthumb removable">
          <!-- class="element small hasthumb removable" -->
    <div
      data-id="5"
      data-site-id="1"
      data-status="enabled"
      :data-label="asset.filename"
      data-url=""
      data-level=""
      :title="asset.filename"
      data-editable=""
      tabindex="0"
      style="visibility: visible"
    >
      <a
        class="delete icon"
        title="Remove"
        @click="emitRemoveAsset"
      ></a>
      <div
        class="elementthumb checkered"
        data-sizes="34px"
        :data-srcset="thumbnailSrcSet"
      >
        <img
          sizes="68px"
          :srcset="thumbnailSrcSet"
          alt=""
        />
      </div>
    </div>
    <div class="label">
      <span class="title">{{ title}} [{{ asset.filename }}]</span>
    </div>
  </div>
</template>

<script>
import { bus } from '../bus';

export default {
  props: ['asset'],
  data: function () {
    return {
      test: true,
    };
  },
  computed: {
    title() {
      try {
        return this.$props.asset.metadata.fields.assetTitle[0];
      } catch (e){
        return '';
      }
    },
    thumbnailSrcSet() {
      // return '';
      const embeds = this.$props.asset.embeds;
      const keys = Object.keys(embeds);
      if (keys.includes('document_thumbnail')) {
        return `${this.$props.asset.embeds.document_thumbnail.url} 68w`;
      }

      const first = embeds[keys[0]].url;
      return `${first} 68w`;
    },
  },
  // beforeMount() {
    // console.log(JSON.stringify(this.$props.asset.embeds.document_thumbnail.url, null, 2));
  // },
  methods: {
    emitRemoveAsset(e) {
      e.preventDefault();
      bus.$emit('remove-asset', {
        root: this.$root._uid,
        value: this.$props.asset,
      });
    },
  },
};
</script>
