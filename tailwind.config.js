/** @type {import('tailwindcss').Config} */
const path = require('path');
module.exports = {
  content: [
    './**/*.{html,js,php}',
    '*/*.{html,js,php}',
    // './index.html',
    // '/index1.html',
    // './*.html',
    // './lv/*.{html,js}',
    // './de/*.{html,js}',
    // './fr/*.{html,js}',
    // './ru/*.{html,js}',
    // './ru/*.{html,js}',
    // './js/*.{html,js}',
  ],
  theme: {
    extend: {
      fontFamily: {
        'Alpha': ['Alpha', 'sans-serif'],
        'Formular': ['Formular', 'sans-serif'],
         },
      colors: {
        clifford: '#da373d',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'), 
      ],
}

