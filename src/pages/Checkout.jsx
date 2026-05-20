/**
 * Checkout Page
 * Order completion with shipping and payment forms
 */

import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import styles from '../styles/Checkout.module.css';

const Checkout = () => {
  const navigate = useNavigate();
  const { cartItems, getSubtotal, clearCart } = useCart();
  const [formData, setFormData] = useState({
    firstName: '', lastName: '', email: '', phone: '',
    address: '', city: '', state: '', zip: '', country: 'USA',
    cardNumber: '', cardName: '', expiry: '', cvv: ''
  });

  const subtotal = getSubtotal();
  const shipping = subtotal > 50 ? 0 : 8.99;
  const tax = subtotal * 0.1;
  const total = subtotal + shipping + tax;

  if (cartItems.length === 0) {
    navigate('/cart');
    return null;
  }

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Simulate order placement
    alert(`Order placed successfully! Total: $${total.toFixed(2)}`);
    clearCart();
    navigate('/');
  };

  return (
    <div className={styles.checkoutPage}>
      <div className={styles.container}>
        <h1 className={styles.pageTitle}>Checkout</h1>

        <div className={styles.checkoutContent}>
          <form onSubmit={handleSubmit} className={styles.checkoutForm}>
            {/* Shipping Information */}
            <div className={styles.section}>
              <h2>Shipping Information</h2>
              <div className={styles.formGrid}>
                <input name="firstName" placeholder="First Name" onChange={handleChange} required />
                <input name="lastName" placeholder="Last Name" onChange={handleChange} required />
                <input name="email" type="email" placeholder="Email" onChange={handleChange} required />
                <input name="phone" placeholder="Phone" onChange={handleChange} required />
                <input name="address" placeholder="Address" onChange={handleChange} required className={styles.fullWidth} />
                <input name="city" placeholder="City" onChange={handleChange} required />
                <input name="state" placeholder="State" onChange={handleChange} required />
                <input name="zip" placeholder="ZIP Code" onChange={handleChange} required />
              </div>
            </div>

            {/* Payment Information */}
            <div className={styles.section}>
              <h2>Payment Information</h2>
              <div className={styles.formGrid}>
                <input name="cardNumber" placeholder="Card Number" onChange={handleChange} required className={styles.fullWidth} />
                <input name="cardName" placeholder="Cardholder Name" onChange={handleChange} required className={styles.fullWidth} />
                <input name="expiry" placeholder="MM/YY" onChange={handleChange} required />
                <input name="cvv" placeholder="CVV" onChange={handleChange} required />
              </div>
            </div>

            <button type="submit" className={styles.placeOrderBtn}>
              Place Order - ${total.toFixed(2)}
            </button>
          </form>

          {/* Order Summary */}
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
                <span>Shipping</span><span>{shipping === 0 ? 'FREE' : `$${shipping.toFixed(2)}`}</span>
              </div>
              <div className={styles.summaryRow}>
                <span>Tax</span><span>${tax.toFixed(2)}</span>
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
