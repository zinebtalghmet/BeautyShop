import axios from 'axios';

const API_BASE = process.env.REACT_APP_API_URL || 'http://localhost:8000';

const api = axios.create({
  baseURL: `${API_BASE}/api/v1`,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: true,
  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',
});

let sessionId = localStorage.getItem('beautyShopSessionId');
if (!sessionId) {
  sessionId = 'sess_' + Date.now() + '_' + Math.random().toString(36).substring(2, 10);
  localStorage.setItem('beautyShopSessionId', sessionId);
}

api.interceptors.request.use((config) => {
  if (!config.data?.session_id && !config.params?.session_id) {
    config.params = { ...config.params, session_id: sessionId };
  }
  return config;
});

export { sessionId };
export default api;
