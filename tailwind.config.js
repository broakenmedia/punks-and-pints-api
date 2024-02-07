import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'ipa': {
                    '50': '#fef8ee',
                    '100': '#fcefd8',
                    '200': '#f8dab0',
                    '300': '#f4bf7d',
                    '400': '#ee9a49',
                    '500': '#ea7e25',
                    '600': '#db651b',
                    '700': '#b64d18',
                    '800': '#913d1b',
                    '900': '#753419',
                    '950': '#3f180b',
                },
            }
        },
    },

    plugins: [forms],
};
