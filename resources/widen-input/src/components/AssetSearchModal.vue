<template>
  <div class="elementselectormodal" style="padding: 1rem; max-height: 100%; position: absolute; top: 0; left:0; width: calc(100% - 2rem); height: 100%;">
    <!-- removed class modal -->
    <div class="body" style="width: 100%;">
      <div class="content">
        <div class="main" style="padding: 0 0 70px; margin: 0; height: calc(100% - 2rem);">
          <div class="toolbar" style="display: flex;">
            <div class="select">
              <select v-model="collection" @change="updateResults" :class="{disabled: !canChangeCollection }">
                <option disabled value="" v-if="collection === ''"
                  >Collections</option
                >
                <option v-if="collection !== ''" value=""
                  >All Collections</option
                >
                <option v-for="c in collections" :key="c.id" :value="c.title">{{
                  c.title
                }}</option>
              </select>
            </div>
            <div class="flex-grow texticon search icon clearable" style="margin-left: 10px;">
              <input
                type="text"
                class="text fullwidth"
                v-model="query"
                @keyup="assetSearch"
              />
            </div>
          </div>
          <AssetSearchTable :results="results" :selected="selected" />

          <div style="position: sticky; bottom: -2.5rem; left: 0; padding: 20px 15px; background-color: white; width: 100%; height: 70px;">
            <p style="font-weight: bold;">
              Selected resources are grayed out. To add more, click (once) on a resource until it is grayed out then click on the "Add Selected Resources" button.
            </p>
            <button class="btn submit" type="button" @click="toggleSearch">Add Selected Resources</button>
            <button class="btn" type="button" @click="toggleSearch">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash';
import { getCollections, search } from '../util';
import AssetSearchTable from './AssetSearchTable.vue';

export default {
  components: {
    AssetSearchTable,
  },
  props: ['values', 'searchOpen', 'selected', 'parentCollection', 'canChangeCollection', 'toggleSearch'],
  data: function() {
    return {
      query: '',
      collection: '',
      collections: [],
      results: [],
      // selected: [],
    };
  },
  methods: {
    assetSearch: _.debounce(async function(e) {
      const results = await search(this.query, {
        collection: this.collection || '',
      });
      this.results = results;
    }, 300),
    async updateResults() {
      this.results = await search(this.query, {
        collection: this.collection || '',
      });
    },
  },
  beforeMount: async function() {
    this.collection = this.$props.parentCollection;
    const promises = [
      // [collections, results] = [
      getCollections(),
      search(this.query, { collection: this.collection || '' }),
    ];
    Promise.allSettled(promises).then((results) => {
      results.forEach((result) => {
        if (result.status === 'rejected') {
          console.error('Promise Rejected', result.reason);
        }
      });
      this.collections = results[0].value;
      this.results = results[1].value;
    });
    // const collections = await getCollections();
    // const results = await search(this.query, { collection: this.collection || '' });
    // this.collections = collections;
    // this.results = results;
  },
};
</script>
