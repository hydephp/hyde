const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './_site/**/*.html',
    ],
    
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        lineHeight: '1.5em',
                        h2: {
                            marginBottom: '0.75em',
                            marginTop: '1.5em',
                        },
                        a: {
                            color: '#6366f1',
                            '&:hover': {
                                color: '#4338ca',
                            },
                            textDecoration: 'none'
                        },
                        blockquote: {
                            lineHeight: '1.25em',
                            paddingLeft: '0.75em',
                            'p::before': {
                                content: 'unset',
                            },
                            'p::after': {
                                content: 'unset',
                            },
                        }
                    },
                },
            },
        },
    },
    
    plugins: [
        require('@tailwindcss/typography')
    ],
};
