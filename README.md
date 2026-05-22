# Beauty E-commerce Single Page Application

A Fancy modern, responsive beauty e-commerce single-page application built with **React** and **CSS Modules**. This project replicates a professional beauty product showcase with clean design, smooth animations, and full mobile responsiveness.

---

## 📋 Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Installation & Setup](#installation--setup)
- [Components Overview](#components-overview)
- [Styling Approach](#styling-approach)
- [Responsive Design](#responsive-design)
- [Customization](#customization)
- [Browser Support](#browser-support)

---

## ✨ Features

- ✅ **Single Page Application** - All sections on one page
- ✅ **Fully Responsive** - Works on desktop, tablet, and mobile devices
- ✅ **Component-Based Architecture** - Reusable React components
- ✅ **CSS Modules** - Scoped and modular styling
- ✅ **Modern Design** - Rose/pink color scheme with gradient backgrounds
- ✅ **Smooth Animations** - Hover effects and transitions
- ✅ **Clean Code** - Well-commented and organized
- ✅ **Placeholder Images** - Ready for real product images
- ✅ **Dummy Data** - Sample product information included

---

## 📁 Project Structure

```
beauty-shop/
├── public/
│   └── index.html                 # HTML template
├── src/
│   ├── components/
│   │   ├── Header.jsx             # Top banner and navigation
│   │   ├── Hero.jsx               # Main banner with headline
│   │   ├── FeaturedProducts.jsx   # Product grid section
│   │   ├── ProductCard.jsx        # Individual product card
│   │   ├── SaleBanner.jsx         # Promotional sale section
│   │   ├── InfoCards.jsx          # Information cards section
│   │   └── Footer.jsx             # Bottom section with links
│   ├── styles/
│   │   ├── App.module.css         # Main app styles
│   │   ├── Header.module.css      # Header component styles
│   │   ├── Hero.module.css        # Hero component styles
│   │   ├── FeaturedProducts.module.css
│   │   ├── ProductCard.module.css
│   │   ├── SaleBanner.module.css
│   │   ├── InfoCards.module.css
│   │   └── Footer.module.css
│   ├── App.jsx                    # Main App component
│   ├── index.jsx                  # React entry point
│   └── index.css                  # Global styles
├── package.json                   # Dependencies and scripts
└── README.md                      # This file
```

---

## 🛠 Technologies Used

- **React 18.2.0** - JavaScript library for building user interfaces
- **React DOM 18.2.0** - React rendering for web
- **React Scripts 5.0.1** - Create React App build tools
- **CSS Modules** - Scoped and modular CSS styling
- **Google Fonts** - Montserrat font family
- **SVG Icons** - Scalable vector graphics for icons

---

## 🚀 Installation & Setup

### Prerequisites

Make sure you have the following installed on your system:
- **Node.js** (version 14.0.0 or higher)
- **npm** (comes with Node.js) or **yarn**

### Step 1: Navigate to Project Directory

```bash
cd beauty-shop
```

### Step 2: Install Dependencies

Using npm:
```bash
npm install
```

Or using yarn:
```bash
yarn install
```

### Step 3: Start Development Server

Using npm:
```bash
npm start
```

Or using yarn:
```bash
yarn start
```

### Step 4: View in Browser

The application will automatically open in your default browser at:
```
http://localhost:3000
```

If it doesn't open automatically, manually navigate to the URL above.

---

## 📦 Available Scripts

In the project directory, you can run:

### `npm start`
Runs the app in development mode.
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.
The page will reload when you make changes.

### `npm build`
Builds the app for production to the `build` folder.
Optimizes the build for best performance.

### `npm test`
Launches the test runner in interactive watch mode.

### `npm eject`
**Note: this is a one-way operation. Once you eject, you can't go back!**
Ejects from Create React App to have full control over configuration.

---

## 🧩 Components Overview

### 1. **Header Component** (`Header.jsx`)
- **Top Banner**: Promotional message with delivery info and support links
- **Main Navigation**: Logo, menu items (Skincare, Beauty Tools, Redstone, Haircare)
- **Action Buttons**: Search, account, shopping cart icons, and "BOOK NOW" CTA
- **Styling**: Rose gradient banner, clean white navigation

### 2. **Hero Component** (`Hero.jsx`)
- **Main Headline**: "Glow like never before!"
- **Subtitle**: "STARTER"
- **CTA Button**: "SHOP NOW"
- **Product Display**: Placeholder product images on sides
- **Bottom Row**: Additional product showcases
- **Styling**: Gradient background (rose/beige tones)

### 3. **FeaturedProducts Component** (`FeaturedProducts.jsx`)
- **Section Title**: "Featured Product"
- **Product Grid**: 5 product cards in a responsive grid
- **Dummy Data**: Luxsticks, Foundation, Makeup Tools, Fixing Mist, Skin Care
- **Uses**: ProductCard component for each item

### 4. **ProductCard Component** (`ProductCard.jsx`)
- **Reusable Card**: Used in FeaturedProducts grid
- **Props**: title, subtitle, discount, hasDiscount
- **Discount Badge**: Circular badge with percentage (conditional)
- **Product Image**: Placeholder with gradient background
- **Shop Link**: "Shop Now →" with hover effect

### 5. **SaleBanner Component** (`SaleBanner.jsx`)
- **Headline**: "Spring Beauty Sale - Up to 40% Off"
- **Description**: Promotional text
- **Social Dots**: Three indicator dots
- **CTA Buttons**: "SHOP NOW" (primary) and "ADD TO CART (FLORAL)" (secondary)
- **Product Display**: Right-side product showcase
- **Styling**: Gradient background matching hero

### 6. **InfoCards Component** (`InfoCards.jsx`)
- **Three Cards**: Natural Cosmetics, Modern Romance, Natural Cosmetics
- **Card Structure**: Image placeholder, category, title, description
- **Category Label**: "TRENDING"
- **Hover Effects**: Card lift and image zoom

### 7. **Footer Component** (`Footer.jsx`)
- **Service Features**: 24/7 Customer, Popular, Warranty icons with text
- **Social Media**: Facebook, Twitter, Instagram, YouTube, Pinterest links
- **Icons**: Circular icon buttons with hover effects
- **Styling**: Gradient background with icon circles

---

## 🎨 Styling Approach

### Color Palette
```css
Primary Rose: #d4a5a5
Dark Rose: #c99999
Light Background: #f5e5e5
Medium Background: #e8d5d5
Accent Background: #f0ddd5
Text Dark: #000000
Text Medium: #333333
Text Light: #666666
Text Lighter: #999999
White: #ffffff
Border: #e5e5e5
```

### Typography
- **Font Family**: Montserrat (Google Fonts)
- **Font Weights**: 300, 400, 500, 600, 700, 800
- **Headings**: Bold (700-800), larger sizes
- **Body Text**: Regular (400-500), smaller sizes
- **Labels**: Medium-small (11-13px) with letter-spacing

### CSS Modules
Each component has its own scoped CSS Module file:
- Prevents style conflicts
- Easy to maintain and debug
- Component-specific styling
- Automatic unique class names

### Animations
- **Hover Effects**: Transform, box-shadow, color transitions
- **Timing**: 0.3s ease for smooth animations
- **Lift Effects**: translateY(-5px to -10px)
- **Scale Effects**: scale(1.05 to 1.1)

---

## 📱 Responsive Design

### Breakpoints
```css
Desktop:        1200px and above
Large Tablet:   968px - 1199px
Tablet:         768px - 967px
Mobile:         481px - 767px
Small Mobile:   480px and below
```

### Responsive Features
- **Grid Adjustments**: 5 columns → 3 → 2 → 1
- **Font Scaling**: Headings and text size reduction
- **Layout Changes**: Flex-direction changes (column on mobile)
- **Hidden Elements**: Some decorative elements hidden on small screens
- **Touch-Friendly**: Larger tap targets on mobile
- **Flexible Spacing**: Reduced padding/margins on smaller screens

---

## 🔧 Customization

### Adding Real Images

Replace placeholder divs in components with `<img>` tags:

```jsx
// Before (Placeholder)
<div className={styles.imagePlaceholder}></div>

// After (Real Image)
<img src="/images/product.jpg" alt="Product Name" />
```

Store images in `public/images/` folder and reference like:
```jsx
<img src={`${process.env.PUBLIC_URL}/images/product.jpg`} alt="Product" />
```

### Changing Colors

Edit the color values in CSS Module files:

```css
/* Example: Change primary rose color */
background: linear-gradient(135deg, #yourColor 0%, #yourColor2 100%);
```

### Adding More Products

Update the `products` array in `FeaturedProducts.jsx`:

```jsx
const products = [
  {
    id: 6,
    title: 'YOUR PRODUCT',
    subtitle: 'Your description',
    discount: '-15%',
    hasDiscount: true
  },
  // ... more products
];
```

### Modifying Layout

Adjust grid columns in CSS Module files:

```css
/* Change from 5 to 4 columns */
.productsGrid {
  grid-template-columns: repeat(4, 1fr);
}
```

---

## 🌐 Browser Support

This application supports:
- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Opera (latest)

---

## 📝 Next Steps

After reviewing this single page, you can:

1. **Add More Pages**: Create separate pages for:
   - Product listings
   - Product details
   - Shopping cart
   - Checkout
   - User account

2. **Add Functionality**:
   - Product filtering and search
   - Add to cart functionality
   - User authentication
   - Payment integration
   - Order management

3. **Enhance Features**:
   - Product reviews and ratings
   - Wishlist functionality
   - Product recommendations
   - Newsletter signup
   - Live chat support

4. **Backend Integration**:
   - Connect to REST API or GraphQL
   - Database integration
   - User management
   - Order processing

---

## 🐛 Known Limitations

- Navigation menu hidden on mobile (hamburger menu not implemented)
- Placeholder images instead of real product images
- No routing (single page only)
- No state management (Redux, Context API not implemented)
- No backend integration
- No shopping cart functionality yet

These are intentional as this is a **single-page demonstration**. They can be added in future iterations.

---

## 📄 License

This project is created for educational and demonstration purposes.

---

## 🤝 Contributing

This is a demonstration project. Feel free to fork and modify as needed.

---

## 📞 Support

For issues or questions about running this project, please check:
- Node.js is properly installed
- Dependencies are installed (`npm install`)
- Port 3000 is not in use by another application

---


**Built with ❤️ using React and Laravel**

**Ready for your review! After approval, we can proceed with additional pages and features.**
