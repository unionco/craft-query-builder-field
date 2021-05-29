<template>
  <!-- <div class="search-results">
      <div v-if="results">
        <div
          v-for="result in results"
          :key="result.id"
          :data-id="result.id"
          :class="{
            'search-result': true,
            active: assetEnabled(values, result.id),
          }"
          @click="() => toggleAssetEnabled(result.id, result)"
        >
          {{ result.filename }}|{{ result.last_update_date }}
        </div>
      </div>
    </div> -->
  <div class="elements">
    <div class="tableview" style="overflow-y: auto;">
      <table class="data fullwidth">
        <thead>
          <tr>
            <th scope="col" data-attribute="title" class="orderable">
              Title
            </th>
            <th scope="col" data-attribute="filename" class="orderable">
              Filename
            </th>
            <th scope="col" data-attribute="size" class="orderable">
              File Size
            </th>
            <th scope="col" data-attribute="dateModified" class="orderable">
              File Modified Date
            </th>
            <th
              scope="col"
              data-attribute="link"
              data-icon="world"
              title="Link"
            ></th>
          </tr>
        </thead>
        <tbody>
          <AssetSearchTableRow v-for="result in results" :key="result.id" :result="result" :selected="assetSelected(result.id)"/>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import AssetSearchTableRow from './AssetSearchTableRow.vue';

export default {
  components: {
    AssetSearchTableRow,
  },
  props: ['results', 'selected'],
  data: function() {
    return {
      reactiveSelected: this.$props.selected || []
    };
  },
  methods: {
    assetSelected: function (assetId) {
      if (!this.reactiveSelected) {
        return false;
      }
      return this.reactiveSelected.map(asset => asset.id).includes(assetId);
    }
  }
};
</script>
