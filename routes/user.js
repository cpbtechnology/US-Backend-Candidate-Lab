var UserServices = require('../services/user.services.js'),
  Passport = require('passport'),
  check = require('validator').check,
  sanitize = require('validator').sanitize;

/*
 * Create new user
 */
exports.create = function(req, res) {
  var userName = sanitize(req.body.username).xss().trim(),
    password = sanitize(req.body.password).xss().trim();

  check(userName).notEmpty();
  check(password).len(4, 50);

  if (!password) {
    return res.json(400, {
      message: 'Please provide a non-empty password'
    });
  }

  UserServices.saveUser({
    username: userName,
    password: password,
    success: function(User) {
      return res.json(201, {
        username: User.username,
        createdAt: User.createdAt,
        updatedAt: User.updatedAt,
      });
    },
    error: function(Error) {
      return res.json(500, Error)
    }
  })
};


/*
 * Authenticate user - service provided by passport
 */
exports.login = function(req, res) {
  Passport.authenticate('local', function(err, user, info) {
    if (err) {
      return res.json(403, {
        message: 'Authentication error',
        error: err
      });
    }

    if (!user) {
      return res.json(403, {
        message: 'The user does not exist',
        error: info
      });
    }

    req.logIn(user, function(err) {
      if (err) {
        return res.json(403, {
          message: 'Authentication error',
          error: err
        });
      }

      return res.json(200, {
          username: user.username,
          createdAt: user.createdAt,
          updatedAt: user.updatedAt
      });
    });
  })(req, res);
};
