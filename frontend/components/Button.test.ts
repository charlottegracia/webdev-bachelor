import { mount } from "@vue/test-utils";
import Button from "./Button.vue"; 

describe("Button.vue", () => {
  it("renders the correct text when passed as a prop", () => {
    const text = "Click Me";
    const wrapper = mount(Button, {
      props: { text },
    });

    // Check if the button contains the correct text
    expect(wrapper.text()).toBe(text);
  });
});

describe('Button.vue', () => {
  it('throws a warning if the `text` prop is not provided', () => {
    const consoleWarnSpy = vi.spyOn(console, 'warn').mockImplementation(() => {});

    mount(Button, {
      props: {}, 
    });

    // Ensure a warning was called
    expect(consoleWarnSpy).toHaveBeenCalledTimes(1);

    // Check that the warning contains the required prop message
    expect(consoleWarnSpy.mock.calls[0][0]).toEqual(
      expect.stringContaining('[Vue warn]: Missing required prop: "text"')
    );

    consoleWarnSpy.mockRestore();
  });
});

describe("Button.vue", () => {
  it("has the correct classes applied", () => {
    const wrapper = mount(Button, {
      props: { text: "Click Me" },
    });

    // Check if the button has the expected classes
    expect(wrapper.classes()).toContain("bg-homeblue-100");
    expect(wrapper.classes()).toContain("text-white");
    expect(wrapper.classes()).toContain("hover:bg-white");
  });
});

describe("Button.vue", () => {
  it("emits a click event when clicked (if click handler is added)", async () => {
    const wrapper = mount(Button, {
      props: { text: "Click Me" },
    });

    await wrapper.trigger("click");

    // Check if the click event has been emitted by testing for a click handler
    expect(wrapper.emitted()).toHaveProperty('click');
  });
});

it('has hover-related classes for interactivity', () => {
  const wrapper = mount(Button, {
    props: { text: 'Hover Me' },
  });

  expect(wrapper.classes()).toContain('hover:bg-white');
  expect(wrapper.classes()).toContain('hover:text-homeblue-100');
});