var express = require('express'),
    user = require('./routes/user'),
    note = require('./routes/note'),
    passport = require('passport'),
    pasConfig = require('./config/passportConfig'),
    http = require('http'),
    path = require('path'),
    app = express();

function logErrors(err, req, res, next) {
  console.error(err.stack);
  next(err);
}

function errorHandler(err, req, res, next) {
  res.json(500, {
    message: 'Server cannot process requests at this moment',
    error: err
  });
}

app.configure(function() {
  app.set('port', process.env.PORT || 3000);
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
});

app.post('/users', user.create);
app.post('/users/login', user.login);
app.post('/users/notes', note.create);
app.get('/users/notes', note.list);
app.get('/users/notes/:id', note.detail);
app.put('/users/notes/:id', note.update);
app.delete('/users/notes/:id', note.destroy);

http.createServer(app).listen(app.get('port'), function() {
  console.log('Express server listening on port ' + app.get('port'));
});
