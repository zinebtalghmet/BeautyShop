import React from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/OrderSuccess.module.css';

const OrderSuccess = () => {
  return (
    <div className={styles.page}>
      <div className={styles.container}>
        <div className={styles.icon}>
          <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#d4a5a5" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
          </svg>
        </div>
        <h1 className={styles.title}>Order Placed Successfully!</h1>
        <p className={styles.message}>
          Thank you for your purchase. You'll receive a confirmation email shortly with your order details.
        </p>
        <p className={styles.tracking}>
          You can track your order status through email updates. We'll notify you at every step.
        </p>
        <div className={styles.actions}>
          <Link to="/shop" className={styles.btnPrimary}>Continue Shopping</Link>
          <Link to="/" className={styles.btnSecondary}>Back to Home</Link>
        </div>
      </div>
    </div>
  );
};

export default OrderSuccess;
