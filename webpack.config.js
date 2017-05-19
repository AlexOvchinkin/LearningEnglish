
module.exports = {
    context: __dirname + "/src/js",
    entry: {
        AJAX: "./AJAX",
        Selection: "./Selection",
        Vocabulary: "./Vocabulary",
        Translate: "./Translate"
    },
    devtool: "source-map",
    output: {
        path:  __dirname + "/src/js/public",
        filename: "[name].js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }
            }
        ]
    }
}