<template>
  <tr data-id="5" tabindex="0" :class="{ disabled: isSelected }">
    <th data-title="Title" data-titlecell="">
      <div
        @click="emitClick"
        data-image-width=""
        data-image-height=""
        data-own-file=""
        data-movable=""
        data-replaceable=""
        class="element small hasthumb"
        data-type="craft\elements\Asset"
        :data-id="$props.result.id"
        data-site-id="1"
        data-status="enabled"
        :data-label="filename"
        data-url=""
        data-level=""
        :title="filename"
        data-editable=""
      >
        <div
          class="elementthumb checkered"
          data-sizes="34px"
          :data-srcset="thumbnailSrcSet"
        >
          <img sizes="68px" :srcset="thumbnailSrcSet" alt="" />
        </div>
        <div class="label">
          <span class="title">{{ title }}</span>
        </div>
      </div>
    </th>
    <td data-title="Filename" data-attr="filename">
      <span class="break-word">{{ filename }}</span>
    </td>
    <td data-title="File Size" data-attr="size">
      <span :title="size">{{ size }}</span>
    </td>
    <td data-title="File Modified Date" data-attr="dateModified">
      <span :title="modifiedDate">{{ modifiedDate }}</span>
    </td>
    <td data-title="Link" data-attr="link"></td>
  </tr>
</template>

<script>
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import { bus } from '../bus';

dayjs.extend(utc);

export default {
  props: ['result', 'selected'],
  data: function() {
    return {
      isSelected: false,
    };
  },
  beforeMount() {
    this.isSelected = this.$props.selected;
  },
  computed: {
    title: function() {
      return this.result.title;
      // (
        // this.result.metadata.fields.assetTitle ||
        // this.result.filename
      // );
    },
    filename: function() {
      return this.result.filename;
    },
    size: function() {
      return 'N/A';
    },
    modifiedDate: function() {
      const date = dayjs(this.result.updatedDate);
      // this.result.last_update_date);
      return date.format('DD/MM/YYYY');
    },
    thumbnailSrcSet() {
      return `${this.result.thumbnailUrl} 68w`;
    },
  },
  methods: {
    emitClick: function(e) {
      e.preventDefault();
      console.log('emitClick::isSelected will be:' + (this.isSelected ? 'false' : 'true'));
      this.isSelected = !this.isSelected;

      bus.$emit('search-result-clicked', {
        root: this.$root._uid,
        value: this.result,
      });
    },
  }
};
</script>
