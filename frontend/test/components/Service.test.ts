import { mount } from '@vue/test-utils';
import Service from '../../components/Service.vue';
import Label from '../../components/Label.vue';
import Status from '../../components/Status.vue';
import Icon from '../../components/Icon.vue';
import Tooltip from '../../components/Tooltip.vue';

const mockService = {
    description: 'Test Service',
    status: 'operational',
    incidents: [
        {
            incident_id: 1,
            title: 'Test Incident 1',
            message: 'Test message 1',
            country: 'Denmark',
            status: 'resolved',
            created_at: '2023-09-30T12:00:00Z',
            updated_at: '2023-10-01T12:00:00Z',
            resolved_at: '2023-10-01T12:00:00Z',
            expected_resolved_at: '2023-10-01T14:00:00Z',
            critical: 1,
            type: 'network',
            services: [],
            carrier: 'CarrierName'
        },
        {
            incident_id: 2,
            title: 'Test Incident 2',
            message: 'Test message 2',
            country: 'Denmark',
            status: 'resolved',
            created_at: '2023-09-30T12:00:00Z',
            updated_at: '2023-10-01T12:00:00Z',
            resolved_at: '2023-10-01T12:00:00Z',
            expected_resolved_at: '2023-10-01T14:00:00Z',
            critical: 1,
            type: 'network',
            services: [],
            carrier: 'CarrierName'
        }
    ],
    services: [
        {
            service_id: 1,
            title: 'Nested Service 1',
            status: 'operational'
        },
        {
            service_id: 2,
            title: 'Nested Service 2',
            status: 'operational'
        }
    ]
};

describe('Service.vue', () => {
    it('renders correctly', () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        expect(wrapper.exists()).toBe(true);
    });

    it('displays the service description correctly', () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        expect(wrapper.text()).toContain('Test Service');
    });

    it('displays the status component correctly', () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        expect(wrapper.findComponent(Status).exists()).toBe(true);
    });

    it('displays the incidents correctly', () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        expect(wrapper.findAllComponents(Label).length).toBe(2);
    });

    it('toggles the accordion correctly', async () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        const accordionContent = wrapper.find('.accordion-content');
        expect(accordionContent.classes()).not.toContain('expanded');
        await wrapper.find('.flex.items-center.justify-between').trigger('click');
        expect(accordionContent.classes()).toContain('expanded');
    });

    it('displays the nested services correctly', () => {
        const wrapper = mount(Service, {
            props: { service: mockService },
            global: {
                components: { Label, Status, Icon, Tooltip }
            }
        });
        expect(wrapper.findAll('.accordion-content .flex.py-3').length).toBe(2);
    });
});