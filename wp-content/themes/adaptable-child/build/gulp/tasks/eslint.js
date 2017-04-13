var gulp         = require('gulp'),
    eslint       = require('gulp-eslint');

    // ESLint ignores files with "node_modules" paths.
    // So, it's best to have gulp ignore the directory as well.
    // Also, Be sure to return the stream from the task;
    // Otherwise, the task may end before the stream has finished.

var lintJS = function() {
    return gulp.src(['src/js/main.js', '!node_modules/**', '!build/**'])
        .pipe(eslint('./.eslintrc.js'))
        .pipe(eslint.format());
};

gulp.task('lint', lintJS);
module.exports = lintJS;
