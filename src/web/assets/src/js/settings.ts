import Settings from '@/vue/components/Settings.vue';
import { createApp } from 'vue';

const selector = '[data-querybuilder-settings]';
// App main
const main = async () => {
    console.log('Settings main');
    // Create our vue instance
    const app = createApp(Settings);
    // const categoryGroups = el.data.categoryGroups;
    // Mount the app
    const root = app.mount(selector);
    return root;
};


// Execute async function
main().then( (root) => {
    console.log('async settings?');
});
