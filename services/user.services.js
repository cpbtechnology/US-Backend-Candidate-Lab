var User = require('../models/user.js');

exports.saveUser = function(config) {
  User.generateHash(config.password, function(err, pw) {
    User
      .create({username: config.username, password: pw })
      .success(config.success)
      .error(config.error);
  });
};