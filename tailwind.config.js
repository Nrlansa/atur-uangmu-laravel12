import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        "./app/Models/**/*.php",
    ],
    safelist: [
    'bg-emerald-500',
    'bg-amber-500',
    'bg-rose-500',
    'text-emerald-600',
    'text-amber-600',
    'text-rose-600',
    'bg-emerald-50',
    'bg-amber-50',
    'bg-rose-50',
  ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
