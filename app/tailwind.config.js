import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/View/Composers/**/*.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                // Define a Plus Jakarta Sans como a fonte sans padrão do sistema
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
