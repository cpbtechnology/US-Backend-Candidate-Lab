var UserServices = require('../services/user.services.js'),
  Passport = require('passport');

exports.create = function(req, res) {
  var userName = req.body.username,
    password = req.body.password;

  if (!userName) {
    return res.json(400, {
      message: 'Please provide a non-empty username'
    });
  }

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
          message: 'Authenctiation error',
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
