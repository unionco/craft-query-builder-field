import { createApp } from 'vue';
import Input from '@/vue/components/Input.vue';
// Import our CSS
import '@/css/app.pcss';

console.log('app.ts');
const main = async () => {
      console.log('input main');
      // Create our vue instance
      const app = createApp(Input);
      // Mount the app
      const root = app.mount('[data-querybuilder-settings]');

      return root;
};

main().then( (root) => {
});
