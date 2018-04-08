// ********** Instances **********
const gulp = require('gulp');

const stylus = require('gulp-stylus');
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const imagemin = require('gulp-imagemin');
const uglify = require('gulp-uglify');

const paths = {
  dest: './build',
  styles: 'styles/all.styl',
  scripts: 'scripts/**/*.js',
  images: 'imgs/*',
};

// ***************************


// ********* Tasks ***********
gulp.task('clean', () => del([paths.dest]));

gulp.task('styles', () =>
  gulp.src(paths.styles)
    .pipe(sourcemaps.init())
    .pipe(stylus())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write())
    .pipe(rename({
      basename: 'app',
      suffix: '.min',
    }))
    .pipe(gulp.dest(paths.dest)));

gulp.task('js', () =>
  gulp.src(paths.scripts)
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(rename({
      basename: 'app',
      suffix: '.min',
    }))
    .pipe(gulp.dest(paths.dest)));


gulp.task('assets', () =>
  gulp.src(paths.images)
    .pipe(imagemin())
    .pipe(gulp.dest(paths.dest)));


gulp.task('build', gulp.series(
  'clean',
  gulp.parallel('styles', 'assets', 'js'),
));
