import vue from '@vitejs/plugin-vue'
import ViteRestart from 'vite-plugin-restart';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import path from 'path';

// https://vitejs.dev/config/
export default ({ command }) => ({
  base: command === 'serve' ? '' : '/dist/',
  mode: 'development',
  build: {
    manifest: true,
    outDir: '../src/web/assets/dist',
    rollupOptions: {
      input: {
        input: '/src/js/input.ts',
        settings: '/src/js/settings.ts',
      },
      output: {
        sourcemap: true,
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
      },
    }
  },
  plugins: [
    nodeResolve({
      moduleDirectories: [
        path.resolve('./node_modules'),
      ],
    }),
    ViteRestart({
      reload: [
        '/src/**/*.vue',
        '/src/**/*.ts',
      ],
    }),
    vue(),
  ],
  publicDir: '../src/web/assets/public',
  resolve: {
    alias: {
      '@': '/src',
    },
    extensions: ['.ts', '.vue']
  },
  server: {
    host: '0.0.0.0',
    port: 3001,
    strictPort: true,
  }
});
