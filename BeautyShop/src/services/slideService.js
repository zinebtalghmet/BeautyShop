import api from './api';

export async function fetchSlides() {
  const res = await api.get('/slides');
  return res.data.data;
}
