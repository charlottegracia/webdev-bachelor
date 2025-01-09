import { mount } from '@vue/test-utils';
import Status from './Status.vue';

describe('Status.vue', () => {
    it('renders correctly', () => {
        const wrapper = mount(Status, {
            props: { status: 'green' }
        });
        expect(wrapper.exists()).toBe(true);
    });

    it('applies the correct class for green status', () => {
        const wrapper = mount(Status, {
            props: { status: 'green' }
        });
        expect(wrapper.find('.w-3.h-3.rounded-full').classes()).toContain('bg-[#3CC834]');
    });

    it('applies the correct class for yellow status', () => {
        const wrapper = mount(Status, {
            props: { status: 'yellow' }
        });
        expect(wrapper.find('.w-3.h-3.rounded-full').classes()).toContain('bg-[#F2CB3D]');
    });

    it('applies the correct class for red status', () => {
        const wrapper = mount(Status, {
            props: { status: 'red' }
        });
        expect(wrapper.find('.w-3.h-3.rounded-full').classes()).toContain('bg-[#E16262]');
    });

    it('applies the default class for unknown status', () => {
        const wrapper = mount(Status, {
            props: { status: 'unknown' }
        });
        expect(wrapper.find('.w-3.h-3.rounded-full').classes()).toContain('bg-gray-400');
    });
});