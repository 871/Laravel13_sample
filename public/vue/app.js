const { createApp, ref, computed } = Vue;

createApp({
  setup() {
    const message = ref('Hello Vue — public/vue');
    const count = ref(0);
    const double = computed(() => count.value * 2);
    return { message, count, double };
  },
  template: `
    <main class="container">
      <h1>{{ message }}</h1>
      <p><button @click="count++">increment</button> Count: {{ count }}</p>
      <p>Double: {{ double }}</p>
    </main>
  `
}).mount('#app');
