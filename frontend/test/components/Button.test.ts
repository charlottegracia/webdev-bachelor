
import { mount } from "@vue/test-utils";
import Button from "../../components/Button.vue"; 

describe("Button.vue", () => {
  it("renders the correct text when passed as a prop", () => {
    const text = "Click Me";
    const wrapper = mount(Button, {
      props: { text },
    });

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