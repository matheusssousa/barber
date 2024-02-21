/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        barber_pretocinza: '#121212',
        barber_marrom: '#977656',
        barber_bege: '#F2DAC2',
        barber_preto: '#050505'
      },
    },
  },
  plugins: [],
}