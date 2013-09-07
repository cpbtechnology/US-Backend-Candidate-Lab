var User = require('../models/user.js');

exports.saveUser = function(config) {
  User.generateHash(config.password, function(err, pw) {
    User
      .create({username: config.username, password: pw })
      .success(function(user) {
        config.success({
          username: user.username,
          createdAt: user.createdAt,
          updatedAt: user.updatedAt
        });
      })
      .error(function(error) {
        config.error({
          message: 'There was a problem persisting the user',
          error: error
        });
      });
  });
};