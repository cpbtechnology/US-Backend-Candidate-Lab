var User = require('../models/user.js'),
    Passport = require('passport'),
    LocalStrategy = require('passport-local').Strategy;


Passport.serializeUser(function (user, done) {
  console.log('Serialize ID' + user.UserId);
  done(null, user.UserId);
});

Passport.deserializeUser(function(id, done) {
  console.log('Deserialize ID' + id);
  User.find({where: {UserId: id}}).success(function(user) {
    done(null, user);
  }).error(function(error){
    done('User doesnt exist', null);
  });
});


Passport.use(
  new LocalStrategy(function(name, password, done) {
    console.log('Lookup user: ' + name + ' with pass ' + password)
    User
      .find(
        {where: {username: name}}
      )
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