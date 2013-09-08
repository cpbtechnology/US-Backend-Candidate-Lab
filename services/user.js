var User = require('../models/user.js');

/**
 * Saves a user. If the user already exits the user is updated with the new values.
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
exports.saveUser = function(config) {
	User.generateHash(config.password, function(err, pw) {
		User
			.create({username: config.username, password: pw })
			.success(config.success)
			.error(config.error);
	});
};