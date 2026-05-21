/**
 * About Page
 */

import React from 'react';
import styles from '../styles/About.module.css';

const About = () => {
  return (
    <div className={styles.aboutPage}>
      <div className={styles.hero}>
        <div className={styles.container}>
          <h1 className={styles.heroTitle}>About Beauty</h1>
          <p className={styles.heroSubtitle}>Premium Skincare & Cosmetics Since 2020</p>
        </div>
      </div>

      <div className={styles.container}>
        <section className={styles.section}>
          <h2>Our Story</h2>
          <p>Beauty was founded with a simple mission: to provide high-quality, effective beauty products that enhance natural beauty while promoting healthy skin. We believe that everyone deserves to feel confident and beautiful in their own skin.</p>
          <p>Our carefully curated selection of skincare, makeup, and haircare products are sourced from trusted brands and formulated with premium ingredients. Each product undergoes rigorous testing to ensure it meets our high standards of quality and efficacy.</p>
        </section>

        <section className={styles.section}>
          <h2>Our Values</h2>
          <div className={styles.values}>
            <div className={styles.valueCard}>
              <div className={styles.valueIcon}>✓</div>
              <h3>Quality First</h3>
              <p>We only offer products that we would use ourselves, ensuring the highest quality standards.</p>
            </div>
            <div className={styles.valueCard}>
              <div className={styles.valueIcon}>♥</div>
              <h3>Cruelty-Free</h3>
              <p>All our products are cruelty-free and ethically sourced from responsible manufacturers.</p>
            </div>
            <div className={styles.valueCard}>
              <div className={styles.valueIcon}>★</div>
              <h3>Customer First</h3>
              <p>Your satisfaction is our priority. We're here to help you find the perfect products for your needs.</p>
            </div>
          </div>
        </section>

        <section className={styles.section}>
          <h2>Why Choose Us?</h2>
          <ul className={styles.benefits}>
            <li>Premium quality products from trusted brands</li>
            <li>Expert beauty advice and personalized recommendations</li>
            <li>Fast and reliable shipping</li>
            <li>30-day money-back guarantee</li>
            <li>Exceptional customer service</li>
            <li>Regular sales and exclusive offers</li>
          </ul>
        </section>
      </div>
    </div>
  );
};

export default About;
