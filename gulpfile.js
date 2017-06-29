var gulp = require('gulp');

gulp.task('release', function () {
  return gulp.src(
       [ './*.php', './js/**/*', 'readme.txt', './css**/*' ],
       { base: './' }
  ).pipe( gulp.dest( './dist' ) )
})
