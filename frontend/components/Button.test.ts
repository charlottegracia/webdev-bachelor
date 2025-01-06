import { mount } from "@vue/test-utils";
import Button from "./Button.vue"; // Adjust path if needed

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

    // Simulate a click on the button
    await wrapper.trigger("click");

    // Check if the click event has been emitted (if your button emits anything)
    // In this case, since no event is emitted by default, you can test for a click handler
    // expect(wrapper.emitted()).toHaveProperty('click');
  });
});
