import Vue from 'vue';
import VModal from 'vue-js-modal';
// import { bus } from './bus';
import WidenAssetInput from './components/WidenAssetInput.vue';
import SelectedAsset from './components/SelectedAsset.vue';
import 'core-js/stable';
import 'regenerator-runtime/runtime';

Vue.use(VModal);
Vue.component('widen-asset-input', WidenAssetInput);
Vue.component('selected-asset', SelectedAsset);

window.widenAssetInput = function(id) {
  new Vue({ // eslint-disable-line no-new
    el: id,
    components: {
      'widen-asset-input': WidenAssetInput,
      'selected-asset': SelectedAsset,
    },
  });
};
