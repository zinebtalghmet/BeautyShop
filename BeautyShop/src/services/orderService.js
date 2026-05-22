import api from './api';

export async function placeOrder(orderData) {
  const payload = {
    first_name: orderData.firstName,
    last_name: orderData.lastName,
    email: orderData.email,
    phone: orderData.phone || '',
    address: orderData.address,
    city: orderData.city,
    state: orderData.state,
    zip: orderData.zip,
    country: orderData.country || 'US',
    region: orderData.region || '',
    payment_method: orderData.paymentMethod || 'card',
  };

  const res = await api.post('/orders', payload);
  return res.data;
}

export async function fetchTaxRate(country, region = '', subtotal = 0) {
  const params = { country, subtotal };
  if (region) params.region = region;
  const res = await api.get('/tax-rate', { params });
  return res.data.data;
}

export async function fetchShippingRate(subtotal, country = 'US', region = '') {
  const params = { subtotal, country };
  if (region) params.region = region;
  const res = await api.get('/shipping-rate', { params });
  return res.data.data;
}
