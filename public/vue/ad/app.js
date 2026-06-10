const { createApp, ref } = Vue;

function readXsrfTokenFromCookie() {
  const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
  if (!match) return null;
  try { return decodeURIComponent(match[1]); } catch { return null; }
}

createApp({
  setup() {
    const email = ref('');
    const password = ref('');
    const error = ref('');
    const loading = ref(false);

    async function submit() {
      error.value = '';
      loading.value = true;
      try {
        const token = readXsrfTokenFromCookie();
        const res = await fetch('/v1/ad/api/login', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': token || ''
          },
          credentials: 'same-origin',
          body: JSON.stringify({ email: email.value, password: password.value })
        });

        const json = await res.json().catch(() => ({ ok:false, message: 'Invalid response' }));
        if (res.ok && json.ok) {
          // SPA flow: always go to the Vue admin top page
          window.location.href = '/vue/ad/top.html';
          return;
        }

        error.value = json.message || 'ログインに失敗しました';
      } catch (e) {
        error.value = '通信エラーが発生しました';
      } finally {
        loading.value = false;
      }
    }

    return { email, password, error, loading, submit };
  },
  template: `
    <main class="container">
      <h1>管理ログイン (Vue)</h1>
      <div class="card">
        <div class="card-body">
          <div v-if="error" class="alert">{{ error }}</div>
          <div class="mb">
            <label>メールアドレス</label>
            <input type="email" v-model="email" required />
          </div>
          <div class="mb">
            <label>パスワード</label>
            <input type="password" v-model="password" required />
          </div>
          <div class="actions">
            <button @click.prevent="submit" :disabled="loading">{{ loading ? '処理中...' : 'ログイン' }}</button>
          </div>
        </div>
      </div>
    </main>
  `
}).mount('#app');
