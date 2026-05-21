/**
 * FeaturedProducts Component
 * Displays a grid of REAL featured products with:
 * - Actual product images
 * - Product titles and descriptions
 * - Discount badges
 * - Clickable "Shop Now" links that navigate to product detail
 */

import React from 'react';
import { Link } from 'react-router-dom';
import { getFeaturedProducts } from '../data/products';
import { getProductImage } from '../utils/imageHelper';
import styles from '../styles/FeaturedProducts.module.css';

const FeaturedProducts = () => {
  // Get REAL featured products from data
  const featuredProducts = getFeaturedProducts();

  return (
    <section className={styles.featuredProducts}>
      <div className={styles.container}>
        {/* Section Title */}
        <h2 className={styles.sectionTitle}>Featured Product</h2>

        {/* Products Grid - Using REAL products */}
        <div className={styles.productsGrid}>
          {featuredProducts.map((product) => (
            <Link
              key={product.id}
              to={`/product/${product.slug}`}
              className={styles.productCard}
            >
              {/* Discount Badge */}
              {product.discount > 0 && (
                <div className={styles.discountBadge}>-{product.discount}%</div>
              )}

              {/* Product Image - REAL IMAGE */}
              <div className={styles.productImage}>
                <img
                  src={getProductImage(product)}
                  alt={product.name}
                  className={styles.productImg}
                />
              </div>

              {/* Product Info */}
              <div className={styles.productInfo}>
                <h3 className={styles.productTitle}>{product.name.toUpperCase()}</h3>
                <p className={styles.productSubtitle}>{product.description.substring(0, 30)}...</p>
                <span className={styles.shopLink}>
                  Shop Now →
                </span>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};

export default FeaturedProducts;
