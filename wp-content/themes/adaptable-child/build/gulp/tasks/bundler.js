const gulp               = require('gulp');
const sourcemaps         = require('gulp-sourcemaps');
const rollup             = require('gulp-rollup');
const rollupIncludePaths = require('rollup-plugin-includepaths');
const eslint             = require('rollup-plugin-eslint');
const nodeResolve        = require('rollup-plugin-node-resolve');
const commonjs           = require('rollup-plugin-commonjs');
const babel              = require('gulp-babel');
const rename             = require('gulp-rename');
const util               = require('gulp-util');
const config             = require('../config');

const includePathOptions = {
    paths: [config.bundler.modules]
};

gulp.task('bundlejs', () => {
    return gulp.src(config.bundler.entries)
        .pipe(rollup({
            sourceMap: true,
            plugins: [
                nodeResolve({ jsnext: true }),
                commonjs(),
                rollupIncludePaths(includePathOptions),
                eslint({})
            ]
        }))
        .pipe(babel())
        .on('error', util.log)
        .pipe(rename('bundle.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(config.bundler.dest));
});


// var browserify   = require('browserify');
// var watchify     = require('watchify');
// var babelify     = require('babelify');
// var gulp         = require('gulp');
// var gutil        = require('gulp-util');
// var sourcemaps   = require('gulp-sourcemaps');
// var source       = require('vinyl-source-stream');
// var buffer       = require('vinyl-buffer');
// var assign       = require('lodash.assign');
// var config       = require('../config').browserify;
//
// var b,
//     opts;
//
// opts = assign({}, watchify.args, config);
// b = watchify(browserify(opts), { poll: true });
//
// b.transform(babelify);
//
// gulp.task('browserify', bundle);
// b.on('update', bundle);
// b.on('log', gutil.log);
//
// function bundle() {
//     return b.bundle()
//         .on('error', gutil.log.bind(gutil, 'browserify error'))
//         .pipe(source(opts.outputName))
//         .pipe(buffer())
//         .pipe(sourcemaps.init({loadMaps: true}))
//         .pipe(sourcemaps.write(config.dest)
//         .pipe(gulp.dest(opts.dest)));
// }
