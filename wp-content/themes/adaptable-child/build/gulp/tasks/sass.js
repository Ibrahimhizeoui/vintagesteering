var gulp            = require('gulp');
var rename          = require('gulp-rename');
var sass            = require('gulp-sass');
var sourcemaps      = require('gulp-sourcemaps');
var autoprefixer    = require('gulp-autoprefixer');
var config          = require('../config').sass;
var handleErrors    = require('../util/handleErrors');

gulp.task('sass', function () {
    return gulp.src(config.src)
    .pipe(sass(config.settings))
    .on('error', handleErrors)
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write())
    .pipe(autoprefixer({ browsers: ['last 2 version']}))
    .pipe(rename('style.css'))
    .pipe(gulp.dest(config.dest));
});
