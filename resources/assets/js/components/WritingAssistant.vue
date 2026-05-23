<template>
  <div class="writing-assistant">
    <!-- No API Key Warning -->
    <div v-if="!hasApiKey" class="wa-warning">
      <strong>Claude API key not configured.</strong>
      AI writing features require a Claude API key.
      <a :href="settingsUrl">Configure in Site Settings &rarr;</a>
    </div>

    <!-- Main UI -->
    <div v-else class="wa-bar">
      <div class="wa-header">
        <span class="wa-badge">AI</span>
        <span class="wa-title">Writing Assistant</span>
        <span class="wa-powered">Powered by Claude</span>
      </div>

      <!-- Persona Cards -->
      <div class="wa-personas">
        <div
          v-for="persona in personas"
          :key="persona.id"
          class="wa-persona-card"
          :class="{ selected: selectedPersona?.id === persona.id }"
          @click="selectPersona(persona)"
        >
          <img
            v-if="persona.avatar_url"
            :src="persona.avatar_url"
            :alt="persona.title"
            class="wa-avatar"
          />
          <div v-else class="wa-avatar wa-avatar-placeholder">
            {{ persona.title.charAt(0) }}
          </div>
          <div class="wa-persona-info">
            <div class="wa-persona-name">{{ persona.title }}</div>
            <div class="wa-persona-specialty">{{ persona.specialty }}</div>
            <div class="wa-persona-desc">{{ truncate(persona.voice_description, 80) }}</div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="wa-actions">
        <button
          class="wa-btn wa-btn-generate"
          :disabled="!selectedPersona || loading"
          @click="generate"
        >
          &#10024; Generate from Title
        </button>
        <button
          class="wa-btn wa-btn-restyle"
          :disabled="!selectedPersona || loading"
          @click="restyle"
        >
          &#128260; Restyle Draft
        </button>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="wa-loading">
        <img
          v-if="selectedPersona?.avatar_url"
          :src="selectedPersona.avatar_url"
          class="wa-loading-avatar"
        />
        <div class="wa-loading-text">{{ selectedPersona?.title }} is writing...</div>
      </div>

      <!-- Error -->
      <div v-if="error" class="wa-error">
        {{ error }}
        <button @click="error = null" class="wa-error-dismiss">&#10005;</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'WritingAssistant',
  props: {
    hasApiKey: { type: Boolean, default: false },
    settingsUrl: { type: String, default: '/admin/settings' },
    generateUrl: { type: String, default: '/admin/ai/generate' },
  },
  data() {
    return {
      personas: [],
      selectedPersona: null,
      loading: false,
      error: null,
    };
  },
  mounted() {
    this.fetchPersonas();
  },
  methods: {
    async fetchPersonas() {
      try {
        const res = await axios.get('/admin/api/writing-personas');
        this.personas = res.data;
      } catch (e) {
        this.error = 'Failed to load writing personas.';
      }
    },
    selectPersona(persona) {
      this.selectedPersona = persona;
    },
    truncate(text, len) {
      return text.length > len ? text.substring(0, len) + '\u2026' : text;
    },
    getTitle() {
      const store = this.$root.$store;
      if (store && store.state.form) {
        return store.state.form.fields.find(f => f.name === 'title')?.value || '';
      }
      const input = document.querySelector('input[name="title"]');
      return input ? input.value : '';
    },
    getBody() {
      const store = this.$root.$store;
      if (store && store.state.form) {
        const field = store.state.form.fields.find(f => f.name === 'body');
        return field?.value || '';
      }
      return '';
    },
    setBody(text) {
      const store = this.$root.$store;
      if (store) {
        store.commit('updateFormField', { name: 'body', value: text });
      }
    },
    async callApi(action) {
      this.loading = true;
      this.error = null;

      try {
        const res = await axios.post(this.generateUrl, {
          persona_id: this.selectedPersona.id,
          action: action,
          title: this.getTitle(),
          body: action === 'restyle' ? this.getBody() : null,
        });

        this.setBody(res.data.text);
      } catch (e) {
        this.error = e.response?.data?.error || 'Something went wrong. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    generate() {
      this.callApi('generate');
    },
    restyle() {
      this.callApi('restyle');
    },
  },
};
</script>

<style scoped>
.writing-assistant {
  margin-bottom: 20px;
}

.wa-warning {
  background: #fffbeb;
  border: 1px solid #fcd34d;
  border-radius: 8px;
  padding: 14px 18px;
  font-size: 13px;
  color: #92400e;
}
.wa-warning a {
  color: #6c63ff;
  font-weight: 500;
}

.wa-bar {
  background: #f8f9fb;
  border: 1px solid #e2e6ee;
  border-radius: 10px;
  padding: 18px;
}

.wa-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 14px;
}
.wa-badge {
  background: linear-gradient(135deg, #6c63ff, #a855f7);
  color: #fff;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 8px;
  border-radius: 6px;
}
.wa-title {
  font-size: 14px;
  font-weight: 600;
}
.wa-powered {
  font-size: 10px;
  background: #e8e6ff;
  color: #6c63ff;
  padding: 2px 8px;
  border-radius: 10px;
  font-weight: 600;
}

.wa-personas {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 10px;
  margin-bottom: 14px;
}

.wa-persona-card {
  display: flex;
  gap: 10px;
  align-items: flex-start;
  padding: 12px;
  border: 2px solid #e2e6ee;
  border-radius: 10px;
  background: #fff;
  cursor: pointer;
  transition: all 0.15s;
}
.wa-persona-card:hover {
  border-color: #b0b0e0;
}
.wa-persona-card.selected {
  border-color: #6c63ff;
  background: #faf9ff;
  box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.12);
}

.wa-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}
.wa-avatar-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e2e6ee;
  color: #666;
  font-weight: 700;
  font-size: 18px;
}

.wa-persona-name {
  font-size: 13px;
  font-weight: 700;
}
.wa-persona-specialty {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6c63ff;
  margin: 2px 0;
}
.wa-persona-desc {
  font-size: 11px;
  color: #888;
  line-height: 1.4;
}

.wa-actions {
  display: flex;
  gap: 8px;
}

.wa-btn {
  padding: 9px 16px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: all 0.15s;
}
.wa-btn:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}
.wa-btn-generate {
  background: #6c63ff;
  color: #fff;
}
.wa-btn-generate:hover:not(:disabled) {
  background: #5a52d9;
}
.wa-btn-restyle {
  background: #fff;
  color: #6c63ff;
  border: 1px solid #6c63ff;
}
.wa-btn-restyle:hover:not(:disabled) {
  background: #f0eeff;
}

.wa-loading {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 14px;
  padding: 16px;
  background: rgba(108, 99, 255, 0.04);
  border: 1px dashed rgba(108, 99, 255, 0.3);
  border-radius: 8px;
}
.wa-loading-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.06); }
}
.wa-loading-text {
  font-size: 13px;
  color: #6c63ff;
  font-weight: 500;
}

.wa-error {
  margin-top: 10px;
  padding: 10px 14px;
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 6px;
  font-size: 12px;
  color: #dc2626;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.wa-error-dismiss {
  background: none;
  border: none;
  color: #dc2626;
  cursor: pointer;
  font-size: 14px;
}
</style>
