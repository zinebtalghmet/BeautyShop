/**
 * InfoCards Component
 * Three CLICKABLE informational cards featuring:
 * - Real category images
 * - Links to shop filtered by category
 * - Hover effects and interactions
 */

import React from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/InfoCards.module.css';

const InfoCards = () => {

  // Card data with real content and images
  const cards = [
    {
      id: 1,
      category: 'TRENDING',
      title: 'NATURAL COSMETICS',
      description: 'Discover our collection of natural, organic skincare products.',
      image: '/images/cards/card-skincare.png',
      link: '/shop',
      filter: 'skincare'
    },
    {
      id: 2,
      category: 'TRENDING',
      title: 'MODERN ROMANCE',
      description: 'Explore romantic makeup shades and beauty essentials.',
      image: '/images/cards/card-makeup.png',
      link: '/shop',
      filter: 'makeup'
    },
    {
      id: 3,
      category: 'TRENDING',
      title: 'BEAUTY TOOLS',
      description: 'Professional tools for flawless application every time.',
      image: '/images/cards/card-tools.png',
      link: '/shop',
      filter: 'tools'
    }
  ];

  return (
    <section className={styles.infoCards}>
      <div className={styles.container}>
        <div className={styles.cardsGrid}>
          {cards.map((card) => (
            <Link
              key={card.id}
              to={card.link}
              className={styles.card}
            >
              {/* Card Image with actual photo */}
              <div className={styles.cardImage}>
                <div className={`${styles.imagePlaceholder} ${styles[`bg${card.id}`]}`}>
                  <img src={card.image} alt={card.title} className={styles.cardImg} />
                </div>
              </div>

              {/* Card Content */}
              <div className={styles.cardContent}>
                <p className={styles.category}>{card.category}</p>
                <h3 className={styles.cardTitle}>{card.title}</h3>
                <p className={styles.description}>{card.description}</p>
                <span className={styles.readMore}>Learn More →</span>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};

export default InfoCards;
