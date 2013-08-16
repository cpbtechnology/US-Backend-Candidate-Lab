var express = require('express');
var db = require('./db');
var app = express();

// configuring passport

var passport = require('passport')
  , GoogleStrategy = require('passport-google').Strategy;

passport.use(new GoogleStrategy({
    returnURL: 'http://localhost:3000/auth/google/return',
    realm: 'http://localhost:3000/'
  },
  function(identifier, profile, done) {
    console.log(identifier);
    done(null, {id: identifier, profile: profile});
  }
));

passport.serializeUser(function(user, done) {
  done(null, JSON.stringify(user));
});

passport.deserializeUser(function(userStr, done) {
  done(null, JSON.parse(userStr));
});

// configuring express

app.configure(function() {
  app.use(express.logger());
  app.use(express.static('public'));
  app.use(express.cookieParser());
  app.use(express.bodyParser());
  app.use(express.session({ secret: 'keyboard cat' }));
  app.use(passport.initialize());
  app.use(passport.session());
  app.use(app.router);

  app.use(function (err, req, res, next) {
      console.error(err.stack);
      res.writeHead(500, err.stack);
      res.end();
      next(err);
  });
  app.use(function (err, req, res, next) {
      next(err);
  });
});

function authenticate(req, res, next) {
  if (req.user) {
    return next();
  } else {
    return passport.authenticate('google')(req, res);
  }
}

app.get(/\/notes\/(\w+)/, 
  authenticate,
  function (req, res) {
  var id = req.params[0];
  db.getEntity('notes', { _id: db.oid(id), userId: req.user.id }).then(function (data) {
    res.send(data);
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send("failed: "  + err);
  });;
});

app.get(/\/notes/, 
  authenticate,
  function (req, res) {
  db.getEntities('notes', { userId: req.user.id }).then(function (data) {
    res.send(data);
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });
});

app.delete(/\/notes\/(\w+)/,
  authenticate,
  function (req, res) {
  var id = req.params[0];
  db.deleteEntity('notes', { _id: db.oid(id), userId: req.user.id }).then(function () {
    res.send(true);
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });
});

app.post(/\/notes/, 
  authenticate,
  function (req, res) {
  db.insertEntity('notes', { userId: req.user.id, text: req.query.text }).then(function (data) {
    res.send(data[0]);
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });;
});

app.put(/\/notes\/(\w+)/,
  authenticate,
  function (req, res) {
  var id = req.params[0];
  db.putEntity('notes', { _id: db.oid(id), userId: req.user.id }, { text: req.query.text }).then(function (data) {
    res.send({ _id: id, text: req.query.text });
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });;
});

app.get('/',
  authenticate,
  function (req, res) {
  res.send(
    '<a href="/auth/google">LOGIN</a><br>'+
    '<a href="/notes">LIST NOTES</a><br>');
});

app.get('/auth/google', passport.authenticate('google'));

app.get('/auth/google/return',  passport.authenticate('google', { 
  successRedirect: '/',
  failureRedirect: '/auth/google'
}));

app.listen(3000);

console.log('server is running at http://localhost:3000/');
