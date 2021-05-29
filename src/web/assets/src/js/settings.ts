import Settings from '@/vue/components/Settings.vue';
import { createApp } from 'vue';

// App main
const main = async () => {
    console.log('Settings main!!!');
    // Create our vue instance
    const app = createApp(Settings);
    // Mount the app
    const root = app.mount('[data-querybuilder-settings]');
    return root;
};

// Execute async function
main().then( (root) => {
});
