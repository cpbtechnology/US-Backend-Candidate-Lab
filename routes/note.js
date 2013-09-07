var NoteServices = require('../services/note.services.js');

/**
 * Note list
 */
exports.list = function(req, res) {
  var loggedUserId = req.session.passport.user;
  if (!loggedUserId) {
    res.json(401, {
      message: 'Unauthorized access'
    })
  }
  NoteServices.findAllNotes({
    userId: loggedUserId,
    success: function(notes) {
      return res.json(200, notes);
    },
    error: function(error) {
      return res.json(500, error);
    }
  })
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
exports.create = function(req, res) {
  var loggedUserId = req.session.passport.user;
  if (!loggedUserId) {
    res.json(401, {
      message: 'Unauthorized access'
    })
  }
  NoteServices.saveNewNote({
    userId: loggedUserId,
    title: req.body.title,
    description: req.body.description,
    success: function(notes) {
      return res.json(201, notes);
    },
    error: function(error) {
      return res.json(500, error);
    }
  })
};