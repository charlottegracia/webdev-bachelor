<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <h3 class="text-xl font-semibold">Er du sikker?</h3>
        <p class="mb-4">Er du sikker på, at du vil oprette denne {{ title }}?</p>
        <div class="flex gap-4">
          <Button text="Ja, opret" @click="confirm" />
          <Button text="Nej, annuller" @click="cancel" />
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
import { Title } from '#build/components';

  const props = defineProps({
    isVisible: {
      type: Boolean,
      required: true
    },
    onConfirm: {
      type: Function,
      required: true
    },
    onCancel: {
      type: Function,
      required: true
    },
    title: {
      type: String,
      required: true
    }
  });
  
  const confirm = () => {
    props.onConfirm();
  };
  
  const cancel = () => {
    props.onCancel();
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    width: 400px;
    text-align: center;
  }
  
  button {
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
  }
  </style>
  