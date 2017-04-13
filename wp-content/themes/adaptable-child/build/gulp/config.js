var src = './src';
var dest = '..';

module.exports = {
    sass: {
        src: src + '/scss/**/*.scss',
        dest: dest + '/',
        settings: {
            indentedSyntax: true,
            imagePath: 'images',
            outputStyle: 'nested',
            includePaths: [].concat(
                require('node-bourbon').includePaths,
                require('node-neat').includePaths,
                require('node-normalize-scss').includePaths
            )
        }
    },
    images: {
        src: src + '/images/**',
        dest: dest + '/assets/images/'
    },
    bundler: {
        modules: src + '/js/',
        entries: src + '/js/main.js',
        dest: dest + '/js',
        outputName: 'bundle.js',
        debug: 'true'
    }
};
