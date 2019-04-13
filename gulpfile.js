const gulp = require('gulp');
const concat = require('gulp-concat');
const sass = require('gulp-sass');
const merge = require('merge-stream');
const del = require('del');
const uglify = require('gulp-uglify');
const cleanCSS = require('gulp-clean-css');

gulp.task('js', function () {
    return gulp.src([
        'assets/jquery/dist/jquery.min.js',
        'assets/bootstrap/dist/js/bootstrap.min.js',
        'app/Component/**/assets/*.js'
    ]).pipe(concat('app.js'))
        .pipe(gulp.dest('web/js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/js'));
});

gulp.task('css', function () {

    const cssStream = gulp.src([
        'assets/bootstrap/dist/css/bootstrap.min.css'
    ]).pipe(concat('css'));

    const scssStream = gulp.src([
        'app/Component/**/assets/*.scss',
        'assets/style.scss'
    ]).pipe(sass())
        .pipe(concat('scss'));

    return merge(cssStream, scssStream)
        .pipe(concat('app.css'))
        .pipe(gulp.dest('web/css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('web/css'));
});

gulp.task('images', function () {
    return gulp.src([
        'assets/images/**.*'
    ]).pipe(gulp.dest('web/images'));
});

gulp.task('clean', function() {
    return del([
        'web/css/',
        'web/js/',
        'web/images'
    ]);
});

gulp.task('default', gulp.series(['clean', 'css', 'js', 'images']));

