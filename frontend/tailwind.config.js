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
        primary: "#ff0000",
        josefine: "#00ff00",
        tertiary: "#0000ff",
      }, 
    },
  },
  plugins: [],
}

