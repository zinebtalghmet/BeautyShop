import React, { useState, useEffect, useCallback } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { placeOrder, fetchTaxRate, fetchShippingRate } from '../services/orderService';
import countries from '../data/countries';
import styles from '../styles/Checkout.module.css';

const Checkout = () => {
  const navigate = useNavigate();
  const { cartItems, getSubtotal, clearCart } = useCart();
  const [formData, setFormData] = useState({
    firstName: '', lastName: '', email: '', phone: '',
    address: '', city: '', state: '', zip: '', country: 'US', region: '',
    cardNumber: '', cardName: '', expiry: '', cvv: ''
  });
  const [paymentMethod, setPaymentMethod] = useState('card');
  const [tax, setTax] = useState({ rate: 0, label: 'Tax', amount: 0 });
  const [shipping, setShipping] = useState({ cost: 0, label: 'Shipping' });
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState('');

  const subtotal = getSubtotal();
  const total = subtotal + shipping.cost + tax.amount;

  const loadRates = useCallback(async () => {
    try {
      const [taxResult, shippingResult] = await Promise.all([
        fetchTaxRate(formData.country, formData.region, subtotal),
        fetchShippingRate(subtotal, formData.country, formData.region),
      ]);
      setTax(taxResult);
      setShipping(shippingResult);
    } catch {
      setTax({ rate: 0, label: 'Tax', amount: 0 });
      setShipping({ cost: subtotal > 50 ? 0 : 8.99, label: 'Shipping' });
    }
  }, [formData.country, formData.region, subtotal]);

  useEffect(() => {
    loadRates();
  }, [loadRates]);

  if (cartItems.length === 0) {
    navigate('/cart');
    return null;
  }

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleCountryChange = (e) => {
    setFormData({ ...formData, country: e.target.value, region: '' });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setSubmitting(true);
    setError('');

    try {
      await placeOrder({ ...formData, paymentMethod });
      clearCart();
      navigate('/order-success');
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to place order. Please try again.');
      setSubmitting(false);
    }
  };

  return (
    <div className={styles.checkoutPage}>
      <div className={styles.container}>
        <h1 className={styles.pageTitle}>Checkout</h1>

        {error && (
          <div className={styles.errorBanner}>{error}</div>
        )}

        <div className={styles.checkoutContent}>
          <form onSubmit={handleSubmit} className={styles.checkoutForm}>
            <div className={styles.section}>
              <h2>Shipping Information</h2>
              <div className={styles.formGrid}>
                <input name="firstName" placeholder="First Name" value={formData.firstName} onChange={handleChange} required />
                <input name="lastName" placeholder="Last Name" value={formData.lastName} onChange={handleChange} required />
                <input name="email" type="email" placeholder="Email" value={formData.email} onChange={handleChange} required />
                <input name="phone" placeholder="Phone" value={formData.phone} onChange={handleChange} required />
                <input name="address" placeholder="Address" value={formData.address} onChange={handleChange} required className={styles.fullWidth} />
                <input name="city" placeholder="City" value={formData.city} onChange={handleChange} required />
                <select name="country" value={formData.country} onChange={handleCountryChange} required className={styles.selectInput}>
                  <option value="">Select Country</option>
                  {countries.map(c => (
                    <option key={c.code} value={c.code}>{c.name}</option>
                  ))}
                </select>
                <input name="state" placeholder="State / Province" value={formData.state} onChange={handleChange} required />
                <input name="zip" placeholder="ZIP Code" value={formData.zip} onChange={handleChange} required />
                <input name="region" placeholder="Region (optional)" value={formData.region} onChange={handleChange} className={styles.fullWidth} />
              </div>
            </div>

            <div className={styles.section}>
              <h2>Payment Method</h2>
              <div className={styles.paymentMethods}>
                <label className={`${styles.paymentOption} ${paymentMethod === 'card' ? styles.paymentActive : ''}`}>
                  <input type="radio" name="paymentMethod" value="card" checked={paymentMethod === 'card'}
                    onChange={(e) => setPaymentMethod(e.target.value)} />
                  <span className={styles.paymentIcon}>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="3" stroke="currentColor" strokeWidth="2"/><line x1="2" y1="10" x2="22" y2="10" stroke="currentColor" strokeWidth="2"/></svg>
                  </span>
                  <span>Credit / Debit Card</span>
                </label>
                <label className={`${styles.paymentOption} ${paymentMethod === 'cash_on_delivery' ? styles.paymentActive : ''}`}>
                  <input type="radio" name="paymentMethod" value="cash_on_delivery" checked={paymentMethod === 'cash_on_delivery'}
                    onChange={(e) => setPaymentMethod(e.target.value)} />
                  <span className={styles.paymentIcon}>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="2"/><path d="M12 6V18M18 12H6" stroke="currentColor" strokeWidth="2" strokeLinecap="round"/></svg>
                  </span>
                  <span>Cash on Delivery</span>
                </label>
              </div>
            </div>

            {paymentMethod === 'card' && (
              <div className={styles.section}>
                <h2>Card Details</h2>
                <div className={styles.formGrid}>
                  <input name="cardNumber" placeholder="Card Number" value={formData.cardNumber} onChange={handleChange} required className={styles.fullWidth} />
                  <input name="cardName" placeholder="Cardholder Name" value={formData.cardName} onChange={handleChange} required className={styles.fullWidth} />
                  <input name="expiry" placeholder="MM/YY" value={formData.expiry} onChange={handleChange} required />
                  <input name="cvv" placeholder="CVV" value={formData.cvv} onChange={handleChange} required />
                </div>
              </div>
            )}

            <button type="submit" className={styles.placeOrderBtn} disabled={submitting}>
              {submitting ? 'Processing...' : `Place Order - $${total.toFixed(2)}`}
            </button>
          </form>

          <div className={styles.orderSummary}>
            <h2>Order Summary</h2>
            <div className={styles.summaryItems}>
              {cartItems.map(item => (
                <div key={item.id} className={styles.summaryItem}>
                  <span>{item.name} x {item.quantity}</span>
                  <span>${(item.price * item.quantity).toFixed(2)}</span>
                </div>
              ))}
            </div>
            <div className={styles.summaryTotals}>
              <div className={styles.summaryRow}>
                <span>Subtotal</span><span>${subtotal.toFixed(2)}</span>
              </div>
              <div className={styles.summaryRow}>
                <span>{shipping.label}</span><span>{shipping.cost === 0 ? 'FREE' : `$${shipping.cost.toFixed(2)}`}</span>
              </div>
              <div className={styles.summaryRow}>
                <span>{tax.label} ({tax.rate}%)</span><span>${tax.amount.toFixed(2)}</span>
              </div>
              <div className={styles.summaryTotal}>
                <span>Total</span><span>${total.toFixed(2)}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Checkout;
