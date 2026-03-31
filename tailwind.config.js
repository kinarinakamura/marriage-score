/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Zen Maru Gothic"', 'sans-serif'],
            },
            colors: {
                konkatsu: {
                    pink: '#FF6B8A',
                    'pink-light': '#FFE0E8',
                    'pink-dark': '#E8456A',
                    orange: '#FFB347',
                    'orange-light': '#FFF0D4',
                    mint: '#7DDBB5',
                    'mint-light': '#E0F7ED',
                    lavender: '#B8A9E8',
                    'lavender-light': '#EDE8FF',
                    bg: '#FFF9F5',
                },
            },
        },
    },
    plugins: [require('daisyui')],
    daisyui: {
        themes: false, // カスタムテーマのみ使用
    },
}
