const STORAGE_URL = process.env.REACT_APP_STORAGE_URL || 'http://localhost:8000/storage';

export const getProductImagePath = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith('http')) return imagePath;
  return `${STORAGE_URL}/${imagePath}`;
};

export const getProductImage = (product) => {
  if (product.images && product.images.length > 0) {
    return getProductImagePath(product.images[0]);
  }
  return null;
};
