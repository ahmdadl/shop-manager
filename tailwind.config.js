const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    darkMode: 'class',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        animation: ['responsive', 'hover'],
        backgroundColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'dark',
            'dark:hover',
            'dark:focus',
        ],
        backgroundImage: [
            'disabled',
            'dark',
            'dark:hover',
            'dark:focus',
            'responsive',
        ],
        borderColor: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'group-hover',
            'dark',
            'dark:hover',
            'dark:focus',
        ],
        boxShadow: [
            'disabled',
            'hover',
            'focus',
            'active',
            'invalid',
            'dark',
            'dark:hover',
            'dark:focus',
        ],
        cursor: ['disabled', 'hover'],
        gradientColorStops: [
            'responsive',
            'dark',
            'dark:hover',
            'dark:focus',
            'hover',
            'focus',
        ],
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        outline: ['invalid', 'hover', 'focus', 'disabled'],
        textColor: [
            'invalid',
            'hover',
            'disabled',
            'group-hover',
            'dark',
            'dark:hover',
            'dark:focus',
        ],
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
