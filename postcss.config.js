module.exports = {
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
        process.env.NODE_ENV === 'production' && require('@fullhuman/postcss-purgecss')({
            content: [
                './src/**/*.js',
                './src/**/*.jsx',
                './resources/views/**/*.blade.php'
            ],
            defaultExtractor: content => content.match(/[A-za-z0-8-_:/]+/g) || []
        })
    ]
}