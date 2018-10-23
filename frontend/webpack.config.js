const { VueLoaderPlugin } = require('vue-loader');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');

// postcss plugins
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

module.exports = {
    mode: 'development',
    watch: true,
    entry: [
        './ts/main.ts',
    ],
    optimization: {
        minimize: true,
    },
    output: {
        path: path.resolve(__dirname, './../public/'),
        filename: 'bundle.js',
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: "ts-loader",
                exclude: ["node_modules"],
                options: {
                    configFile: 'tsconfig.json',
                    appendTsSuffixTo: [/\.vue$/]
                }
            },
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
            {
                test: /\.(ttf|woff(2)?|eot)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'fonts/',
                        },
                    }],
            },
        ],
    },
    resolve: {
        extensions: ['.ts', '.js', '.vue', '.json'],
        alias: {
            vue: 'vue/dist/vue.js',
        },
    },
    plugins: [
        new VueLoaderPlugin(),
        new CopyWebpackPlugin([{
            from: 'assets/cities.json',
            to: 'data/',
        }]),
    ],
};
