import React, { createContext, useContext, useState, useEffect, useCallback } from 'react';
import * as cartService from '../services/cartService';

const CartContext = createContext();

export const useCart = () => {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error('useCart must be used within a CartProvider');
  }
  return context;
};

function transformApiItem(item) {
  const p = item.product || {};
  return {
    id: p.id,
    name: p.name || '',
    slug: p.slug || '',
    category: p.category_id || '',
    price: parseFloat(p.price) || 0,
    originalPrice: parseFloat(p.original_price) || 0,
    discount: p.discount || 0,
    description: p.description || '',
    features: p.features || [],
    rating: p.rating || 0,
    stock: p.stock || 0,
    images: p.images ? p.images.map(i => i.image) : [],
    featured: p.is_featured || false,
    quantity: item.quantity,
    _cartItemId: item.id,
  };
}

export const CartProvider = ({ children }) => {
  const [cartItems, setCartItems] = useState([]);
  const [cartItemMap, setCartItemMap] = useState({});

  const buildMap = useCallback((items) => {
    const map = {};
    items.forEach(item => {
      if (item.id) map[item.id] = item._cartItemId;
    });
    setCartItemMap(map);
  }, []);

  useEffect(() => {
    cartService.fetchCart()
      .then(data => {
        const transformed = data.map(transformApiItem);
        setCartItems(transformed);
        buildMap(transformed);
      })
      .catch(() => {
        setCartItems([]);
      });
  }, [buildMap]);

  const addToCart = useCallback(async (product, quantity = 1) => {
    try {
      const result = await cartService.addToCartApi(product.id, quantity);
      const data = await cartService.fetchCart();
      const transformed = data.map(transformApiItem);
      setCartItems(transformed);
      buildMap(transformed);
      return result;
    } catch {
      // fallback: update local state optimistically
      setCartItems(prev => {
        const existing = prev.find(item => item.id === product.id);
        if (existing) {
          return prev.map(item =>
            item.id === product.id ? { ...item, quantity: item.quantity + quantity } : item
          );
        }
        return [...prev, { ...product, quantity }];
      });
    }
  }, [buildMap]);

  const removeFromCart = useCallback(async (productId) => {
    const cartItemId = cartItemMap[productId];
    if (cartItemId) {
      try {
        await cartService.removeCartItem(cartItemId);
        setCartItems(prev => prev.filter(item => item.id !== productId));
        setCartItemMap(prev => {
          const next = { ...prev };
          delete next[productId];
          return next;
        });
      } catch {
        setCartItems(prev => prev.filter(item => item.id !== productId));
      }
    } else {
      setCartItems(prev => prev.filter(item => item.id !== productId));
    }
  }, [cartItemMap]);

  const updateQuantity = useCallback(async (productId, quantity) => {
    if (quantity <= 0) {
      removeFromCart(productId);
      return;
    }
    setCartItems(prev =>
      prev.map(item =>
        item.id === productId ? { ...item, quantity } : item
      )
    );
    const cartItemId = cartItemMap[productId];
    if (cartItemId) {
      try {
        await cartService.updateCartItemQuantity(cartItemId, quantity);
      } catch {
        // refetch on error
        const data = await cartService.fetchCart();
        setCartItems(data.map(transformApiItem));
      }
    }
  }, [cartItemMap, removeFromCart]);

  const increaseQuantity = useCallback((productId) => {
    setCartItems(prev => {
      const item = prev.find(i => i.id === productId);
      if (item) updateQuantity(productId, item.quantity + 1);
      return prev;
    });
  }, [updateQuantity]);

  const decreaseQuantity = useCallback((productId) => {
    setCartItems(prev => {
      const item = prev.find(i => i.id === productId);
      if (item && item.quantity > 1) {
        updateQuantity(productId, item.quantity - 1);
      } else if (item) {
        removeFromCart(productId);
      }
      return prev;
    });
  }, [updateQuantity, removeFromCart]);

  const clearCart = useCallback(async () => {
    try {
      await cartService.clearCartApi();
    } catch {
      // proceed anyway
    }
    setCartItems([]);
    setCartItemMap({});
  }, []);

  const getCartCount = useCallback(() => {
    return cartItems.reduce((total, item) => total + item.quantity, 0);
  }, [cartItems]);

  const getSubtotal = useCallback(() => {
    return cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
  }, [cartItems]);

  const isInCart = useCallback((productId) => {
    return cartItems.some(item => item.id === productId);
  }, [cartItems]);

  const getItemQuantity = useCallback((productId) => {
    const item = cartItems.find(item => item.id === productId);
    return item ? item.quantity : 0;
  }, [cartItems]);

  const value = {
    cartItems,
    addToCart,
    removeFromCart,
    updateQuantity,
    increaseQuantity,
    decreaseQuantity,
    clearCart,
    getCartCount,
    getSubtotal,
    isInCart,
    getItemQuantity,
  };

  return <CartContext.Provider value={value}>{children}</CartContext.Provider>;
};

export default CartContext;
