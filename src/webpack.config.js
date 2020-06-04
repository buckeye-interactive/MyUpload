const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const PATHS = {
    app: path.resolve(__dirname, 'resources/js'),
    base: path.resolve(__dirname, 'resources'),
    entry: path.resolve(__dirname, 'resources/js/app.js'),
    font: path.resolve(__dirname, 'resources/fonts'),
    image: path.resolve(__dirname, 'resources/images'),
    sass: path.resolve(__dirname, 'resources/sass/app.scss'),
    public: path.resolve(__dirname, 'public/assets'),
};

module.exports = (env) => ({
    entry: PATHS.entry,
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                loader: 'babel-loader',
                include: PATHS.app,
            },
            {
                test: /\.scss/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: 'css-loader',
                        options: { importLoaders: 1 },
                    },
                    'resolve-url-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            data: '$primary: ' + env.COLOR + ';',
                        },
                    },
                ],
                include: PATHS.base,
            },
            {
                test: /\.(png|jpe?g|gif|svg|woff2?|eot|ttf|otf)(\?.*)?$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 500,
                            name: 'media/[path][name].[ext]',
                        },
                    },
                ],
                include: [PATHS.font, PATHS.image],
            },
        ],
    },
    resolve: {
        alias: {
            style: PATHS.sass,
        },
        extensions: ['*', '.js', '.jsx'],
    },
    output: {
        path: PATHS.public,
        filename: 'bundle.js',
        publicPath: '/assets/',
    },
    plugins: [
        new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // all options are optional
            filename: '[name].css',
            chunkFilename: '[id].css',
            ignoreOrder: false, // Enable to remove warnings about conflicting order
        }),
    ],
    devtool: 'cheap-module-eval-source-map',
    devServer: {
        disableHostCheck: true,
        port: 3000,
        public: env ? env.DOMAIN : 'localhost',
        overlay: true,
    },
});
