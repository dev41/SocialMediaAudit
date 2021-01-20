let path = require('path'),
    glob = require("glob"),
    _ = require('lodash');

const JS_DIST_DIR = path.resolve(__dirname, 'www/js/dist/routes'),
    JS_SOURCE_DIR = path.resolve(__dirname, 'www/js/app/routes');

module.exports = {
    // change to production in feature
    mode: 'development',
    // devtool: "eval",
    // devtool: "cheap-eval-source-map",
    // devtool: "cheap-module-eval-source-map",
    // devtool: "eval-source-map",
    // devtool: "cheap-source-map",
    // devtool: "cheap-module-source-map",
    // devtool: "inline-cheap-source-map",
    // devtool: "inline-cheap-module-source-map",
    // devtool: "source-map",
    // devtool: "inline-source-map",
    // devtool: "hidden-source-map",
    // devtool: "nosources-source-map",
    entry: Object.assign({},
        _.reduce(glob.sync(JS_SOURCE_DIR + '/*.js'),
            (obj, val) => {
                const filenameRegex = /[\w-]+(?:\.\w+)*$/i;
                obj[val.match(filenameRegex)[0]] = val;
                return obj;
            },
            {}),
        {}),
    output: {
        publicPath: '/',
        filename: '[name]',
        path: JS_DIST_DIR
    }
};