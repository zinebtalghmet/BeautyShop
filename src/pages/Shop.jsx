/**
 * Shop Page
 * Product listing page with:
 * - Category filters
 * - Price range filter
 * - Sort options
 * - Pagination
 * - Product grid
 */

import React, { useState, useEffect } from 'react';
import { useSearchParams, Link } from 'react-router-dom';
import { products, getCategories } from '../data/products';
import { getProductImage } from '../utils/imageHelper';
import styles from '../styles/Shop.module.css';

const Shop = () => {
  const [searchParams, setSearchParams] = useSearchParams();
  const [filteredProducts, setFilteredProducts] = useState(products);
  const [currentPage, setCurrentPage] = useState(1);
  const [sortBy, setSortBy] = useState('featured');
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [priceRange, setPriceRange] = useState([0, 100]);

  const productsPerPage = 9;
  const categories = getCategories();

  // Apply filters and sorting
  useEffect(() => {
    let filtered = [...products];

    // Category filter
    if (selectedCategory !== 'all') {
      filtered = filtered.filter(product => product.category === selectedCategory);
    }

    // Price range filter
    filtered = filtered.filter(product =>
      product.price >= priceRange[0] && product.price <= priceRange[1]
    );

    // Sorting
    switch (sortBy) {
      case 'price-low':
        filtered.sort((a, b) => a.price - b.price);
        break;
      case 'price-high':
        filtered.sort((a, b) => b.price - a.price);
        break;
      case 'name':
        filtered.sort((a, b) => a.name.localeCompare(b.name));
        break;
      case 'rating':
        filtered.sort((a, b) => b.rating - a.rating);
        break;
      default:
        // Featured first
        filtered.sort((a, b) => (b.featured ? 1 : 0) - (a.featured ? 1 : 0));
    }

    setFilteredProducts(filtered);
    setCurrentPage(1); // Reset to first page when filters change
  }, [selectedCategory, priceRange, sortBy]);

  // Pagination
  const indexOfLastProduct = currentPage * productsPerPage;
  const indexOfFirstProduct = indexOfLastProduct - productsPerPage;
  const currentProducts = filteredProducts.slice(indexOfFirstProduct, indexOfLastProduct);
  const totalPages = Math.ceil(filteredProducts.length / productsPerPage);

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  return (
    <div className={styles.shopPage}>
      <div className={styles.container}>
        {/* Page Header */}
        <div className={styles.pageHeader}>
          <h1 className={styles.pageTitle}>Shop All Products</h1>
          <p className={styles.productCount}>
            Showing {indexOfFirstProduct + 1}-{Math.min(indexOfLastProduct, filteredProducts.length)} of {filteredProducts.length} products
          </p>
        </div>

        <div className={styles.shopContent}>
          {/* Sidebar Filters */}
          <aside className={styles.sidebar}>
            {/* Category Filter */}
            <div className={styles.filterSection}>
              <h3 className={styles.filterTitle}>Categories</h3>
              <div className={styles.filterOptions}>
                <label className={styles.filterOption}>
                  <input
                    type="radio"
                    name="category"
                    value="all"
                    checked={selectedCategory === 'all'}
                    onChange={(e) => setSelectedCategory(e.target.value)}
                  />
                  <span>All Products ({products.length})</span>
                </label>
                {categories.map(cat => (
                  <label key={cat.id} className={styles.filterOption}>
                    <input
                      type="radio"
                      name="category"
                      value={cat.id}
                      checked={selectedCategory === cat.id}
                      onChange={(e) => setSelectedCategory(e.target.value)}
                    />
                    <span>{cat.name} ({cat.count})</span>
                  </label>
                ))}
              </div>
            </div>

            {/* Price Range Filter */}
            <div className={styles.filterSection}>
              <h3 className={styles.filterTitle}>Price Range</h3>
              <div className={styles.priceRange}>
                <input
                  type="range"
                  min="0"
                  max="100"
                  value={priceRange[1]}
                  onChange={(e) => setPriceRange([0, parseInt(e.target.value)])}
                  className={styles.rangeSlider}
                />
                <div className={styles.priceLabels}>
                  <span>${priceRange[0]}</span>
                  <span>${priceRange[1]}</span>
                </div>
              </div>
            </div>

            {/* Reset Filters */}
            <button
              className={styles.resetBtn}
              onClick={() => {
                setSelectedCategory('all');
                setPriceRange([0, 100]);
                setSortBy('featured');
              }}
            >
              Reset Filters
            </button>
          </aside>

          {/* Main Content Area */}
          <main className={styles.mainContent}>
            {/* Sort Options */}
            <div className={styles.toolbar}>
              <label className={styles.sortLabel}>
                Sort by:
                <select
                  value={sortBy}
                  onChange={(e) => setSortBy(e.target.value)}
                  className={styles.sortSelect}
                >
                  <option value="featured">Featured</option>
                  <option value="price-low">Price: Low to High</option>
                  <option value="price-high">Price: High to Low</option>
                  <option value="name">Name: A-Z</option>
                  <option value="rating">Highest Rated</option>
                </select>
              </label>
            </div>

            {/* Products Grid */}
            {currentProducts.length > 0 ? (
              <>
                <div className={styles.productsGrid}>
                  {currentProducts.map(product => (
                    <div key={product.id} className={styles.productCard}>
                      {/* Discount Badge */}
                      {product.discount > 0 && (
                        <div className={styles.discountBadge}>-{product.discount}%</div>
                      )}

                      {/* Product Image */}
                      <Link to={`/product/${product.slug}`} className={styles.productImageLink}>
                        <div className={styles.productImage}>
                          <img src={getProductImage(product)} alt={product.name} className={styles.productImg} />
                        </div>
                      </Link>

                      {/* Product Info */}
                      <div className={styles.productInfo}>
                        <Link to={`/product/${product.slug}`}>
                          <h3 className={styles.productName}>{product.name}</h3>
                        </Link>
                        <p className={styles.productCategory}>{product.category}</p>

                        {/* Rating */}
                        <div className={styles.rating}>
                          <span className={styles.stars}>★★★★★</span>
                          <span className={styles.ratingText}>({product.reviews})</span>
                        </div>

                        {/* Price */}
                        <div className={styles.priceSection}>
                          <span className={styles.price}>${product.price.toFixed(2)}</span>
                          {product.discount > 0 && (
                            <span className={styles.originalPrice}>
                              ${product.originalPrice.toFixed(2)}
                            </span>
                          )}
                        </div>

                        {/* View Product Button */}
                        <Link to={`/product/${product.slug}`} className={styles.viewBtn}>
                          View Details
                        </Link>
                      </div>
                    </div>
                  ))}
                </div>

                {/* Pagination */}
                {totalPages > 1 && (
                  <div className={styles.pagination}>
                    <button
                      onClick={() => paginate(currentPage - 1)}
                      disabled={currentPage === 1}
                      className={styles.pageBtn}
                    >
                      Previous
                    </button>

                    {[...Array(totalPages)].map((_, index) => (
                      <button
                        key={index + 1}
                        onClick={() => paginate(index + 1)}
                        className={`${styles.pageBtn} ${currentPage === index + 1 ? styles.active : ''}`}
                      >
                        {index + 1}
                      </button>
                    ))}

                    <button
                      onClick={() => paginate(currentPage + 1)}
                      disabled={currentPage === totalPages}
                      className={styles.pageBtn}
                    >
                      Next
                    </button>
                  </div>
                )}
              </>
            ) : (
              <div className={styles.noProducts}>
                <p>No products found matching your filters.</p>
                <button onClick={() => {
                  setSelectedCategory('all');
                  setPriceRange([0, 100]);
                }} className={styles.resetBtn}>
                  Reset Filters
                </button>
              </div>
            )}
          </main>
        </div>
      </div>
    </div>
  );
};

export default Shop;
