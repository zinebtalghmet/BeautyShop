import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { getProducts, getCategories } from '../data/products';
import { getProductImage } from '../utils/imageHelper';
import styles from '../styles/Shop.module.css';

const Shop = () => {
  const [allProducts, setAllProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [filteredProducts, setFilteredProducts] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [sortBy, setSortBy] = useState('featured');
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [priceRange, setPriceRange] = useState([0, 1000]);
  const [loading, setLoading] = useState(true);

  const productsPerPage = 9;

  useEffect(() => {
    Promise.all([
      getProducts(),
      getCategories(),
    ]).then(([products, cats]) => {
      setAllProducts(products);
      setCategories(cats);
      setLoading(false);
    });
  }, []);

  useEffect(() => {
    let filtered = [...allProducts];

    if (selectedCategory !== 'all') {
      filtered = filtered.filter(product => product.category === selectedCategory);
    }

    filtered = filtered.filter(product =>
      product.price >= priceRange[0] && product.price <= priceRange[1]
    );

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
        filtered.sort((a, b) => (b.featured ? 1 : 0) - (a.featured ? 1 : 0));
    }

    setFilteredProducts(filtered);
    setCurrentPage(1);
  }, [allProducts, selectedCategory, priceRange, sortBy]);

  const indexOfLastProduct = currentPage * productsPerPage;
  const indexOfFirstProduct = indexOfLastProduct - productsPerPage;
  const currentProducts = filteredProducts.slice(indexOfFirstProduct, indexOfLastProduct);
  const totalPages = Math.ceil(filteredProducts.length / productsPerPage);

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  if (loading) {
    return (
      <div className={styles.shopPage}>
        <div className={styles.container}>
          <div className={styles.pageHeader}>
            <h1 className={styles.pageTitle}>Shop All Products</h1>
          </div>
          <p style={{ textAlign: 'center', padding: '40px 0', color: '#999' }}>Loading products...</p>
        </div>
      </div>
    );
  }

  return (
    <div className={styles.shopPage}>
      <div className={styles.container}>
        <div className={styles.pageHeader}>
          <h1 className={styles.pageTitle}>Shop All Products</h1>
          <p className={styles.productCount}>
            Showing {indexOfFirstProduct + 1}-{Math.min(indexOfLastProduct, filteredProducts.length)} of {filteredProducts.length} products
          </p>
        </div>

        <div className={styles.shopContent}>
          <aside className={styles.sidebar}>
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
                  <span>All Products ({allProducts.length})</span>
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

            <div className={styles.filterSection}>
              <h3 className={styles.filterTitle}>Price Range</h3>
              <div className={styles.priceRange}>
                  <input
                    type="range"
                    min="0"
                    max="1000"
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

            <button
              className={styles.resetBtn}
              onClick={() => {
                setSelectedCategory('all');
                setPriceRange([0, 1000]);
                setSortBy('featured');
              }}
            >
              Reset Filters
            </button>
          </aside>

          <main className={styles.mainContent}>
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

            {currentProducts.length > 0 ? (
              <>
                <div className={styles.productsGrid}>
                  {currentProducts.map(product => (
                    <div key={product.id} className={styles.productCard}>
                      {product.discount > 0 && (
                        <div className={styles.discountBadge}>-{product.discount}%</div>
                      )}

                      <Link to={`/product/${product.slug}`} className={styles.productImageLink}>
                        <div className={styles.productImage}>
                          <img src={getProductImage(product)} alt={product.name} className={styles.productImg} />
                        </div>
                      </Link>

                      <div className={styles.productInfo}>
                        <Link to={`/product/${product.slug}`}>
                          <h3 className={styles.productName}>{product.name}</h3>
                        </Link>
                        <p className={styles.productCategory}>{product.category}</p>

                        <div className={styles.rating}>
                          <span className={styles.stars}>★★★★★</span>
                          <span className={styles.ratingText}>({product.reviews})</span>
                        </div>

                        <div className={styles.priceSection}>
                          <span className={styles.price}>${product.price.toFixed(2)}</span>
                          {product.discount > 0 && (
                            <span className={styles.originalPrice}>
                              ${product.originalPrice.toFixed(2)}
                            </span>
                          )}
                        </div>

                        <Link to={`/product/${product.slug}`} className={styles.viewBtn}>
                          View Details
                        </Link>
                      </div>
                    </div>
                  ))}
                </div>

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
                  setPriceRange([0, 1000]);
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
