var NoteServices = require('../services/note.services.js'),
  check = require('validator').check,
  sanitize = require('validator').sanitize;

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
      if (!notes.length) {
        return res.json(404, []);
      }
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
  var loggedUserId = req.session.passport.user;
  var noteId = req.params.id;

  check(noteId).isInt();

  if (!loggedUserId) {
    res.json(401, {
      message: 'Unauthorized access'
    })
  }

  NoteServices.findNote({
    userId: loggedUserId,
    id: noteId,
    success: function(note) {
      if (!note.length) {
        return res.json(404, []);
      }
      return res.json(200, note);
    },
    error: function(error) {
      res.json(500, error);
    }
  });
};

/**
 * Save a note
 */
exports.create = function(req, res) {
  var loggedUserId = req.session.passport.user,
    title = req.body.title,
    description = req.body.description;

  if (!loggedUserId) {
    res.json(401, {
      message: 'Unauthorized access'
    })
  }

  description = sanitize(description).xss().trim();
  title = sanitize(title).xss().trim();

  check(description).notEmpty();
  check(tilte).notEmpty();

  NoteServices.saveNewNote({
    userId: loggedUserId,
    title: title,
    description: description,
    success: function(notes) {
      return res.json(201, notes);
    },
    error: function(error) {
      return res.json(500, error);
    }
  })
};

exports.update = function(res, req) {
  res.json(200, {});
};