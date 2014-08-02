var gulp = require('gulp')
  , mocha = require('gulp-spawn-mocha')
  , join = require('path').join
  , nodemon = require('gulp-nodemon')
  ;

var paths = {
  scripts: ['src/**/*.js', 'test/**/*.coffee']
};

gulp.task('mocha.test', function () {
  return gulp.src(['test/*.coffee'], {read: false}).pipe(mocha({
    bin: 'node_modules/mocha/bin/mocha',
    R: 'spec',
    compilers: 'coffee:coffee-script',
    c: true
  })).on('error', console.warn.bind(console));
});

gulp.task('watch', function () {
  gulp.watch( paths.scripts , ['mocha.test']);
});

gulp.task('serve', function(){
  nodemon({ script: 'index.js', ext: 'js', ignore: ['ignored.js'] })
    .on('restart', function () {
      console.log('restarted!')
    })
});

gulp.task('default', ['watch', 'mocha.test', 'serve']);

