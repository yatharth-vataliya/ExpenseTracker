import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'toaster-progress': 'toaster-progress-keyframe 5s linear forwards',
                'show-toaster': 'show-toaster-keyframe 0.3s ease forwards',
                'hide-toaster': 'hide-toaster-keyframe 0.3s ease forwards',
            },
            keyframes: {
                'toaster-progress-keyframe': {
                    '100%': { width: "0px" },
                },
                'show-toaster-keyframe': {
                    "0%": {
                        transform: "translateX(100%)",
                    },
                    "40%": {
                        transform: "translateX(-5%)",
                    },
                    "100%": {
                        transform: "translateX(0%)",
                    },
                },
                'hide-toaster-keyframe': {
                    "0%": {
                        transform: "translateX(0%)",
                    },
                    "100%": {
                        transform: "translateX(calc(100% + 20px))",
                    },
                },
            },
        },
    },

    plugins: [forms],
};
