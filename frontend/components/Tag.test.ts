import { mount } from '@vue/test-utils';
import Tag from './Tag.vue';

describe('Tag.vue', () => {
    it('renders correctly', () => {
        const wrapper = mount(Tag, {
            props: { text: 'Test Tag', type: 'country' }
        });
        expect(wrapper.exists()).toBe(true);
    });

    it('applies the correct classes for country type', () => {
        const wrapper = mount(Tag, {
            props: { text: 'Test Tag', type: 'country' }
        });
        expect(wrapper.classes()).toContain('bg-home-kiwi');
        expect(wrapper.classes()).toContain('text-home-kiwi-300');
    });

    it('applies the correct classes for carrier type', () => {
        const wrapper = mount(Tag, {
            props: { text: 'Test Tag', type: 'carrier' }
        });
        expect(wrapper.classes()).toContain('bg-home-tangerine');
        expect(wrapper.classes()).toContain('text-home-tangerine-300');
    });

    it('applies the correct classes for service type', () => {
        const wrapper = mount(Tag, {
            props: { text: 'Test Tag', type: 'service' }
        });
        expect(wrapper.classes()).toContain('bg-home-grape');
        expect(wrapper.classes()).toContain('text-home-grape-300');
    });
});