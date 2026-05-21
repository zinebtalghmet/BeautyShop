# Quick Start Guide

## 🚀 Get Started in 3 Steps

### 1️⃣ Install Dependencies
```bash
cd beauty-shop
npm install
```

### 2️⃣ Start the App
```bash
npm start
```

### 3️⃣ Open in Browser
The app will automatically open at: **http://localhost:3000**

---

## 📂 File Structure Quick Reference

```
beauty-shop/
├── src/
│   ├── components/          # All React components
│   │   ├── Header.jsx       # Navigation bar
│   │   ├── Hero.jsx         # Main banner
│   │   ├── FeaturedProducts.jsx
│   │   ├── ProductCard.jsx  # Reusable card
│   │   ├── SaleBanner.jsx
│   │   ├── InfoCards.jsx
│   │   └── Footer.jsx
│   ├── styles/              # CSS Modules
│   │   └── *.module.css     # Component styles
│   ├── App.jsx              # Main component
│   ├── index.jsx            # Entry point
│   └── index.css            # Global styles
└── public/
    └── index.html           # HTML template
```

---

## 🎨 Key Components

| Component | Purpose |
|-----------|---------|
| **Header** | Top banner + navigation |
| **Hero** | Main headline section |
| **FeaturedProducts** | Product grid (5 items) |
| **ProductCard** | Individual product card |
| **SaleBanner** | Sale promotion section |
| **InfoCards** | Information cards (3 items) |
| **Footer** | Bottom section with links |

---

## 🔧 Common Tasks

### Add a New Product
Edit `src/components/FeaturedProducts.jsx`:
```jsx
const products = [
  // ... existing products
  {
    id: 6,
    title: 'NEW PRODUCT',
    subtitle: 'Description here',
    discount: '-20%',
    hasDiscount: true
  }
];
```

### Change Colors
Edit any `.module.css` file:
```css
/* Change primary color */
background: linear-gradient(135deg, #yourColor 0%, #yourColor 100%);
```

### Replace Placeholder Images
Replace `<div className={styles.imagePlaceholder}></div>` with:
```jsx
<img src="/images/product.jpg" alt="Product" />
```

---

## 📱 Responsive Breakpoints

- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: < 768px

---

## ✅ Checklist Before Review

- [ ] Run `npm install`
- [ ] Run `npm start`
- [ ] Check localhost:3000 in browser
- [ ] Test responsive design (resize browser)
- [ ] Verify all sections are visible
- [ ] Check hover effects work

---

## 🆘 Troubleshooting

**Port already in use?**
```bash
# Kill process on port 3000 (Windows)
npx kill-port 3000

# Then restart
npm start
```

**Dependencies error?**
```bash
# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

**Module not found?**
```bash
# Clear cache and reinstall
npm cache clean --force
npm install
```

---

## 📋 Next Steps After Review

1. ✅ Review single page functionality
2. ⏭️ Discuss additional pages to implement
3. ⏭️ Add routing (React Router)
4. ⏭️ Implement state management
5. ⏭️ Add backend integration

---

**Ready to go! Run `npm install` and `npm start` to see the page.**
