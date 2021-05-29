'use strict'

// const HtmlWebpackPlugin = require('html-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const { VueLoaderPlugin } = require('vue-loader')

const utils = require('./utils')

module.exports = {
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue: 'vue/dist/vue.js',
    }
  },

  module: {
    rules: [
      {
        test: /\.vue$/,
        use: 'vue-loader'
      }, {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        }
      }, {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        use: {
          loader: 'url-loader',
          options: {
            limit: 10000,
            name: utils.assetsPath('img/[name].[hash:7].[ext]')
          }
        }
      }, {
        test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
        use: {
          loader: 'url-loader',
          options: {
            limit: 10000,
            name: utils.assetsPath('media/[name].[hash:7].[ext]')
          }
        }
      }, {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        use: {
          loader: 'url-loader',
          options: {
            limit: 10000,
            name: utils.assetsPath('fonts/[name].[hash:7].[ext]')
          }
        }
      }
    ]
  },

  plugins: [
    // new HtmlWebpackPlugin({
    //   filename: 'index.html',
    //   template: 'index.html',
    //   inject: true
    // }),
    new VueLoaderPlugin(),
    // new CopyWebpackPlugin({
    //   patterns: [
    //     {
    //       from: utils.resolve('widen-input/dist/main.js'),
    //       to: utils.resolve('../src/assetbundles/widenassetfield/dist/js'),
    //     }
    //   ],
    // })
    // new CopyWebpackPlugin([{
    //   from: utils.resolve('widen-input/dist/main.js'),
    //   to: utils.resolve('../src/assetbundles/widenassetfield/dist/js'),
    // }]),
    // new CopyWebpackPlugin([{
    //   from: utils.resolve('static/img'),
    //   to: utils.resolve('dist/static/img'),
    //   toType: 'dir'
    // }])
  ]
}
