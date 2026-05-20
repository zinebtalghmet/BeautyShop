/**
 * Hero Component
 * Sophisticated branded hero banner featuring:
 * - Model image on the left
 * - Centered headline "Elevate Your Beauty Experience"
 * - Floating product images on the right
 * - FUNCTIONAL "SHOP NOW" button
 */

import React from 'react';
import { useNavigate } from 'react-router-dom';
import styles from '../styles/Hero.module.css';

const Hero = () => {
  const navigate = useNavigate();

  return (
    <section className={styles.hero}>
      <div className={styles.container}>
        <div className={styles.heroWrapper}>
          {/* Left Side - Model Image */}
          <div className={styles.modelSection}>
            <img
              src="/images/hero/hero-model.png"
              alt="Beauty Model"
              className={styles.modelImage}
            />
          </div>

          {/* Center Content - Headline and CTA */}
          <div className={styles.centerContent}>
            <p className={styles.subtitle}>ELEVATE YOUR LIFESTYLE</p>
            <h1 className={styles.mainHeadline}>
              Elevate Your<br />Beauty Experience
            </h1>
            {/* FUNCTIONAL BUTTON - Navigates to shop */}
            <button
              className={styles.shopButton}
              onClick={() => navigate('/shop')}
            >
              SHOP NOW
            </button>
          </div>

          {/* Right Side - Floating Products */}
          <div className={styles.productsSection}>
            <img
              src="/images/hero/hero-product-1.png"
              alt="Beauty Product"
              className={`${styles.floatingProduct} ${styles.product1}`}
            />
            <img
              src="/images/hero/hero-product-2.png"
              alt="Beauty Product"
              className={`${styles.floatingProduct} ${styles.product2}`}
            />
            <img
              src="/images/hero/hero-product-3.png"
              alt="Beauty Product"
              className={`${styles.floatingProduct} ${styles.product3}`}
            />
            <img
              src="/images/hero/hero-product-4.png"
              alt="Beauty Product"
              className={`${styles.floatingProduct} ${styles.product4}`}
            />
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;
