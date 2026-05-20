/**
 * ProductCard Component
 * Reusable product card component used in the featured products grid
 *
 * Props:
 * - title: Product category title
 * - subtitle: Product description
 * - discount: Discount percentage (e.g., "-30%")
 * - hasDiscount: Boolean to show/hide discount badge
 */

import React from 'react';
import styles from '../styles/ProductCard.module.css';

const ProductCard = ({ title, subtitle, discount, hasDiscount }) => {
  return (
    <div className={styles.productCard}>
      {/* Discount Badge (conditionally rendered) */}
      {hasDiscount && (
        <div className={styles.discountBadge}>{discount}</div>
      )}

      {/* Product Image Placeholder */}
      <div className={styles.productImage}>
        <div className={styles.imagePlaceholder}></div>
      </div>

      {/* Product Information */}
      <div className={styles.productInfo}>
        <h3 className={styles.productTitle}>{title}</h3>
        <p className={styles.productSubtitle}>{subtitle}</p>
        <a href="#shop" className={styles.shopLink}>
          Shop Now →
        </a>
      </div>
    </div>
  );
};

export default ProductCard;
