const webpack = require('webpack');
const path = require('path');

const CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const HtmlWebpackExternalsPlugin = require('html-webpack-externals-plugin')

var extractSass = new ExtractTextPlugin('css/all.css');

const pathSRC = 'webroot_src';
const pathBuild = 'webroot';

module.exports = {
    entry: {
        index: './' + pathSRC + '/js/index.js'
    },

    output: {
        filename: 'js/[name].bundle.js',
        path: path.resolve(__dirname, pathBuild)
    },
    module: {
        rules: [
            {
                test: /\.scss$/i,
                loader: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                                importLoaders: 3
                            }
                        }, {
                            loader: 'postcss-loader', options: {sourceMap: true}
                        }, {
                            loader: 'resolve-url-loader'
                        }, {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                })
            },
            {
                test: /\.(png|svg|jpg|gif|svg)$/,
                use: [
                    'file-loader?name=../webroot/images/render/[name].[ext]'
                ]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    'file-loader?name=../webroot/fonts/[name].[ext]'
                ]
            }

        ]
    },
    plugins: [
        new CopyWebpackPlugin([{
            from: path.resolve(__dirname, pathSRC + '/images'),
            to: path.resolve(__dirname, pathBuild + '/images')
        },
            {
                from: path.resolve(__dirname, pathSRC + '/fonts'),
                to: path.resolve(__dirname, pathBuild + '/fonts')
            },
            {
                from: path.resolve(__dirname, pathSRC + '/mailTemplate'),
                to: path.resolve(__dirname, pathBuild + '/mailTemplate')
            }
        ]),

        new webpack.optimize.CommonsChunkPlugin({
            name: 'commons',
            filename: 'js/commons.bundle.js'
        }),

        extractSass,

        new webpack.ProvidePlugin({
            $: "jquery",
            jquery: 'jquery',
            jQuery: "jquery",
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default'],
            SE: path.resolve(__dirname, pathSRC + '/js/_main.js')

        })
    ],
    devtool: process.env.NODE_ENV === 'development' ? 'source-map' : ''
};
