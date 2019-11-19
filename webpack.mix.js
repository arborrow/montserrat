const mix = require('laravel-mix');
const glob = require('@alexbinary/glob');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

mix.js('resources/assets/js/app.js', 'public/dist/bundle.js')
    .sass('resources/assets/sass/app.scss', 'public/dist/bundle.css').version()
    .sass('resources/assets/sass/print-envelope10.scss', 'public/dist/print-envelope10.css')
    .sass('resources/assets/sass/print-envelope9x6.scss', 'public/dist/print-envelope9x6.css')
    .sass('resources/assets/sass/print-landscape.scss', 'public/dist/print-landscape.css')
    .sass('resources/assets/sass/print-style.scss', 'public/dist/print-style.css');

// Only in production
mix.webpackConfig({
    plugins: [
        //Compress images
        new CopyWebpackPlugin([{
            from: 'resources/assets/images',
            to: 'images/',
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i,
            pngquant: {
                quality: '65-80'
            },
            plugins: [
                imageminMozjpeg({
                    quality: 65,
                    // Set the maximum memory to use in kbytes
                    maxMemory: 1000 * 512
                })
            ]
        })
    ],
});
