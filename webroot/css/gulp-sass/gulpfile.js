// Include Gulp & plugins
var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();



// Sass, autoprefix
gulp.task('styles', function() {
    return plugins.rubySass('sass/')
        .pipe(plugins.autoprefixer({
            browsers: ['last 3 versions'],
            cascade: true
        }))
        .pipe(gulp.dest('../'))
});


// Watch task
gulp.task('watch', function() {

	gulp.watch('sass/**/*.scss', ['styles']);


});

// Default task
gulp.task('default', ['styles', 'watch']);
   

