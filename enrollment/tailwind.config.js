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
                primary: '#6c5ce7', /* deep purple */
                secondary: '#fd79a8', /* warm pink */
                accent: '#00cec9', /* teal */
                brand: {
                    DEFAULT: '#6c5ce7',
                    muted: '#a29bfe',
                    warm: '#e84393'
                },
                neutral: {
                    100: '#f8f9fb',
                    200: '#eef2f6',
                    500: '#6b7280',
                    700: '#374151'
                }
            },
            boxShadow: {
                'brand-lg': '0 20px 60px rgba(108,92,231,0.18)'
            },
        },
    },

    plugins: [forms],
};
