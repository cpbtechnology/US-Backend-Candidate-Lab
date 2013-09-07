var User = require('../models/user.js');
var Note = require('../models/note.js');

/**
 * Note list
 */
exports.list = function(req, res) {
  res.send("respond with a resource");
};

/**
 * Note details
 */
exports.detail = function(req, res) {
  res.send(req.params.id);
};

/**
 * Save a note
 */
exports.save = function(req, res) {
  res.send("respond with a resource");
};