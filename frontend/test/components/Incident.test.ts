import { mount } from '@vue/test-utils';
import { describe, it, expect, vi } from 'vitest';
import Incident from '../../components/Incident.vue';
import Tag from '../../components/Tag.vue';
import type { Incident as IncidentType } from '~/types';
import { ref } from 'vue';

// Mock the useIncidents composable
vi.mock('@/composables/useIncidents', () => ({
  useIncidents: () => ({
    incidents: [],
    fetchIncidents: vi.fn(),
    resolveIncident: vi.fn(),
    deleteIncident: vi.fn(),
    postIncident: vi.fn(),
  }),
}));

// Mock the useCountries composable with reactive countries
vi.mock('@/composables/useCountries', () => ({
  useCountries: () => ({
    countries: ref([
      { code: 'DK', name: 'Danmark' },
      { code: 'SE', name: 'Sverige' },
    ]),
  }),
}));

describe('Incident.vue', () => {
  const incident: IncidentType = {
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
      { service_id: 1, title: 'Service 1', description: 'Service 1 Description', status: 'active', created_at: '2023-10-01T12:00:00Z', updated_at: '2023-10-01T12:00:00Z' },
      { service_id: 2, title: 'Service 2', description: 'Service 2 Description', status: 'active', created_at: '2023-10-01T12:00:00Z', updated_at: '2023-10-01T12:00:00Z' },
    ],
    carriers: [
      { carrier_id: 1, title: 'Carrier 1', slug: 'carrier-1', type: 'type1', description: 'Description 1', status: 'active', created_at: '2023-10-01T12:00:00Z', updated_at: '2023-10-01T12:00:00Z', peak_up_charge: '10' },
      { carrier_id: 2, title: 'Carrier 2', slug: 'carrier-2', type: 'type2', description: 'Description 2', status: 'active', created_at: '2023-10-01T12:00:00Z', updated_at: '2023-10-01T12:00:00Z', peak_up_charge: '20' },
    ],
  };

  it('renders the incident title', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    expect(wrapper.find('h2').text()).toBe('Test Incident');
  });

  it('renders the incident message', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const incidentMessage = wrapper.find('p.incident-message');
    expect(incidentMessage.text()).toBe('This is a test incident message.');
  });

  it('renders the formatted creation date', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const formattedDate = wrapper.find('.text-homeblue-300').text();
    expect(formattedDate).toMatch(/01\. oktober 2023 14[:.]00/);
  });

  it('renders the correct number of country tags', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const countryTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'country');
    expect(countryTags.length).toBe(2);
  });

  it('renders the correct number of carrier tags', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const carrierTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'carrier');
    expect(carrierTags.length).toBe(2);
  });

  it('renders the correct number of service tags', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const serviceTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'service');
    expect(serviceTags.length).toBe(2);
  });

  it('renders the correct country names', () => {
    const wrapper = mount(Incident, {
      props: { incident, editAllowed: true },
      global: {
        components: { Tag }
      }
    });
    const countryTags = wrapper.findAllComponents(Tag).filter(tag => tag.props('type') === 'country');
    expect(countryTags.at(0)?.text()).toBe('Danmark');
    expect(countryTags.at(1)?.text()).toBe('Sverige');
  });
});