import { ref } from 'vue';

// Estado reactivo
const isInitialModalVisible = ref(false);
const isSettingsModalVisible = ref(false);

// Métodos exportados
export const useCookieConsent = () => {
  const showInitialModal = () => {
    isInitialModalVisible.value = true;
  };
  
  const hideInitialModal = () => {
    isInitialModalVisible.value = false;
  };

  const showSettingsModal = () => {
    isSettingsModalVisible.value = true;
  };

  const hideSettingsModal = () => {
    isSettingsModalVisible.value = false;
  };

  const hideActiveModal = () => {
    if (isInitialModalVisible.value) hideInitialModal();
    if (isSettingsModalVisible.value) hideSettingsModal();
  };

  return {
    // Estados
    isInitialModalVisible,
    isSettingsModalVisible,
    
    // Métodos
    showInitialModal,
    hideInitialModal,
    showSettingsModal,
    hideSettingsModal,
    hideActiveModal
  };
};