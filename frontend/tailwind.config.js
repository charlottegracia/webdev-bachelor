/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./app.vue",
    "./error.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        primary: ["DM Sans", "sans-serif"]
      },
      colors: {
        text: {
          'default': '#292D33',
          'secondary': '#42464C',
          'tertiary': '#60656C',
          'homegrey': '#4B4F54',
          'lightgrey': '#6F7276',
        },
        home: {
          'bg': '#FAFAF8',
          'mocca-25': '#FAFAF8',
          'mocca': '#EFE7DB',
          'mocca-200': '#E2D5BF',
          'mocca-300': '#302E29',
          'grape': '#D1D4F0',
          'grape-200': '#BABEE3',
          'grape-300': '#383C70',
          'raspberry': '#F0D1DE',
          'raspberry-200': '#E3BACB',
          'raspberry-300': '#63324D',
          'kiwi': '#C1E6D3',
          'kiwi-200': '#ABD9C1',
          'kiwi-300': '#264D32',
          'lemon': '#F7E794',
          'lemon-200': '#EBDA81',
          'lemon-300': '#524029',
          'tangerine': '#F0AB84',
          'tangerine-200': '#E39A71',
          'tangerine-300': '#402626',
        },
        homeblue: {
          '08': '#EBF1FB',
          '12': '#D7E4F8',
          '100': '#0456D1',
          '120': '#0547A9',
          '300': '#16405F',
        },
      },
      maxWidth: {
        'content': '1320px'
      },
    },
  },
  plugins: [],
}

