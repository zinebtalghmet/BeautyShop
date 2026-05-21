/**
 * Product Data
 * Dummy product data for the e-commerce site
 * Each product includes: id, name, category, price, discount, description, rating, stock, images
 */

export const products = [
  // SKINCARE PRODUCTS
  {
    id: 1,
    name: 'Hydrating Face Serum',
    slug: 'hydrating-face-serum',
    category: 'skincare',
    subcategory: 'serums',
    price: 45.99,
    originalPrice: 59.99,
    discount: 23,
    description: 'A lightweight, fast-absorbing serum that deeply hydrates and plumps skin. Formulated with hyaluronic acid and vitamin E for maximum moisture retention.',
    features: [
      'Hyaluronic acid for deep hydration',
      'Vitamin E for antioxidant protection',
      'Non-greasy formula',
      'Suitable for all skin types'
    ],
    rating: 4.8,
    reviews: 124,
    stock: 45,
    images: ['Hydrating Face Serum2.png'],
    featured: true
  },
  {
    id: 2,
    name: 'Vitamin C Brightening Cream',
    slug: 'vitamin-c-brightening-cream',
    category: 'skincare',
    subcategory: 'moisturizers',
    price: 38.50,
    originalPrice: 55.00,
    discount: 30,
    description: 'Illuminate your complexion with this powerful vitamin C cream. Reduces dark spots and evens skin tone while providing 24-hour hydration.',
    features: [
      'Contains 15% vitamin C',
      'Reduces hyperpigmentation',
      '24-hour moisture',
      'SPF 15 protection'
    ],
    rating: 4.6,
    reviews: 89,
    stock: 32,
    images: ['Vitamin C Brightening Cream.png'],
    featured: true
  },
  {
    id: 3,
    name: 'Gentle Cleansing Foam',
    slug: 'gentle-cleansing-foam',
    category: 'skincare',
    subcategory: 'cleansers',
    price: 24.99,
    originalPrice: 24.99,
    discount: 0,
    description: 'A soft, foaming cleanser that gently removes makeup and impurities without stripping natural oils. Perfect for daily use.',
    features: [
      'pH-balanced formula',
      'Removes makeup effectively',
      'No harsh chemicals',
      'Leaves skin soft and clean'
    ],
    rating: 4.7,
    reviews: 156,
    stock: 67,
    images: ['Gentle Cleansing Foam.png'],
    featured: false
  },

  // MAKEUP PRODUCTS
  {
    id: 4,
    name: 'Luxstick Lipstick Set',
    slug: 'luxstick-lipstick-set',
    category: 'makeup',
    subcategory: 'lips',
    price: 32.99,
    originalPrice: 46.99,
    discount: 30,
    description: 'A collection of 5 long-lasting, highly pigmented lipsticks in trending shades. Creamy formula glides on smoothly for a perfect pout.',
    features: [
      '5 luxurious shades',
      'Long-lasting formula',
      'Moisturizing ingredients',
      'Cruelty-free'
    ],
    rating: 4.9,
    reviews: 203,
    stock: 28,
    images: ['Luxstick Lipstick Set.png'],
    featured: true
  },
  {
    id: 5,
    name: 'Flawless Foundation',
    slug: 'flawless-foundation',
    category: 'makeup',
    subcategory: 'face',
    price: 42.00,
    originalPrice: 52.50,
    discount: 20,
    description: 'Achieve a flawless complexion with this lightweight, buildable foundation. Available in 20 shades to match every skin tone.',
    features: [
      '20 shade range',
      'Medium to full coverage',
      'Oil-free formula',
      '12-hour wear'
    ],
    rating: 4.7,
    reviews: 178,
    stock: 54,
    images: ['Flawless Foundation.png'],
    featured: true
  },
  {
    id: 6,
    name: 'Eyeshadow Palette - Sunset Dreams',
    slug: 'eyeshadow-palette-sunset-dreams',
    category: 'makeup',
    subcategory: 'eyes',
    price: 48.99,
    originalPrice: 48.99,
    discount: 0,
    description: 'Create endless eye looks with this 18-shade palette featuring warm neutrals, vibrant corals, and deep burgundies.',
    features: [
      '18 highly pigmented shades',
      'Matte and shimmer finishes',
      'Blendable formula',
      'Mirror included'
    ],
    rating: 4.8,
    reviews: 142,
    stock: 38,
    images: ['Eyeshadow Palette.png'],
    featured: false
  },

  // TOOLS & ACCESSORIES
  {
    id: 7,
    name: 'Professional Makeup Brush Set',
    slug: 'professional-makeup-brush-set',
    category: 'tools',
    subcategory: 'brushes',
    price: 56.99,
    originalPrice: 75.99,
    discount: 25,
    description: 'Complete 12-piece brush set with synthetic bristles. Includes face, eye, and lip brushes for professional results.',
    features: [
      '12 essential brushes',
      'Synthetic bristles',
      'Vegan and cruelty-free',
      'Storage case included'
    ],
    rating: 4.9,
    reviews: 267,
    stock: 42,
    images: ['Professional Makeup Brush Set.png'],
    featured: true
  },
  {
    id: 8,
    name: 'Makeup Fixing Mist',
    slug: 'makeup-fixing-mist',
    category: 'tools',
    subcategory: 'setting-sprays',
    price: 26.50,
    originalPrice: 26.50,
    discount: 0,
    description: 'Lock in your makeup for all-day wear with this lightweight setting spray. Keeps makeup fresh and prevents smudging.',
    features: [
      'All-day hold',
      'Lightweight formula',
      'Refreshing mist',
      'Travel-friendly size'
    ],
    rating: 4.6,
    reviews: 98,
    stock: 71,
    images: ['Makeup Fixing Mist.png'],
    featured: true
  },
  {
    id: 9,
    name: 'LED Makeup Mirror',
    slug: 'led-makeup-mirror',
    category: 'tools',
    subcategory: 'mirrors',
    price: 64.99,
    originalPrice: 64.99,
    discount: 0,
    description: 'Professional-grade mirror with adjustable LED lighting. Three light settings and 10x magnification for precise application.',
    features: [
      'Adjustable LED lighting',
      '10x magnification',
      '360° rotation',
      'USB rechargeable'
    ],
    rating: 4.8,
    reviews: 134,
    stock: 23,
    images: ['LED Makeup Mirror.png'],
    featured: false
  },

  // HAIRCARE PRODUCTS
  {
    id: 10,
    name: 'Argan Oil Hair Serum',
    slug: 'argan-oil-hair-serum',
    category: 'haircare',
    subcategory: 'treatments',
    price: 34.99,
    originalPrice: 34.99,
    discount: 0,
    description: 'Nourish and repair damaged hair with this luxurious argan oil serum. Adds shine, reduces frizz, and protects from heat.',
    features: [
      'Pure argan oil',
      'Anti-frizz formula',
      'Heat protection',
      'Suitable for all hair types'
    ],
    rating: 4.7,
    reviews: 112,
    stock: 58,
    images: ['Argan Oil Hair Serum.png'],
    featured: false
  },
  {
    id: 11,
    name: 'Volumizing Shampoo & Conditioner Set',
    slug: 'volumizing-shampoo-conditioner-set',
    category: 'haircare',
    subcategory: 'shampoo',
    price: 42.99,
    originalPrice: 42.99,
    discount: 0,
    description: 'Add body and bounce to fine hair with this volumizing duo. Sulfate-free formula cleanses gently while adding lift.',
    features: [
      'Sulfate-free',
      'Adds volume',
      'Color-safe',
      'Paraben-free'
    ],
    rating: 4.5,
    reviews: 87,
    stock: 34,
    images: ['Volumizing Shampoo Set.png'],
    featured: false
  },
  {
    id: 12,
    name: 'Deep Conditioning Hair Mask',
    slug: 'deep-conditioning-hair-mask',
    category: 'haircare',
    subcategory: 'treatments',
    price: 29.99,
    originalPrice: 39.99,
    discount: 25,
    description: 'Intensive treatment mask that repairs and strengthens damaged hair. Use weekly for silky, healthy-looking locks.',
    features: [
      'Intensive repair',
      'Keratin-enriched',
      'Weekly treatment',
      'Salon results at home'
    ],
    rating: 4.9,
    reviews: 201,
    stock: 46,
    images: ['Deep Conditioning Hair Mask.png'],
    featured: false
  },

  // ADDITIONAL PRODUCTS
  {
    id: 13,
    name: 'Rose Water Toner',
    slug: 'rose-water-toner',
    category: 'skincare',
    subcategory: 'toners',
    price: 22.99,
    originalPrice: 22.99,
    discount: 0,
    description: 'Refreshing rose water toner that balances skin pH and tightens pores. Natural formula suitable for sensitive skin.',
    features: [
      'Pure rose water',
      'Balances pH',
      'Tightens pores',
      'Alcohol-free'
    ],
    rating: 4.6,
    reviews: 76,
    stock: 62,
    images: ['Rose Water Toner.png'],
    featured: false
  },
  {
    id: 14,
    name: 'Glow Highlighter Palette',
    slug: 'glow-highlighter-palette',
    category: 'makeup',
    subcategory: 'face',
    price: 35.99,
    originalPrice: 35.99,
    discount: 0,
    description: 'Four stunning highlighter shades to add luminous glow to your face. Silky powder formula blends seamlessly.',
    features: [
      '4 shade palette',
      'Silky powder texture',
      'Long-lasting glow',
      'Buildable coverage'
    ],
    rating: 4.8,
    reviews: 143,
    stock: 39,
    images: ['Glow Highlighter Palette.png'],
    featured: false
  },
  {
    id: 15,
    name: 'Beauty Blender Sponge Set',
    slug: 'beauty-blender-sponge-set',
    category: 'tools',
    subcategory: 'sponges',
    price: 18.99,
    originalPrice: 24.99,
    discount: 24,
    description: 'Set of 3 makeup sponges for flawless foundation application. Expands when wet for smooth, airbrushed finish.',
    features: [
      '3-piece set',
      'Latex-free',
      'Reusable',
      'Multiple colors'
    ],
    rating: 4.7,
    reviews: 189,
    stock: 95,
    images: ['Beauty Blender Sponge Set.png'],
    featured: false
  }
];

// Get featured products
export const getFeaturedProducts = () => {
  return products.filter(product => product.featured);
};

// Get products by category
export const getProductsByCategory = (category) => {
  return products.filter(product => product.category === category);
};

// Get product by ID
export const getProductById = (id) => {
  return products.find(product => product.id === parseInt(id));
};

// Get product by slug
export const getProductBySlug = (slug) => {
  return products.find(product => product.slug === slug);
};

// Get all categories
export const getCategories = () => {
  return [
    { id: 'skincare', name: 'Skincare', count: products.filter(p => p.category === 'skincare').length },
    { id: 'makeup', name: 'Makeup', count: products.filter(p => p.category === 'makeup').length },
    { id: 'tools', name: 'Tools & Accessories', count: products.filter(p => p.category === 'tools').length },
    { id: 'haircare', name: 'Haircare', count: products.filter(p => p.category === 'haircare').length }
  ];
};
