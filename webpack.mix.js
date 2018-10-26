const { mix } = require('laravel-mix');
const glob = require('@alexbinary/glob');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

var transpile = new Promise((resolve) => {
  mix.js('resources/assets/js/app.js', 'public/dist/js')
    .sass('resources/assets/sass/app.scss', 'public/dist/css');

  resolve();
})

transpile.then(() => {
  glob('public/dist/css/*.css').then((files) => {
    mix.styles(files, 'public/dist/bundle.css').version();
  });

  glob('public/dist/js/*.js').then((files) => {
    mix.styles(files, 'public/dist/bundle.js').version();
  });
});

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