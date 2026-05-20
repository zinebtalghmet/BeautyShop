/**
 * Home Page
 * Main landing page that displays:
 * - Hero banner
 * - Featured products
 * - Sale banner
 * - Info cards
 */

import React from 'react';
import Hero from '../components/Hero';
import FeaturedProducts from '../components/FeaturedProducts';
import SaleBanner from '../components/SaleBanner';
import InfoCards from '../components/InfoCards';

const Home = () => {
  return (
    <div>
      {/* Hero Section with main headline */}
      <Hero />

      {/* Featured Products Grid */}
      <FeaturedProducts />

      {/* Spring Sale Promotional Banner */}
      <SaleBanner />

      {/* Information Cards Section */}
      <InfoCards />
    </div>
  );
};

export default Home;
