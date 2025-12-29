import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Fredoka One'],
            },
            colors: {
                /* New palette: coral / navy / sunny yellow */
                primary: '#ff6b6b', /* coral */
                secondary: '#1b4965', /* deep navy */
                accent: '#ffe66d', /* sunny yellow */
                brand: {
                    DEFAULT: '#ff6b6b',
                    muted: '#ffd6c2',
                    warm: '#ff8fa3'
                },
                neutral: {
                    100: '#f6f7f9',
                    200: '#eef2f6',
                    500: '#6b7280',
                    700: '#2d3748'
                }
            },
            boxShadow: {
                'brand-lg': '0 20px 60px rgba(108,92,231,0.18)'
            },
        },
    },

    plugins: [forms],
};
