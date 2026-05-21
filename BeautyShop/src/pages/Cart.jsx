/**
 * Cart Page
 * Shopping cart with:
 * - List of cart items
 * - Quantity controls
 * - Remove items
 * - Cart totals
 * - Checkout button
 */

import React from 'react';
import { Link } from 'react-router-dom';
import { getProductImage } from '../utils/imageHelper';
import { useCart } from '../context/CartContext';
import styles from '../styles/Cart.module.css';

const Cart = () => {
  const {
    cartItems,
    removeFromCart,
    updateQuantity,
    increaseQuantity,
    decreaseQuantity,
    getSubtotal,
    clearCart
  } = useCart();

  const subtotal = getSubtotal();
  const shipping = subtotal > 0 ? (subtotal > 50 ? 0 : 8.99) : 0;
  const tax = subtotal * 0.1; // 10% tax
  const total = subtotal + shipping + tax;

  if (cartItems.length === 0) {
    return (
      <div className={styles.emptyCart}>
        <div className={styles.container}>
          <div className={styles.emptyContent}>
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <h2>Your Cart is Empty</h2>
            <p>Looks like you haven't added any products to your cart yet.</p>
            <Link to="/shop" className={styles.shopBtn}>
              Start Shopping
            </Link>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className={styles.cartPage}>
      <div className={styles.container}>
        <div className={styles.pageHeader}>
          <h1 className={styles.pageTitle}>Shopping Cart</h1>
          <button onClick={clearCart} className={styles.clearBtn}>
            Clear Cart
          </button>
        </div>

        <div className={styles.cartContent}>
          {/* Cart Items */}
          <div className={styles.cartItems}>
            {cartItems.map(item => (
              <div key={item.id} className={styles.cartItem}>
                <div className={styles.itemImage}>
                  <Link to={`/product/${item.slug}`}>
                    <img src={getProductImage(item)} alt={item.name} style={{width:'100%',height:'100%',objectFit:'contain'}} />
                  </Link>
                </div>

                <div className={styles.itemDetails}>
                  <Link to={`/product/${item.slug}`}>
                    <h3 className={styles.itemName}>{item.name}</h3>
                  </Link>
                  <p className={styles.itemCategory}>{item.category}</p>
                  <button
                    onClick={() => removeFromCart(item.id)}
                    className={styles.removeBtn}
                  >
                    Remove
                  </button>
                </div>

                <div className={styles.itemPrice}>
                  ${item.price.toFixed(2)}
                </div>

                <div className={styles.itemQuantity}>
                  <button onClick={() => decreaseQuantity(item.id)}>−</button>
                  <span>{item.quantity}</span>
                  <button onClick={() => increaseQuantity(item.id)}>+</button>
                </div>

                <div className={styles.itemTotal}>
                  ${(item.price * item.quantity).toFixed(2)}
                </div>
              </div>
            ))}
          </div>

          {/* Cart Summary */}
          <div className={styles.cartSummary}>
            <h2 className={styles.summaryTitle}>Order Summary</h2>

            <div className={styles.summaryRow}>
              <span>Subtotal</span>
              <span>${subtotal.toFixed(2)}</span>
            </div>

            <div className={styles.summaryRow}>
              <span>Shipping</span>
              <span>{shipping === 0 ? 'FREE' : `$${shipping.toFixed(2)}`}</span>
            </div>

            <div className={styles.summaryRow}>
              <span>Tax (10%)</span>
              <span>${tax.toFixed(2)}</span>
            </div>

            <div className={styles.summaryDivider}></div>

            <div className={styles.summaryTotal}>
              <span>Total</span>
              <span>${total.toFixed(2)}</span>
            </div>

            {shipping > 0 && (
              <div className={styles.shippingNote}>
                Add ${(50 - subtotal).toFixed(2)} more for FREE shipping!
              </div>
            )}

            <Link to="/checkout" className={styles.checkoutBtn}>
              Proceed to Checkout
            </Link>

            <Link to="/shop" className={styles.continueBtn}>
              Continue Shopping
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Cart;
