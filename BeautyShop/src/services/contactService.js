import api from './api';

export async function submitContact(formData) {
  const res = await api.post('/contacts', formData);
  return res.data;
}
