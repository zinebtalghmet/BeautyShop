import React, { useState, useEffect } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { getProductBySlug, getProducts } from '../data/products';
import { useCart } from '../context/CartContext';
import { getProductImage, getProductImagePath } from '../utils/imageHelper';
import styles from '../styles/ProductDetail.module.css';

const ProductDetail = () => {
  const { slug } = useParams();
  const navigate = useNavigate();
  const { addToCart, isInCart, getItemQuantity } = useCart();

  const [product, setProduct] = useState(null);
  const [relatedProducts, setRelatedProducts] = useState([]);
  const [quantity, setQuantity] = useState(1);
  const [selectedImage, setSelectedImage] = useState(0);
  const [showAddedMessage, setShowAddedMessage] = useState(false);
  const [openAccordion, setOpenAccordion] = useState(null);

  useEffect(() => {
    async function load() {
      const foundProduct = await getProductBySlug(slug);
      if (foundProduct) {
        setProduct(foundProduct);
        setQuantity(1);
        setSelectedImage(0);
        window.scrollTo(0, 0);

        const allProducts = await getProducts();
        const related = allProducts
          .filter(p => p.category === foundProduct.category && p.id !== foundProduct.id)
          .slice(0, 4);
        setRelatedProducts(related);
      } else {
        navigate('/shop');
      }
    }
    load();
  }, [slug, navigate]);

  if (!product) {
    return <div className={styles.loading}>Loading...</div>;
  }

  const handleAddToCart = () => {
    addToCart(product, quantity);
    setShowAddedMessage(true);
    setTimeout(() => setShowAddedMessage(false), 3000);
  };

  const increaseQuantity = () => {
    if (quantity < product.stock) {
      setQuantity(quantity + 1);
    }
  };

  const decreaseQuantity = () => {
    if (quantity > 1) {
      setQuantity(quantity - 1);
    }
  };

  const toggleAccordion = (section) => {
    setOpenAccordion(openAccordion === section ? null : section);
  };

  return (
    <div className={styles.productDetail}>
      <div className={styles.container}>
        <nav className={styles.breadcrumb}>
          <Link to="/">Home</Link>
          <span>/</span>
          <Link to="/shop">Shop</Link>
          <span>/</span>
          <span className={styles.currentPage}>{product.name}</span>
        </nav>

        <div className={styles.productMain}>
          <div className={styles.productImages}>
            <div className={styles.mainImage}>
              <img src={getProductImagePath(product.images[selectedImage])} alt={product.name} style={{width:'100%',height:'100%',objectFit:'contain'}} />
              {product.discount > 0 && (
                <div className={styles.discountBadge}>-{product.discount}%</div>
              )}
            </div>
            {product.images && product.images.length > 1 && (
              <div className={styles.thumbnails}>
                {product.images.map((img, index) => (
                  <div
                    key={index}
                    className={`${styles.thumbnail} ${selectedImage === index ? styles.active : ''}`}
                    onClick={() => setSelectedImage(index)}
                  >
                    <img src={getProductImagePath(img)} alt="" style={{width:'100%',height:'100%',objectFit:'cover'}} />
                  </div>
                ))}
              </div>
            )}
          </div>

          <div className={styles.productInfo}>
            <div className={styles.category}>{product.category}</div>
            <h1 className={styles.productName}>{product.name}</h1>

            <div className={styles.rating}>
              <span className={styles.stars}>★★★★★</span>
              <span className={styles.ratingValue}>{product.rating}</span>
              <span className={styles.reviews}>({product.reviews} reviews)</span>
            </div>

            <div className={styles.priceSection}>
              <span className={styles.price}>${product.price.toFixed(2)}</span>
              {product.discount > 0 && (
                <>
                  <span className={styles.originalPrice}>
                    ${product.originalPrice.toFixed(2)}
                  </span>
                  <span className={styles.savings}>
                    Save ${(product.originalPrice - product.price).toFixed(2)}
                  </span>
                </>
              )}
            </div>

            <div className={styles.stockStatus}>
              {product.stock > 0 ? (
                <span className={styles.inStock}>
                  ✓ In Stock ({product.stock} available)
                </span>
              ) : (
                <span className={styles.outOfStock}>Out of Stock</span>
              )}
            </div>

            <p className={styles.description}>{product.description}</p>

            {product.stock > 0 && (
              <div className={styles.actions}>
                <div className={styles.quantitySelector}>
                  <button onClick={decreaseQuantity} disabled={quantity <= 1}>
                    −
                  </button>
                  <span>{quantity}</span>
                  <button onClick={increaseQuantity} disabled={quantity >= product.stock}>
                    +
                  </button>
                </div>

                <button className={styles.addToCartBtn} onClick={handleAddToCart}>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  Add to Cart
                </button>
              </div>
            )}

            {showAddedMessage && (
              <div className={styles.addedMessage}>
                ✓ Product added to cart!
              </div>
            )}

            {isInCart(product.id) && (
              <div className={styles.inCartNotice}>
                This product is in your cart ({getItemQuantity(product.id)} items)
                <Link to="/cart" className={styles.viewCartLink}>View Cart</Link>
              </div>
            )}
          </div>
        </div>

        <div className={styles.benefitsSection}>
          <h2 className={styles.sectionTitle}>Why You'll Love It</h2>
          <div className={styles.benefitsGrid}>
            <div className={styles.benefitCard}>
              <div className={styles.benefitIcon}>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"></path>
                  <path d="M12 6v6l4 2"></path>
                </svg>
              </div>
              <h3>Quick Results</h3>
              <p>Visible improvements in just 2 weeks of consistent use</p>
            </div>

            <div className={styles.benefitCard}>
              <div className={styles.benefitIcon}>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
              </div>
              <h3>Skin Friendly</h3>
              <p>Dermatologist tested and suitable for all skin types</p>
            </div>

            <div className={styles.benefitCard}>
              <div className={styles.benefitIcon}>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M12 2v20M2 12h20"></path>
                  <circle cx="12" cy="12" r="10"></circle>
                </svg>
              </div>
              <h3>Natural Ingredients</h3>
              <p>Made with organic, cruelty-free ingredients</p>
            </div>

            <div className={styles.benefitCard}>
              <div className={styles.benefitIcon}>
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
              </div>
              <h3>Quality Assured</h3>
              <p>Premium formulation backed by beauty experts</p>
            </div>
          </div>
        </div>

        <div className={styles.accordionContainer}>
          <div className={styles.accordionItem}>
            <button
              className={`${styles.accordionHeader} ${openAccordion === 'ingredients' ? styles.active : ''}`}
              onClick={() => toggleAccordion('ingredients')}
            >
              <span>What's Inside</span>
              <svg
                className={styles.accordionIcon}
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
              >
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </button>
            {openAccordion === 'ingredients' && (
              <div className={styles.accordionContent}>
                <p className={styles.accordionText}>
                  Our carefully selected blend includes premium ingredients designed to nourish and enhance your natural beauty:
                </p>
                <ul className={styles.ingredientsList}>
                  {product.features && product.features.map((feature, index) => (
                    <li key={index}><strong>{feature}</strong></li>
                  ))}
                  <li><strong>Hyaluronic Acid</strong> - Deep hydration and plumping</li>
                  <li><strong>Vitamin C</strong> - Brightening and antioxidant protection</li>
                  <li><strong>Natural Botanical Extracts</strong> - Soothing and nourishing</li>
                  <li><strong>Essential Oils</strong> - Aromatherapy benefits</li>
                </ul>
                <p className={styles.accordionNote}>
                  All ingredients are cruelty-free, vegan-friendly, and sustainably sourced.
                </p>
              </div>
            )}
          </div>

          <div className={styles.accordionItem}>
            <button
              className={`${styles.accordionHeader} ${openAccordion === 'usage' ? styles.active : ''}`}
              onClick={() => toggleAccordion('usage')}
            >
              <span>How to Use</span>
              <svg
                className={styles.accordionIcon}
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
              >
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </button>
            {openAccordion === 'usage' && (
              <div className={styles.accordionContent}>
                <div className={styles.usageSteps}>
                  <div className={styles.usageStep}>
                    <div className={styles.stepNumber}>1</div>
                    <div className={styles.stepContent}>
                      <h4>Cleanse</h4>
                      <p>Start with clean, dry skin. Gently pat your face with a towel to remove excess moisture.</p>
                    </div>
                  </div>
                  <div className={styles.usageStep}>
                    <div className={styles.stepNumber}>2</div>
                    <div className={styles.stepContent}>
                      <h4>Apply</h4>
                      <p>Dispense a small amount onto your fingertips. Gently massage into skin using upward, circular motions.</p>
                    </div>
                  </div>
                  <div className={styles.usageStep}>
                    <div className={styles.stepNumber}>3</div>
                    <div className={styles.stepContent}>
                      <h4>Enjoy</h4>
                      <p>Allow the product to absorb fully. Use morning and night for best results.</p>
                    </div>
                  </div>
                </div>
                <p className={styles.proTip}>
                  <strong>Pro Tip:</strong> For enhanced results, apply to slightly damp skin to lock in extra moisture.
                </p>
              </div>
            )}
          </div>

          <div className={styles.accordionItem}>
            <button
              className={`${styles.accordionHeader} ${openAccordion === 'reviews' ? styles.active : ''}`}
              onClick={() => toggleAccordion('reviews')}
            >
              <span>Customer Reviews ({product.reviews})</span>
              <svg
                className={styles.accordionIcon}
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
              >
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </button>
            {openAccordion === 'reviews' && (
              <div className={styles.accordionContent}>
                <div className={styles.reviewsOverview}>
                  <div className={styles.ratingLarge}>
                    <span className={styles.ratingNumber}>{product.rating}</span>
                    <div>
                      <div className={styles.starsLarge}>★★★★★</div>
                      <p>Based on {product.reviews} reviews</p>
                    </div>
                  </div>
                </div>

                <div className={styles.reviewsList}>
                  <div className={styles.reviewItem}>
                    <div className={styles.reviewHeader}>
                      <span className={styles.reviewStars}>★★★★★</span>
                      <span className={styles.reviewAuthor}>Sarah M.</span>
                    </div>
                    <p className={styles.reviewText}>
                      "Absolutely love this product! My skin feels so much softer and looks more radiant. Will definitely repurchase."
                    </p>
                  </div>

                  <div className={styles.reviewItem}>
                    <div className={styles.reviewHeader}>
                      <span className={styles.reviewStars}>★★★★★</span>
                      <span className={styles.reviewAuthor}>Emily R.</span>
                    </div>
                    <p className={styles.reviewText}>
                      "Amazing quality! I've tried many products but this one really delivers. Highly recommend!"
                    </p>
                  </div>

                  <div className={styles.reviewItem}>
                    <div className={styles.reviewHeader}>
                      <span className={styles.reviewStars}>★★★★☆</span>
                      <span className={styles.reviewAuthor}>Jessica L.</span>
                    </div>
                    <p className={styles.reviewText}>
                      "Great product overall. Noticed improvements after a few weeks. Good value for the price."
                    </p>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>

        {relatedProducts.length > 0 && (
          <div className={styles.relatedProducts}>
            <h2 className={styles.relatedTitle}>Related Products</h2>
            <div className={styles.relatedGrid}>
              {relatedProducts.map(relatedProduct => (
                <Link
                  key={relatedProduct.id}
                  to={`/product/${relatedProduct.slug}`}
                  className={styles.relatedCard}
                >
                  <div className={styles.relatedImage}>
                    {getProductImage(relatedProduct) ? (
                      <img src={getProductImage(relatedProduct)} alt={relatedProduct.name}
                           className={styles.relatedProductImg} />
                    ) : (
                      <div className={styles.relatedImagePlaceholder}></div>
                    )}
                    {relatedProduct.discount > 0 && (
                      <div className={styles.relatedBadge}>-{relatedProduct.discount}%</div>
                    )}
                  </div>
                  <div className={styles.relatedInfo}>
                    <h4>{relatedProduct.name}</h4>
                    <div className={styles.relatedPrice}>
                      <span className={styles.currentPrice}>${relatedProduct.price.toFixed(2)}</span>
                      {relatedProduct.discount > 0 && (
                        <span className={styles.oldPrice}>${relatedProduct.originalPrice.toFixed(2)}</span>
                      )}
                    </div>
                  </div>
                </Link>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default ProductDetail;
