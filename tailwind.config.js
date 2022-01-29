module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                backgroundColor: "#1E1D2B",
                highlighted: "#6C5FCF",
                inputLabel: "#9595A2",
                elevatedColor: "#373c4d",
                elevatedDark: "#242536",
                linecolor: "#20202B",
                sidenavSelected: "#9891ce",
            },
            gridTemplateRows: {
          '[auto,auto,1fr]': 'auto auto 1fr',
        },
        },
        fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
        }
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
    ],
}
