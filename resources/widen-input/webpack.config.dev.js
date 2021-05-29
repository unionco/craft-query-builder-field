'use strict'
const path = require('path');
const webpack = require('webpack')
const merge = require('webpack-merge')
const baseConfig = require('./webpack.config.base')

const HOST = 'localhost'
const PORT = 3000

module.exports = merge(baseConfig, {
  mode: 'development',

  devServer: {
    clientLogLevel: 'warning',
    hot: true,
    contentBase: 'dist',
    compress: true,
    host: HOST,
    port: PORT,
    open: false,
    overlay: { warnings: false, errors: false },
    publicPath: '/',
    quiet: false,
    disableHostCheck: true,
    watchContentBase: true
  },

  entry: {
    main: path.resolve(__dirname, 'src/index.js'),
  },

  output: {
    filename: 'js/[name].js',
    path: path.resolve(__dirname, '../../src/assetbundles/widenassetfield/dist'),
    publicPath: '/'
  },

  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          'vue-style-loader',
          'css-loader'
        ]
      }, {
        test: /\.styl(us)?$/,
        use: [
          'vue-style-loader',
          'css-loader',
          'stylus-loader'
        ]
      }
    ]
  },

  plugins: [
    new webpack.HotModuleReplacementPlugin()
  ]
})
