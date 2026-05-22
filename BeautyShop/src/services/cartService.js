import api from './api';

export async function fetchCart() {
  const res = await api.get('/cart');
  return res.data.data;
}

export async function addToCartApi(productId, quantity = 1) {
  const res = await api.post('/cart/add', { product_id: productId, quantity });
  return res.data.data;
}

export async function updateCartItemQuantity(cartItemId, quantity) {
  const res = await api.put(`/cart/${cartItemId}`, { quantity });
  return res.data.data;
}

export async function removeCartItem(cartItemId) {
  await api.delete(`/cart/${cartItemId}`);
}

export async function clearCartApi() {
  await api.delete('/cart');
}
