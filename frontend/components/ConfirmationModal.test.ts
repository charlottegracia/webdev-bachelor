import { mount } from '@vue/test-utils';
import { vi } from 'vitest';
import ConfirmationModal from './ConfirmationModal.vue';
import Button from './Button.vue';

describe('ConfirmationModal', () => {
  it('renders correctly when isVisible is true', () => {
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: true,
        title: 'Test Title',
        onConfirm: vi.fn(),
        onCancel: vi.fn(),
      },
      global: {
        components: { Button }
      }
    });

    expect(wrapper.exists()).toBe(true);
    expect(wrapper.find('.fixed').isVisible()).toBe(true);
  });

  it('does not render when isVisible is false', () => {
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: false,
        title: 'Test Title',
        onConfirm: vi.fn(),
        onCancel: vi.fn(),
      },
      global: {
        components: { Button }
      }
    });

    expect(wrapper.exists()).toBe(true);
    expect(wrapper.find('.fixed').exists()).toBe(false);
  });

  it('triggers onConfirm when the confirm button is clicked', async () => {
    const onConfirmMock = vi.fn();
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: true,
        title: 'Confirm Action',
        onConfirm: onConfirmMock,
        onCancel: vi.fn(),
      },
      global: {
        components: { Button }
      }
    });

    const confirmButton = wrapper.findComponent(Button);
    await confirmButton.trigger('click');

    expect(onConfirmMock).toHaveBeenCalledTimes(1);
  });

  it('triggers onCancel when the cancel button is clicked', async () => {
    const onCancelMock = vi.fn();
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: true,
        title: 'Cancel Action',
        onConfirm: vi.fn(),
        onCancel: onCancelMock,
      },
      global: {
        components: { Button }
      }
    });

    const cancelButton = wrapper.findAllComponents(Button).at(1);
    await cancelButton?.trigger('click');

    expect(onCancelMock).toHaveBeenCalledTimes(1);
  });

  it('sets the confirm button text dynamically based on the button prop', () => {
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: true,
        title: 'delete',
        onConfirm: vi.fn(),
        onCancel: vi.fn(),
        button: 'Delete'
      },
      global: {
        components: { Button }
      }
    });

    const confirmButton = wrapper.findComponent(Button);
    expect(confirmButton.text()).toBe('Delete');
  });

  it('sets the cancel button text to "Annuller"', () => {
    const wrapper = mount(ConfirmationModal, {
      props: {
        isVisible: true,
        title: 'Test Title',
        onConfirm: vi.fn(),
        onCancel: vi.fn(),
      },
      global: {
        components: { Button }
      }
    });

    const cancelButton = wrapper.findAllComponents(Button).at(1);
    expect(cancelButton?.text()).toBe('Annuller');
  });

  it('throws a warning if required props are not provided', () => {
    const consoleWarnSpy = vi.spyOn(console, 'warn').mockImplementation(() => {});

    // Mount the component without required props
    mount(ConfirmationModal as any, {
      props: {},
      global: {
        components: { Button }
      }
    });

    // Ensure a warning was called
    expect(consoleWarnSpy).toHaveBeenCalled();

    // Check that at least one warning contains the required prop message
    const warningMessages = consoleWarnSpy.mock.calls.map(call => call[0]);
    expect(warningMessages).toEqual(
      expect.arrayContaining([
        expect.stringContaining('[Vue warn]: Missing required prop: "isVisible"'),
        expect.stringContaining('[Vue warn]: Missing required prop: "title"'),
        expect.stringContaining('[Vue warn]: Missing required prop: "onConfirm"'),
        expect.stringContaining('[Vue warn]: Missing required prop: "onCancel"')
      ])
    );

    consoleWarnSpy.mockRestore();
  });
});