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
            animation: {
                'pulse-emphasized': 'pulse-emphasized 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
