<script setup>
import { ref } from 'vue'
import WelcomeCard from '@/Components/Contact/WelcomeCard.vue';
import HowToSell from '@/Components/Contact/HowToSell.vue';

const step = ref(1)

const goToNextStep = () => {
  step.value = 2
}
</script>

<template>
  <div id="formulario">
    <WelcomeCard v-if="step === 1" @start="goToNextStep" />
    <HowToSell v-if="step === 2" />
  </div>
</template>

