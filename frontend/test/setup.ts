import '@testing-library/jest-dom';

vi.mock('#app', () => ({
    useRuntimeConfig: vi.fn(() => ({
      apiBase: 'http://localhost:3000',
    })),
  }));


// Mock the Date object to a fixed date and time
const fixedDate = new Date('2023-10-01T14:00:00Z');
vi.useFakeTimers();
vi.setSystemTime(fixedDate);