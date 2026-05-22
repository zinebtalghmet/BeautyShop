import { fetchProducts, fetchFeaturedProducts, fetchProductBySlug, fetchCategories } from '../services/productService';

let cachedProducts = null;

async function ensureProducts() {
  if (!cachedProducts) {
    const result = await fetchProducts({ per_page: 100 });
    cachedProducts = result.data;
  }
  return cachedProducts;
}

export const getFeaturedProducts = async () => {
  try {
    return await fetchFeaturedProducts();
  } catch {
    return [];
  }
};

export const getProductsByCategory = async (category) => {
  try {
    const products = await ensureProducts();
    return products.filter(p => p.category === category);
  } catch {
    return [];
  }
};

export const getProductById = async (id) => {
  try {
    const products = await ensureProducts();
    return products.find(p => p.id === parseInt(id)) || null;
  } catch {
    return null;
  }
};

export const getProductBySlug = async (slug) => {
  try {
    return await fetchProductBySlug(slug);
  } catch {
    return null;
  }
};

export const getCategories = async () => {
  try {
    return await fetchCategories();
  } catch {
    return [];
  }
};

export const getProducts = async (params = {}) => {
  try {
    cachedProducts = null;
    const result = await fetchProducts(params);
    return result.data;
  } catch {
    return [];
  }
};

export const getProductsSync = () => {
  return cachedProducts || [];
};
