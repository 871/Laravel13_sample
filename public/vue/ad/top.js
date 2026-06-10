const { createApp, ref, onMounted } = Vue;

createApp({
  setup() {
    const message = ref('ようこそ、管理画面（Vue）');
    const now = ref('読み込み中...');
    const accountLink = ref('/v1/ad/1');

    onMounted(() => {
      now.value = new Date().toLocaleString();
      // Optionally, attempt to fetch a protected resource to validate the session
      // fetch('/v1/ad/1', { credentials: 'same-origin' }).then(() => {}).catch(() => {});
    });

    function logout() {
      // Redirect to Blade logout (account id 1 is a reasonable default; user may be redirected to login)
      window.location.href = accountLink.value + '/logout';
    }

    return { message, now, logout, accountLink };
  },
  template: `
    <main class="container">
      <h1>{{ message }}</h1>
      <p>現在時刻: {{ now }}</p>

      <div class="card">
        <div class="card-body">
          <p>管理ダッシュボードのプレースホルダです。</p>
          <p><a :href="accountLink">Blade 管理トップへ (サーバー側)</a></p>
          <p><button @click="logout">ログアウト</button></p>
        </div>
      </div>
    </main>
  `
}).mount('#app');
