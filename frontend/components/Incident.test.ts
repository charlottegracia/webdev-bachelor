import { mount } from '@vue/test-utils';
import Incident from './Incident.vue';
import Tag from './Tag.vue';

describe('Incident.vue', () => {
  const incident = {
    incident_id: 1,
    title: 'Test Incident',
    message: 'This is a test incident message.',
    country: 'DK,SE',
    status: 'open',
    created_at: '2023-10-01T12:00:00Z',
    updated_at: '2023-10-01T12:00:00Z',
    critical: 1,
    type: 'service',
    services: [
      { id: 1, title: 'Service 1', description: 'Service 1 Description' },
      { id: 2, title: 'Service 2', description: 'Service 2 Description' },
    ],
    carriers: [
      { carrier_id: 1, title: 'Carrier 1' },
      { carrier_id: 2, title: 'Carrier 2' },
    ],
  };

  it('renders the incident title', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    expect(wrapper.find('h2').text()).toBe('Test Incident');
  });

  it('renders the incident message', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    expect(wrapper.find('p.mt-2').text()).toBe('This is a test incident message.');
  });

  it('renders the formatted creation date', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    const formattedDate = wrapper.find('.text-homeblue-300').text();
    expect(formattedDate).toMatch(/01\. oktober 2023 14[:.]00/);
  });

  it('renders the correct number of country tags', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    const countryTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'country');
    expect(countryTags.length).toBe(2);
  });

  it('renders the correct number of carrier tags', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    const carrierTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'carrier');
    expect(carrierTags.length).toBe(2);
  });

  it('renders the correct number of service tags', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    const serviceTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'service');
    expect(serviceTags.length).toBe(2);
  });

  it('renders the correct country names', () => {
    const wrapper = mount(Incident, {
      props: { incident },
      global: {
        components: { Tag }
      }
    });
    const countryTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'country');
    expect(countryTags.at(0)?.text()).toBe('Danmark');
    expect(countryTags.at(1)?.text()).toBe('Sverige');
  });
});