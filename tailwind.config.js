/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/*.blade.php",
        "./resources/views/pages/*.blade.php",
        "./resources/views/pages/**/*.blade.php",
        "./resources/views/layouts/*.blade.php",
        "./resources/views/payments/*.blade.php",
    ],
    theme: {

        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: "100ch", // add required value here
                    },
                },
            },
        },
    },
    plugins: [require("@tailwindcss/typography"), require("daisyui")],
    daisyui: {
        styled: true,
        themes: true,
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        themes: [
            "night",
          ],
    },
};
