var User = require('../models/user.js'),
    Passport = require('passport'),
    LocalStrategy = require('passport-local').Strategy,
    check = require('validator').check,
    sanitize = require('validator').sanitize;


Passport.serializeUser(function (user, done) {
  done(null, user.UserId);
});

Passport.deserializeUser(function(id, done) {
  User.find({where: {UserId: id}}).success(function(user) {
    done(null, user);
  }).error(function(error){
    done('User is not in the session', null);
  });
});


Passport.use(
  new LocalStrategy(function(name, password, done) {
    name = sanitize(name).xss().trim();
    password = sanitize(password).xss().trim();

    check(name).notEmpty();
    check(password).notEmpty();

    User
      .find({
        where: {
          username: name
        }
      })
      .success(function(user) {
        if (!user) {
          return done(null, false, { message: 'Unknown user ' + name });
        }
        user.comparePassword(password, function(err, isMatch){
          if (err) {
            return done(err);
          }

          if(isMatch) {
            return done(null, user);
          } else {
            return done(null, false, { message: 'Invalid password' });
          }
        });
      })
      .error(function(error){
        return done(error);
      }
    );
  })
);