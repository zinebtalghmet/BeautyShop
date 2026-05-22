import React, { useState, useEffect, useCallback } from 'react';
import { useNavigate } from 'react-router-dom';
import { fetchSlides } from '../services/slideService';
import styles from '../styles/Hero.module.css';

const AutoPlayInterval = 5000;

const Hero = () => {
  const navigate = useNavigate();
  const [slides, setSlides] = useState(null);
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);

  useEffect(() => {
    fetchSlides()
      .then((data) => setSlides(data))
      .catch(() => setSlides([]));
  }, []);

  const next = useCallback(() => {
    if (!slides || slides.length === 0) return;
    setCurrent((prev) => (prev + 1) % slides.length);
  }, [slides]);

  const prev = useCallback(() => {
    if (!slides || slides.length === 0) return;
    setCurrent((prev) => (prev - 1 + slides.length) % slides.length);
  }, [slides]);

  useEffect(() => {
    if (!slides || slides.length <= 1 || paused) return;
    const timer = setInterval(next, AutoPlayInterval);
    return () => clearInterval(timer);
  }, [slides, paused, next]);

  if (slides === null) {
    return null;
  }

  if (slides.length === 0) {
    return (
      <section className={styles.hero}>
        <div className={styles.container}>
          <div className={styles.heroWrapper}>
            <div className={styles.modelSection}>
              <img src="/images/hero/hero-model.png" alt="Beauty Model" className={styles.modelImage} />
            </div>
            <div className={styles.centerContent}>
              <p className={styles.subtitle}>ELEVATE YOUR LIFESTYLE</p>
              <h1 className={styles.mainHeadline}>Elevate Your<br />Beauty Experience</h1>
              <button className={styles.shopButton} onClick={() => navigate('/shop')}>SHOP NOW</button>
            </div>
            <div className={styles.productsSection}>
              <img src="/images/hero/hero-product-1.png" alt="Beauty Product" className={`${styles.floatingProduct} ${styles.product1}`} />
              <img src="/images/hero/hero-product-2.png" alt="Beauty Product" className={`${styles.floatingProduct} ${styles.product2}`} />
              <img src="/images/hero/hero-product-3.png" alt="Beauty Product" className={`${styles.floatingProduct} ${styles.product3}`} />
              <img src="/images/hero/hero-product-4.png" alt="Beauty Product" className={`${styles.floatingProduct} ${styles.product4}`} />
            </div>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section
      className={styles.hero}
      onMouseEnter={() => setPaused(true)}
      onMouseLeave={() => setPaused(false)}
    >
      {slides.map((s, i) => (
        <div
          key={s.id}
          className={`${styles.slide} ${i === current ? styles.slideActive : ''}`}
          style={{ backgroundImage: s.image_url ? `url(${s.image_url})` : undefined }}
        >
          <div className={styles.slideOverlay} />
          <div className={styles.slideContent}>
            {s.subtitle && <p className={styles.slideSubtitle}>{s.subtitle}</p>}
            <h1 className={styles.slideTitle}>{s.title}</h1>
            {s.button_text && (
              <button
                className={styles.slideButton}
                onClick={() => {
                  if (s.button_link) navigate(s.button_link);
                  else if (slides.length > 1) next();
                }}
              >
                {s.button_text}
              </button>
            )}
          </div>
        </div>
      ))}

      {slides.length > 1 && (
        <>
          <button className={`${styles.arrow} ${styles.arrowLeft}`} onClick={prev} aria-label="Previous slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><polyline points="15 18 9 12 15 6" /></svg>
          </button>
          <button className={`${styles.arrow} ${styles.arrowRight}`} onClick={next} aria-label="Next slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><polyline points="9 18 15 12 9 6" /></svg>
          </button>
          <div className={styles.dots}>
            {slides.map((s, i) => (
              <button
                key={s.id}
                className={`${styles.dot} ${i === current ? styles.dotActive : ''}`}
                onClick={() => setCurrent(i)}
                aria-label={`Go to slide ${i + 1}`}
              />
            ))}
          </div>
        </>
      )}
    </section>
  );
};

export default Hero;
