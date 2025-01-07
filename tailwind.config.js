import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                customOrange: "#FFB472",
            },
            screens: {
                xs: "360px", // Tambahkan breakpoint untuk smartphone kecil
                "md-max": { max: "640px" }, // Custom untuk layar besar tetapi di bawah 2xl
            },
        },
    },
    plugins: [],
};
