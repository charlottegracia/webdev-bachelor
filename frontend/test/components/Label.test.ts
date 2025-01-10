import { mount } from "@vue/test-utils";
import Label from "../../components/Label.vue";
import type { Incident } from "~/types.ts";

const mockIncident: Incident = {
  incident_id: 1,
  title: "Test Incident",
  message: "Test message",
  country: "Denmark",
  status: "resolved",
  created_at: "2023-09-30T12:00:00Z",
  updated_at: "2023-10-01T12:00:00Z",
  resolved_at: "2023-10-01T12:00:00Z",
  expected_resolved_at: "2023-10-01T14:00:00Z",
  critical: 1,
  type: "network",
  services: [
    {
      service_id: 1,
      title: "Service 1",
      description: "Service 1 Description",
      status: "active",
      created_at: "2023-10-01T12:00:00Z",
      updated_at: "2023-10-01T12:00:00Z",
    },
    {
      service_id: 2,
      title: "Service 2",
      description: "Service 2 Description",
      status: "active",
      created_at: "2023-10-01T12:00:00Z",
      updated_at: "2023-10-01T12:00:00Z",
    },
  ],
  carriers: [
    {
      carrier_id: 1,
      title: "Carrier 1",
      slug: "carrier-1",
      type: "type1",
      description: "Description 1",
      status: "active",
      created_at: "2023-10-01T12:00:00Z",
      updated_at: "2023-10-01T12:00:00Z",
      peak_up_charge: "10",
    },
    {
      carrier_id: 2,
      title: "Carrier 2",
      slug: "carrier-2",
      type: "type2",
      description: "Description 2",
      status: "active",
      created_at: "2023-10-01T12:00:00Z",
      updated_at: "2023-10-01T12:00:00Z",
      peak_up_charge: "20",
    },
  ],
};

describe("Label.vue", () => {
  beforeAll(() => {
    // Mock the Date object to a fixed date and time
    const fixedDate = new Date('2023-10-01T14:00:00Z');
    vi.useFakeTimers();
    vi.setSystemTime(fixedDate);
  });

  afterAll(() => {
    // Restore the original timers
    vi.useRealTimers();
  });

  it("renders correctly", () => {
    const wrapper = mount(Label, {
      props: {
        type: "date",
        incident: mockIncident,
      },
    });
    expect(wrapper.exists()).toBe(true);
  });

  it("displays the date correctly when type is date", () => {
    const wrapper = mount(Label, {
      props: {
        type: "date",
        incident: mockIncident,
      },
    });
    expect(wrapper.text()).toContain(
      "Problemet er løst 01. oktober 2023 14.00"
    );
  });

  it("displays the link correctly when type is link", () => {
    const wrapper = mount(Label, {
      props: {
        type: "link",
        incident: mockIncident,
      },
    });
    expect(wrapper.find("a").exists()).toBe(true);
    expect(wrapper.find("a").text()).toContain("Test Incident");
  });

  it("applies size classes correctly", () => {
    const wrapper = mount(Label, {
      props: {
        type: "link",
        incident: mockIncident,
        size: "lg",
      },
    });
    expect(wrapper.find(".py-3.px-4.rounded-xl").exists()).toBe(true);
  });

  it("applies color classes correctly", () => {
    const wrapper = mount(Label, {
      props: {
        type: "date",
        incident: mockIncident,
      },
    });
    expect(wrapper.find(".bg-homeblue-300.text-white").exists()).toBe(true);
  });

  it("formats the date correctly", () => {
    const wrapper = mount(Label, {
      props: {
        type: "date",
        incident: mockIncident,
      },
    });
    expect(wrapper.text()).toContain("01. oktober 2023 14.00");
  });
});