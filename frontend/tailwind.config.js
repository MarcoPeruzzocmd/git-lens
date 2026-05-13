/** @type {import('tailwindcss').Config} */
export default {
  darkMode: ['class'],
  content: [
    './index.html',
    './src/**/*.{js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        background: '#0d1117',
        surface: '#161b22',
        border: '#30363d',
        muted: '#21262d',
        primary: '#6366f1',
        'primary-hover': '#4f46e5',
        foreground: '#e6edf3',
        subtle: '#8b949e',
        faint: '#484f58',
      },
      fontFamily: {
        sans: ['Space Grotesk', 'Segoe UI', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'],
        gothic: ['Science Gothic', 'sans-serif'],
      },
      borderRadius: {
        lg: '12px',
        md: '8px',
        sm: '6px',
      },
    },
  },
  plugins: [],
}
