/**
 * Image Helper Utility
 * Helps generate correct image paths for products
 */

export const getProductImagePath = (imageName) => {
  return `${process.env.PUBLIC_URL}/images/products/${imageName}`;
};

export const getProductImage = (product) => {
  if (product.images && product.images.length > 0) {
    return getProductImagePath(product.images[0]);
  }
  return null;
};
