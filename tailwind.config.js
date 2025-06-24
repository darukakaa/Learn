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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                customBlack: '#000000',
                customGrayDark: '#666666',
                customGrayMedium: '#979797',
                customGrayLight: 'white',
                customBlue: '#565449',
                customwhite: '#daf1de',
                custombone: '#d8cfbc',
                customold: '#f7f8e5',
            },
        },
    },

    plugins: [forms],
};
