/* Notes:
   - gulp/tasks/browserify.js handles js recompiling with watchify
   - gulp/tasks/browserSync.js watches and reloads compiled files
*/

var gulp     = require('gulp');
var config   = require('../config');

gulp.task('watch', function() {
    gulp.watch([config.bundler.modules+'/**/*.js'], ['bundlejs']);
    gulp.watch(config.sass.src,   ['sass']);
    gulp.watch(config.images.src, ['images']);
});
