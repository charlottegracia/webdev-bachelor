import { defineConfig } from 'vitest/config';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
        '~': resolve(__dirname, './'), 
        '@': resolve(__dirname, './'), 
        '#app': resolve(__dirname, '.nuxt/app'), 
    },
  },
  test: {
    globals: true,
    environment: 'jsdom',
    setupFiles: ['./test/setup.ts'], 
    include: ['**/*.test.ts', '**/*.test.tsx', '**/*.spec.ts', '**/*.spec.tsx'],
    coverage: {
      reporter: ['text', 'json', 'html'],
    },
  },
});
