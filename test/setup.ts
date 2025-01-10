import { advanceTo, clear } from 'jest-date-mock';

beforeAll(() => {
	advanceTo(new Date('2023-10-01T14:00:00Z'));
});

afterAll(() => {
	clear();
});