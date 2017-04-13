var gulp     = require('gulp');
var svgstore = require('gulp-svgstore');
var inject   = require('gulp-inject');
var config   = require('../config').icons;

gulp.task('svgstore', function () {
    var svgs = gulp
        .src(config.src)
        .pipe(svgstore({ inlineSvg: true }));

    function fileContents (filePath, file) {
        return file.contents.toString();
    }

    return gulp
        .src(config.dest+'/inline-svg.liquid')
        .pipe(inject(svgs, { transform: fileContents }))
        .pipe(gulp.dest(config.dest));
});
