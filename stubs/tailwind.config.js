const colors = require('tailwindcss/colors')

module.exports = {
    theme: {
        screens: {
            sm: '480px',
            md: '768px',
            lg: '976px',
            xl: '1440px',
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            indigo: colors.indigo,
            red: colors.red,
            pink: colors.pink,
            green: colors.emerald,
            yellow: colors.amber,
            purple: colors.violet,
            blue: colors.blue,
            'light-blue': colors.sky,
            cyan: colors.cyan,
        },
        fontFamily: {
            sans: ['Graphik', 'sans-serif'],
            serif: ['Merriweather', 'serif'],
        },
        extend: {
            spacing: {
                '128': '32rem',
                '144': '36rem',
            },
            borderRadius: {
                '4xl': '2rem',
            }
        }
    },
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/sdkconsultoria/base/views/*.blade.php',
        './vendor/sdkconsultoria/base/views/**/*.blade.php',
        './vendor/sdkconsultoria/base/src/Helpers/Html/*.php',
        './vendor/sdkconsultoria/base/src/Helpers/Html/**/*.php',
        './vendor/sdkconsultoria/base/resources/**/*.vue',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    daisyui: {
        themes: ['light', 'dark', 'emerald', 'halloween']
    },
    plugins: [
        require('postcss-import'),
        require('tailwindcss'),
        // require('@tailwindcss/forms'),
        require('autoprefixer'),
        require('daisyui'),
    ],
}
