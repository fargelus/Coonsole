const { VueLoaderPlugin } = require('vue-loader');
const path = require('path');

module.exports = {
  mode: 'development',
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
        test: /\.css$/,
        loader: 'style-loader!css-loader',
      },
      {
        test: /\.(gif|png|jpe?g|svg)$/,
        loader: 'file-loader',
      },
    ],
  },
  plugins: [
    new VueLoaderPlugin(),
  ],
};
