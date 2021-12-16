module.exports = {
    mode: 'jit',
    purge: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                backgroundColor: "#1E1D2B",
                inputLabel: "#9595A2",
                elevatedColor: "#323c50",
            }
        },
        fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
        }
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
