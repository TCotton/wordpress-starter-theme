const path = require('path');

module.exports = {
  context: path.resolve(__dirname, './resources/js/'),
  entry: {
    app: './script.js'
  },
  output: {
    path: path.resolve(__dirname, './resources/js/dist'),
    filename: '[name].bundle.js'
  },

  mode: 'development',

  module: {

    rules: [

      {
        test: /\.js?$/,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }]
      },

      {
        test: /\.(sass|scss)$/,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader'
        ]
      }

    ]

  },


  performance: {
    hints: 'warning', // enum
    maxAssetSize: 200000, // int (in bytes),
    maxEntrypointSize: 400000, // int (in bytes)
    assetFilter: function(assetFilename) {
      // Function predicate that provides asset filenames
      return assetFilename.endsWith('.css') || assetFilename.endsWith('.js');
    }
  }

};