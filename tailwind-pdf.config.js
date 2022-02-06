module.exports = {
    content: [
        './resources/views/documents/**/*.blade.php',
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
                whiteHighlight: "#F5F2F2",
            },
            gridTemplateRows: {
              '[auto,auto,1fr]': 'auto auto 1fr',
            },
            transitionProperty: {
                'size': 'width, height, font-size',
            },
            transitionTimingFunction: {
                'overshoot': 'cubic-bezier(.65,0,.18,1.67)',
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
