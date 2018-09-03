const { VueLoaderPlugin } = require('vue-loader');
const path = require('path');
const webpack = require('webpack');

// postcss plugins
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

module.exports = {
  mode: 'development',
  watch: true,
  entry: [
    './js/main.js',
  ],
  output: {
    path: path.resolve(__dirname, './../public/'),
    filename: 'bundle.js',
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader',
      },
      {
        test: /\.styl$/,
        use: [
          'vue-style-loader',
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              ident: 'postcss',
              plugins: [
                autoprefixer(),
                cssnano(),
              ],
            },
          },
          'stylus-loader',
        ],
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/,
        loader: 'file-loader',
      },
    ],
  },
  resolve: {
      alias: {
          vue: 'vue/dist/vue.js',
      },
  },
  plugins: [
    new VueLoaderPlugin(),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
    }),
  ],
};
