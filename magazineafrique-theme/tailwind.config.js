/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './assets/js/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        'sahel-emerald': '#B45309',
        'sahel-dark': '#072714',
        'savannah-gold': '#D97706',
        'savannah-light': '#F59E0B',
        'terracotta': '#C2410C',
        'paper-ground': '#FAF8F5',
        'paper-surface': '#FFFFFF',
        'paper-muted': '#F3EFEA',
        'border-parchment': '#E8E2D8',
        'ink-headline': '#1C1917',
        'ink-body': '#292524',
        'ink-muted': '#66615B',
      },
      fontFamily: {
        serif: ['Newsreader', 'Georgia', 'serif'],
        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
