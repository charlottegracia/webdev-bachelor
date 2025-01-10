import { mount } from '@vue/test-utils';
import InputField from '../../components/InputField.vue';

describe('InputField.vue', () => {
    it('renders correctly', () => {
        const wrapper = mount(InputField);
        expect(wrapper.exists()).toBe(true);
    });

    it('displays the label when provided', () => {
        const label = 'Test Label';
        const wrapper = mount(InputField, {
            props: { label }
        });
        expect(wrapper.find('label').text()).toBe(label);
    });

    it('displays input field when type is not textarea', () => {
        const wrapper = mount(InputField, {
            props: { type: 'text' }
        });
        expect(wrapper.find('input').exists()).toBe(true);
        expect(wrapper.find('textarea').exists()).toBe(false);
    });

    it('displays textarea when type is textarea', () => {
        const wrapper = mount(InputField, {
            props: { type: 'textarea' }
        });
        expect(wrapper.find('textarea').exists()).toBe(true);
        expect(wrapper.find('input').exists()).toBe(false);
    });

    it('displays the placeholder correctly', () => {
        const placeholder = 'Enter text';
        const wrapper = mount(InputField, {
            props: { placeholder }
        });
        expect(wrapper.find('input').attributes('placeholder')).toBe(placeholder);
    });

    it('updates modelValue correctly', async () => {
        const wrapper = mount(InputField, {
            props: { modelValue: '' }
        });
        const input = wrapper.find('input');
        await input.setValue('new value');
        expect(wrapper.emitted()['update:modelValue'][0]).toEqual(['new value']);
    });

    it('sanitizes input correctly', async () => {
        const wrapper = mount(InputField, {
            props: { modelValue: '' }
        });
        const input = wrapper.find('input');
        await input.setValue('<script>alert("xss")</script>');
        expect(wrapper.emitted()['update:modelValue'][0]).toEqual(['']);
    });
});