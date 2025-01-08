import { mount } from '@vue/test-utils';
import { describe, it, expect, vi } from 'vitest';
import Carrier from './Carrier.vue';
import Label from './Label.vue';

describe('Carrier.vue', () => {
  it('renders the correct carrier title', () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    // Check if the carrier title is rendered
    expect(wrapper.text()).toContain('Carrier Title');
  });

  it('renders the correct carrier image', () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    const img = wrapper.find('img');
    // Check if the image is rendered and has the correct src
    expect(img.exists()).toBe(true);
    expect(img.attributes('src')).toBe('/carriers/carrier-slug.png');
  });

  it('toggles accordion on click', async () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    const accordionContent = wrapper.find('.accordion-content');
    // Initially, the accordion should not be expanded
    expect(accordionContent.classes()).not.toContain('expanded');

    // Simulate a click to toggle the accordion
    await wrapper.find('.flex.items-center.justify-between').trigger('click');
    expect(accordionContent.classes()).toContain('expanded');
  });

  it('renders the correct number of incidents', () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [
        { incident_id: 1, title: 'Incident 1' },
        { incident_id: 2, title: 'Incident 2' },
      ],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
      global: {
        components: { Label }
      }
    });

    const incidents = wrapper.findAllComponents(Label);
    // Check if the correct number of incidents are rendered
    expect(incidents.length).toBe(2);
    expect(incidents[0].text()).toContain('Incident 1');
    expect(incidents[1].text()).toContain('Incident 2');
  });

  it('renders the correct number of services', () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [],
      services: [
        { service_id: 1, title: 'Service 1', status: 'active' },
        { service_id: 2, title: 'Service 2', status: 'inactive' },
      ],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    const services = wrapper.findAll('.flex.py-3.border-t');
    // Check if the correct number of services are rendered
    expect(services.length).toBe(2);
    expect(services[0].text()).toContain('Service 1');
    expect(services[1].text()).toContain('Service 2');
  });

  it('handles props correctly', () => {
    const carrier = {
      slug: 'carrier-slug',
      title: 'Carrier Title',
      status: 'active',
      incidents: [],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    // Check if the props are correctly passed to the component
    expect(wrapper.props().carrier).toEqual(carrier);
  });

  it('throws a warning if the `carrier` prop is not provided', () => {
    const consoleWarnSpy = vi.spyOn(console, 'warn').mockImplementation(() => {});

    // Mount the component without the `carrier` prop
    mount(Carrier as any, {
      props: {},
    });

    // Ensure a warning was called
    expect(consoleWarnSpy).toHaveBeenCalled();

    // Check that at least one warning contains the required prop message
    const warningMessages = consoleWarnSpy.mock.calls.map(call => call[0]);
    expect(warningMessages).toEqual(
      expect.arrayContaining([expect.stringContaining('[Vue warn]: Missing required prop: "carrier"')])
    );

    consoleWarnSpy.mockRestore();
  });

  it('renders correctly when the `carrier` prop is provided', () => {
    const carrier = {
      slug: 'test-carrier',
      title: 'Test Carrier',
      status: 'active',
      incidents: [],
      services: [],
    };

    const wrapper = mount(Carrier, {
      props: { carrier },
    });

    // Check if the props are correctly passed to the component
    expect(wrapper.props().carrier).toEqual(carrier);
  });
});