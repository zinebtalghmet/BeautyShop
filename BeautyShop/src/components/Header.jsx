/**
 * Header Component
 * Contains:
 * - Top promotional banner with delivery info
 * - Main navigation with logo, menu items, and action buttons
 */

import React from 'react';
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import styles from '../styles/Header.module.css';

const Header = () => {
  const { getCartCount } = useCart();
  const cartCount = getCartCount();

  return (
    <header className={styles.header}>
      {/* Top Promotional Banner */}
      <div className={styles.topBanner}>
        <div className={styles.container}>
          <div className={styles.bannerContent}>
            {/* Left side promotional text */}
            <span className={styles.promoText}>
              FREE SHIPPING ON ORDERS OVER $50
            </span>

            {/* Right side info links */}
            <div className={styles.infoLinks}>
              <Link to="/contact" className={styles.infoLink}>
                <span className={styles.icon}>📍</span>
                DELIVERY INFO
              </Link>
              <Link to="/contact" className={styles.infoLink}>
                <span className={styles.icon}>✉️</span>
                HELP OR CALL US
              </Link>
            </div>
          </div>
        </div>
      </div>

      {/* Main Navigation Bar */}
      <nav className={styles.mainNav}>
        <div className={styles.container}>
          <div className={styles.navContent}>
            {/* Logo */}
            <Link to="/" className={styles.logo}>
              <h1>BEAUTY<span className={styles.logoDot}>·</span></h1>
            </Link>

            {/* Navigation Menu */}
            <ul className={styles.navMenu}>
              <li><Link to="/" className={styles.navLink}>Home</Link></li>
              <li><Link to="/shop" className={styles.navLink}>Shop</Link></li>
              <li><Link to="/about" className={styles.navLink}>About</Link></li>
              <li><Link to="/contact" className={styles.navLink}>Contact</Link></li>
            </ul>

            {/* Right side actions (icons + CTA button) */}
            <div className={styles.navActions}>
              {/* Icon buttons */}
              <div className={styles.iconButtons}>
                <Link to="/shop" className={styles.iconBtn} aria-label="Search">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                  </svg>
                </Link>
                <Link to="/cart" className={styles.iconBtn} aria-label="Shopping Cart">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  {cartCount > 0 && <span className={styles.cartBadge}>{cartCount}</span>}
                </Link>
              </div>

              {/* CTA Button */}
              <Link to="/shop" className={styles.ctaButton}>SHOP NOW</Link>
            </div>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header;
