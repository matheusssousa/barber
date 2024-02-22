/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        barber_preto: '#050505',
        barber_pretocinza: '#121212',
        barber_cinza: '#141414',
        barber_cinzaclaro: '#343434',
        barber_cinzaescuro: '#1E1E1E',
        barber_marrom: '#977656',
        barber_bege: '#F2DAC2',
      },
    },
  },
  plugins: [],
}