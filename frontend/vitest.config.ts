import { defineConfig } from 'vitest/config';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import { isFunctionOrConstructorTypeNode } from 'typescript';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
        '~': resolve(__dirname, './'), // Points to the root of the frontend directory
        '@': resolve(__dirname, './'), // Alternative alias for root
        '#app': resolve(__dirname, './'), // Correctly points to the root of the frontend directory
    },
  },
  test: {
    globals: true,
    environment: 'jsdom',
    setupFiles: ['./test/setup.ts'], // Optional: for mocking global utilities
    include: ['**/*.test.ts', '**/*.test.tsx', '**/*.spec.ts', '**/*.spec.tsx'],
    coverage: {
      reporter: ['text', 'json', 'html'],
    },
  },
});


console.log('~ resolves to:', resolve(__dirname, './'));
console.log('#app resolves to:', resolve(__dirname, '.nuxt/app'));

