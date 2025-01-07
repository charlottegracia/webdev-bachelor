import { mount } from '@vue/test-utils';
import Icon from './Icon.vue';
import { PhTruck, PhGlobeHemisphereWest, PhArrowRight } from '@phosphor-icons/vue/compact';

describe('Icon.vue', () => {
  it('renders the correct icon component based on the src prop', () => {
    const wrapper = mount(Icon, {
      props: {
        src: 'truck'
      }
    });
    expect(wrapper.findComponent(PhTruck).exists()).toBe(true);
  });

  it('applies the correct size class based on the size prop', () => {
    const wrapper = mount(Icon, {
      props: {
        size: 'lg',
        src: 'truck'
      }
    });
    expect(wrapper.find('.text-lg').exists()).toBe(true);
  });

  it('applies the correct color class based on the color prop', () => {
    const wrapper = mount(Icon, {
      props: {
        color: 'text-red-500',
        src: 'truck'
      }
    });
    expect(wrapper.find('.text-red-500').exists()).toBe(true);
  });

  it('applies the correct inline style based on the color prop', () => {
    const wrapper = mount(Icon, {
      props: {
        color: '#ff0000',
        src: 'truck'
      }
    });
    expect(wrapper.find('.icon').attributes('style')).toContain('color: rgb(255, 0, 0);');
  });

  it('renders nothing if the src prop does not match any icon', () => {
    const wrapper = mount(Icon, {
      props: {
        src: 'nonexistenticon'
      }
    });
    expect(wrapper.html()).toContain('<!--v-if-->');
  });

  it('renders the correct icon component for different src props', async () => {
    const wrapper = mount(Icon, {
      props: {
        src: 'globeHemisphereWest'
      }
    });
    expect(wrapper.findComponent(PhGlobeHemisphereWest).exists()).toBe(true);

    await wrapper.setProps({ src: 'arrowRight' });
    expect(wrapper.findComponent(PhArrowRight).exists()).toBe(true);
  });
});