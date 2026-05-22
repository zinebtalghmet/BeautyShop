import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { getFeaturedProducts } from '../data/products';
import { getProductImage } from '../utils/imageHelper';
import styles from '../styles/FeaturedProducts.module.css';

const FeaturedProducts = () => {
  const [featuredProducts, setFeaturedProducts] = useState([]);

  useEffect(() => {
    getFeaturedProducts().then(setFeaturedProducts);
  }, []);

  return (
    <section className={styles.featuredProducts}>
      <div className={styles.container}>
        <h2 className={styles.sectionTitle}>Featured Product</h2>

        <div className={styles.productsGrid}>
          {featuredProducts.map((product) => (
            <Link
              key={product.id}
              to={`/product/${product.slug}`}
              className={styles.productCard}
            >
              {product.discount > 0 && (
                <div className={styles.discountBadge}>-{product.discount}%</div>
              )}

              <div className={styles.productImage}>
                <img
                  src={getProductImage(product)}
                  alt={product.name}
                  className={styles.productImg}
                />
              </div>

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
