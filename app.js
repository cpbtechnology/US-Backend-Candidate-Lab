
/**
 * Module dependencies.
 */

var express = require('express'),
    routes = require('./routes'),
    user = require('./routes/user'),
    note = require('./routes/note'),
    passport = require('passport'),
    pasConfig = require('./config/pasConfig'),
    http = require('http'),
    path = require('path');

var app = express();

function logErrors(err, req, res, next) {
  console.error(err.stack);
  next(err);
}

function errorHandler(err, req, res, next) {
  res.json(500, {
    message: 'Server cannot process requests at this moment',
    { error: err }
  });
}

app.configure(function() {
  app.set('port', process.env.PORT || 3000);
  app.set('views', __dirname + '/views');
  app.set('view engine', 'hbs');
  app.use(express.favicon());
  app.use(express.logger('dev'));
  app.use(express.cookieParser('your secret here'));
  app.use(express.bodyParser());

  app.use(express.session());

  app.use(express.methodOverride());

  app.use(passport.initialize());
  app.use(passport.session());

  app.use(app.router);
  app.use(logErrors);
  app.use(errorHandler);
  app.use(express.static(path.join(__dirname, 'public')));
});

app.configure('development', function() {
  app.use(express.errorHandler());
});

app.post('/users/login', user.login);
app.post('/users', user.create);

app.get('/users', user.list);
app.get('/users/notes', note.list);
app.get('/users/notes/{id}', note.detail);

http.createServer(app).listen(app.get('port'), function() {
  console.log('Express server listening on port ' + app.get('port'));
});
