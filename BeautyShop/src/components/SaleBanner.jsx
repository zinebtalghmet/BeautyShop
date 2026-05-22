/**
 * SaleBanner Component
 * Promotional section featuring:
 * - "Spring Beauty Sale - Up to 40% Off" headline
 * - FUNCTIONAL CTA buttons
 * - Custom 3D banner product images
 * - Active social media indicators
 */

import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { getProductsSync } from '../data/products';
import styles from '../styles/SaleBanner.module.css';

const SaleBanner = () => {
  const navigate = useNavigate();
  const { addToCart } = useCart();

  // Get first sale product for "Add to Cart" functionality
  const saleProducts = (getProductsSync() || []).filter(p => p.discount > 0);

  // Add featured product to cart
  const handleAddToCart = () => {
    if (saleProducts[0]) {
      addToCart(saleProducts[0], 1);
      alert(`${saleProducts[0].name} added to cart!`);
    }
  };

  // Custom banner images
  const bannerImages = [
    { id: 1, src: '/images/banner/banner-product-1.png', alt: 'Beauty Product 1', shape: 'shape1' },
    { id: 2, src: '/images/banner/banner-product-2.png', alt: 'Beauty Product 2', shape: 'shape2' },
    { id: 3, src: '/images/banner/banner-product-3.png', alt: 'Beauty Product 3', shape: 'shape3' },
    { id: 4, src: '/images/banner/banner-product-4.png', alt: 'Beauty Product 4', shape: 'shape4' }
  ];

  return (
    <section className={styles.saleBanner}>
      <div className={styles.container}>
        <div className={styles.bannerContent}>
          {/* Left Content - Text and FUNCTIONAL CTAs */}
          <div className={styles.leftContent}>
            <h2 className={styles.saleTitle}>Spring Beauty Sale</h2>
            <h3 className={styles.saleSubtitle}>Up to 40% Off</h3>

            <p className={styles.saleDescription}>
              Discover amazing deals on premium skincare, makeup, and beauty tools.
              Limited time offer on all featured products. Shop now and save big!
            </p>

            {/* Social Media Links - FUNCTIONAL */}
            <div className={styles.socialDots}>
              <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" className={styles.dot} aria-label="Facebook"></a>
              <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" className={styles.dot} aria-label="Instagram"></a>
              <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" className={styles.dot} aria-label="Twitter"></a>
            </div>

            {/* FUNCTIONAL CTA Buttons */}
            <div className={styles.ctaButtons}>
              <button
                className={styles.primaryBtn}
                onClick={() => navigate('/shop')}
              >
                SHOP NOW
              </button>
              <button
                className={styles.secondaryBtn}
                onClick={handleAddToCart}
              >
                ADD TO CART (FLORAL)
              </button>
            </div>
          </div>

          {/* Right Content - 3D Banner Product Images */}
          <div className={styles.rightContent}>
            <div className={styles.productShowcase}>
              {/* First two large images */}
              <div className={`${styles.productItem} ${styles[bannerImages[0].shape]}`}>
                <img
                  src={bannerImages[0].src}
                  alt={bannerImages[0].alt}
                  className={styles.productImg}
                />
              </div>

              <div className={`${styles.productItem} ${styles[bannerImages[1].shape]}`}>
                <img
                  src={bannerImages[1].src}
                  alt={bannerImages[1].alt}
                  className={styles.productImg}
                />
              </div>

              {/* Stacked smaller images */}
              <div className={styles.productStack}>
                <div className={`${styles.productItemSmall} ${styles[bannerImages[2].shape]}`}>
                  <img
                    src={bannerImages[2].src}
                    alt={bannerImages[2].alt}
                    className={styles.productImgSmall}
                  />
                </div>

                <div className={`${styles.productItemSmall} ${styles[bannerImages[3].shape]}`}>
                  <img
                    src={bannerImages[3].src}
                    alt={bannerImages[3].alt}
                    className={styles.productImgSmall}
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default SaleBanner;
