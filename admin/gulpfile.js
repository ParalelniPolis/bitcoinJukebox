var gulp = require('gulp');

// Plugins
var less = require('gulp-less');
var path = require('path');
var runSequence = require('run-sequence');
var $ = require('gulp-load-plugins')();

// Compile less to css
gulp.task('styles:less', function(){
	return gulp.src(['assets/less/bootstrap.less'])
		.pipe($.less())
		.on('error', console.error.bind(console))
		.pipe(gulp.dest('www/css'))
		.pipe($.size({title: 'styles:less'}));
})

// Merge each style to big one
gulp.task('styles:concat', function(){
	return gulp.src(['www/css/*.css'])
		.pipe($.concat('main.css'))
		.pipe(gulp.dest('www/css'))
		.pipe($.size({title: 'styles:concat'}));
})

// Optimize size of one big css file
gulp.task('styles:optimize', function(){
	return gulp.src(['www/css/main.css'])
		.pipe($.csso())
		.pipe($.rename({suffix: '.min'}))
		.pipe(gulp.dest('www/css'))
		.pipe($.size({title: 'styles:optimize'}));
})

// Merge each script to big one
gulp.task('scripts:concat', function(){
	return gulp.src(['assets/js/*.js'])
		.pipe($.concat('main.js'))
		.pipe(gulp.dest('www/js'))
		.pipe($.size({title: 'scripts:concat'}));
})

// Optimize size of one big js file
gulp.task('scripts:uglify', function(){
	return gulp.src(['www/js/main.js'])
		.pipe($.uglify())
		.pipe($.rename({'suffix': '.min'}))
		.pipe(gulp.dest('www/js'))
		.pipe($.size({title: 'scripts:uglify'}));
})

gulp.task('scripts', function(cb){
	runSequence('scripts:concat', 'scripts:uglify', cb);
})

gulp.task('styles', function(cb){
	runSequence('styles:less', 'styles:concat', 'styles:optimize', cb);
})

// Watch Files For Changes & Reload
gulp.task('serve', function (){
	gulp.watch(['assets/less/**/*.less'], ['styles']);
	gulp.watch(['assets/css/**/*.css'], ['styles']);
	gulp.watch(['assets/js/*.js', 'www/asset/js/**/*.js'], ['scripts']);
})

gulp.task('default', ['scripts', 'styles']);