import api from './api';

function transformProduct(p) {
  return {
    id: p.id,
    name: p.name,
    slug: p.slug,
    category: p.category ? p.category.slug : (p.category_id ? String(p.category_id) : ''),
    category_id: p.category_id,
    price: p.price,
    originalPrice: p.original_price ?? p.price,
    discount: p.discount ?? 0,
    description: p.description || '',
    features: p.features || [],
    rating: p.rating || 0,
    reviews: p.reviews_count || 0,
    stock: p.stock || 0,
    images: p.images && p.images.length > 0 ? p.images.map(i => i.image) : [],
    featured: p.is_featured || false,
  };
}

function transformCategory(c) {
  return {
    id: c.slug,
    name: c.name,
    count: c.products_count || 0,
  };
}

export async function fetchProducts(params = {}) {
  const query = {};
  if (params.category && params.category !== 'all') query.category = params.category;
  if (params.featured) query.featured = true;
  if (params.in_stock) query.in_stock = true;
  if (params.min_price !== undefined) query.min_price = params.min_price;
  if (params.max_price !== undefined) query.max_price = params.max_price;
  if (params.search) query.search = params.search;
  if (params.sort) query.sort = params.sort;
  if (params.per_page) query.per_page = params.per_page;

  const res = await api.get('/products', { params: query });
  return {
    data: res.data.data.map(transformProduct),
    meta: res.data.meta,
  };
}

export async function fetchFeaturedProducts() {
  const res = await api.get('/products/featured');
  return res.data.data.map(transformProduct);
}

export async function fetchProductBySlug(slug) {
  const res = await api.get(`/products/${slug}`);
  return transformProduct(res.data.data);
}

export async function fetchCategories() {
  const res = await api.get('/categories');
  return res.data.data.map(transformCategory);
}
