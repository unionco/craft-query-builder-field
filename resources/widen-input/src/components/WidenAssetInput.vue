<template>
  <div class="Widen-input">
    <input type="hidden" :name="name" :value="serializedValues" />
    <draggable
      class="elements"
      v-if="values"
      style="display: flex; flex-direction: column; margin-bottom: 10px; margin-top: 10px;"
      :list="values"
      @start="startDrag"
      @end="stopDrag"
    >
      <!-- <div v-if="values"> -->
      <SelectedAsset :key="v.id" v-for="v in values" :asset="v" />
      <!-- </div> -->
    </draggable>
    <modal
      :name="modalName"
      :draggable="true"
      :adaptive="true"
      width="80%"
      height="100%"
    >
      <AssetSearchModal :selected="values" :can-change-collection="!$props.fieldCollection.length" :parent-collection="collection" :toggleSearch="toggleSearch"/>
    </modal>
    <button
      type="button"
      :class="{
        btn: true,
        add: true,
        icon: true,
        dashed: true,
        disabled: !allowMore,
      }"
      tabindex="0"
      @click="toggleSearch"
    >
      Add an asset
    </button>
    <hr />
  </div>
</template>

<script>
import draggable from 'vuedraggable';
import { assetEnabled, assetStoredValues } from '../util';
import { bus } from '../bus';
import SelectedAsset from './SelectedAsset.vue';
import AssetSearchModal from './AssetSearchModal.vue';

export default {
  components: {
    AssetSearchModal,
    SelectedAsset,
    draggable,
  },
  props: ['value', 'name', 'limit', 'fieldCollection'],
  computed: {
    allowMore: function() {
      if (!this.values || !this.$props.limit) {
        return true;
      }
      return this.values.length < this.limit;
    },
    assetHiddenFieldName: function() {
      return this.$props.name;
    },
    modalName: function() {
      return `asset-modal-${this.$props.name}`;
    },
    serializedValues: function() {
      return JSON.stringify(this.values);
    },
    count: function() {
      return this.values.length;
    },
    displayLimit: function() {
      if (this.$props.limit) {
        return this.$props.limit;
      }
      return 'inf';
    },
  },
  data: function() {
    // console.log('widen-asset-input (data)');
    return {
      query: '',
      dragging: false,
      values: [],
      searchOpen: false,
      results: [],
      collection: null,
    };
  },
  beforeMount: function() {
    const propCollection = this.$props.fieldCollection;
    this.collection = propCollection;

    try {
      if (!this.values || !this.values.length) {
        // console.log(this);
        let propValue;
        if (!this.value) {
          console.log('WidenAssetInput::beforeMount - Warning - this.value is falsey');
          propValue = [];
        } else {
          try {
           propValue = JSON.parse(this.value);
          } catch (e) {
            console.error('WidenAssetInput::beforeMount', e);
            propValue = [];
          }
        }
        // console.log(propValue);
        this.values = propValue;
      }
    } catch (e) {
      console.error(e);
      this.values = [];
    }
  },
  mounted() {
    bus.$on('search-result-clicked', this.handleSearchResultClicked);
    bus.$on('remove-asset', this.handleRemoveAsset);
  },
  methods: {
    toggleSearch: function(e) {
      console.log('WidenAssetInput::toggleSearch', this.searchOpen, e);
      e.preventDefault();

      if (!this.allowMore) {
        if (this.searchOpen) {
          console.log('WidenAssetInput::toggleSearch - Closing modal');
          this.$modal.hide(this.modalName);
        }
        return;
      }
      this.searchOpen
        ? this.$modal.hide(this.modalName)
        : this.$modal.show(this.modalName);
      this.searchOpen = !this.searchOpen;
    },
    startDrag() {
      this.dragging = true;
      console.log('dragging');
    },
    stopDrag() {
      this.dragging = false;
      console.log('stopped');
    },
    handleSearchResultClicked(event) {
      // this.toggleAssetEnabled(event.value.id, event.value);
      // console.log('clicked', event);
      const { root, value } = event;
      if (root !== this.$root._uid) {
        // console.log('root does not match, skipping');
        return;
      }
      // Ignore if the limit is reached
      if (!this.allowMore) {
        console.log('Limit reached');
        return;
      }
      const asset = value;
      if (assetEnabled(this.values, asset)) {
        this.values = this.values.filter((value) => value.id !== asset.id);
        console.log('removed asset from values');
        return;
      }
      console.log('adding search result to values', asset.rawData);
      if (!this.values) {
        this.values = [asset.rawData];
      } else {
        const tempValues = this.values;
        tempValues.push(asset.rawData);
        this.values = tempValues;
      }
      // this.values = [...this.values, asset.rawData];
    },
    /**
     * Handle events from SelectedAsset to remove the asset from the field's value
     **/
    handleRemoveAsset(event) {

      const { root, value } = event;
      // if (root !== this.$root._uid) {
      //   console.log('root does not match, skipping', {
      //     root: root,
      //     me: this.$root._uid,
      //   });
      //   return;
      // }
      console.log('handleRemoveAsset - filter success');
      const assetId = value.id;
      this.values = this.values.filter((value) => value.id !== assetId);
    },

    toggleAssetEnabled: function(assetId, data = {}) {
      if (assetEnabled(this.values, assetId)) {
        this.values = this.values.filter((value) => value.id !== assetId);
        return;
      }
      this.values.push(data.rawData);
    },
    serialize: function(obj) {
      return JSON.stringify(obj);
    },
  },
};
</script>
