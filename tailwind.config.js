module.exports = {
    // purge: {
    //       enabled: true,
    //       content:[
    //           './resources/**/*.blade.php',
    //           './resources/**/*.js',
    //           './resources/**/**/*.blade.php',
    //       ]
    // },
    darkMode: false, // or 'media' or 'class'
    theme: {
      extend: {
        colors: {
          blue: {
            '250': '#77ACF1',
            '350': '#6283e8',
            '450': '#505fe0',
            '550': '#260FCE'
          }
        },
        fontFamily: {
          'raleway': ['Raleway', 'sans-serif'],
          'roboto': ['Roboto', 'sans-serif'],
        },
        fill: theme => ({
          white: theme('colors.white')
        })
      },
    },
    variants: {
      extend: {
        fontWeight: ['hover', 'focus', 'active'],
        borderWidth: ['hover', 'focus', 'active'],
        fontSize: ['hover', 'focus', 'active'],
        borderRadius: ['hover', 'focus', 'active'],
        fill: ['hover', 'focus', 'active'],
        backgroundColor: ["checked"],
        borderColor: ["checked"],
        inset: ["checked"],
        zIndex: ["hover", "active"],
      },
    },
    plugins: [
      require('@tailwindcss/forms'),
    ],
  }
