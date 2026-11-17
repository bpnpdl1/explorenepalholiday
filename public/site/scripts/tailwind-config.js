/**
 * Explore Nepal Holidays - Shared Tailwind CSS Configuration
 * Centralized design tokens for all reusable pages.
 */
window.tailwind = window.tailwind || {};
window.tailwind.config = {
  corePlugins: {
    preflight: false,
  },
  theme: {
    extend: {
      colors: {
        'brand-navy': '#0b2b50',
        'brand-deep': '#08223e',
        'brand-blue': '#1764a5',
        'brand-orange': '#ff9d22',
        'brand-orange-hover': '#e68a15',
        'brand-cream': '#f7f4ed',
        'brand-paper': '#fffefa',
        'brand-ink': '#1e3449',
        'brand-muted': '#657484',
        'brand-line': '#dedfdd',
        navy: {
          DEFAULT: '#0b2b50',
          deep: '#08223e',
          light: '#143d6c',
        },
        blue: {
          brand: '#1764a5',
          light: '#257ec8',
        },
        orange: {
          brand: '#ff9d22',
          hover: '#e68a15',
          light: '#fff5e6',
        },
        cream: '#f7f4ed',
        paper: '#fffefa',
        ink: '#1e3449',
        muted: '#657484',
        line: '#dedfdd',
      },
      fontFamily: {
        sans: ['DM Sans', 'Arial', 'sans-serif'],
        display: ['Outfit', 'sans-serif'],
        outfit: ['Outfit', 'sans-serif'],
      },
      maxWidth: {
        container: '1280px',
      },
      borderRadius: {
        brand: '0.5rem',
      },
      boxShadow: {
        brand: '0 20px 45px rgba(8, 34, 62, 0.11)',
        card: '0 4px 20px rgba(8, 34, 62, 0.08)',
        dropdown: '0 12px 32px rgba(8, 34, 62, 0.15)',
      },
    },
  },
};

// Also support commonjs for tooling
if (typeof module !== 'undefined' && module.exports) {
  module.exports = window.tailwind.config;
}
