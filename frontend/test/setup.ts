import '@testing-library/jest-dom';

vi.mock('#app', () => ({
    useRuntimeConfig: vi.fn(() => ({
      apiBase: 'http://localhost:3000',
    })),
  }));


process.env.TZ = 'UTC';