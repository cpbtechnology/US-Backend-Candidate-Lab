var NoteServices = require('../services/note.js'),
  check = require('validator').check,
  sanitize = require('validator').sanitize;

function getLoggedUser(req) {
  var loggedUserId = null;
  if (!req.session.passport) {
    return null;
  }
  loggedUserId = req.session.passport.user;
  return loggedUserId;
}

/**
 * Note list
 */
exports.list = function(req, res) {
  var loggedUserId = getLoggedUser(req);
  if (!loggedUserId) {
    return res.json(401, {
      message: 'Unauthorized access when trying to list notes'
    });
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
  });
};

/**
 * Note details
 */
exports.detail = function(req, res) {
  var loggedUserId = getLoggedUser(req),
    noteId = req.params.id;

  try {
    check(noteId).isInt();
  } catch(e) {
    return res.json(400, {
      message: 'One of the parameters is invalid',
      error: e
    });
  }

  if (!loggedUserId) {
    return res.json(401, {
      message: 'Unauthorized access when trying to get a note'
    });
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
  var loggedUserId = getLoggedUser(req),
    title = req.body.title,
    description = req.body.description;

  if (!loggedUserId) {
    return res.json(401, {
      message: 'Unauthorized access when trying to create a note'
    });
  }

  description = sanitize(description).xss().trim();
  title = sanitize(title).xss().trim();

  try {
    check(description).notEmpty();
    check(title).notEmpty();
  } catch(e) {
    return res.json(400, {
      message: 'One of the parameters is invalid',
      error: e
    });
  }

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
  });
};

exports.update = function(req, res) {
  var loggedUserId = getLoggedUser(req),
    title = req.body.title,
    description = req.body.description,
    id = req.params.id;

  if (!loggedUserId) {
    return res.json(401, {
      message: 'Unauthorized access when trying to update note'
    });
  }

  description = sanitize(description).xss().trim();
  title = sanitize(title).xss().trim();

  try {
    check(description).notEmpty();
    check(title).notEmpty();
    check(id).isInt();
  } catch(e) {
    return res.json(400, {
      message: 'The ID for the note to be updated is not a number',
      error: e
    });
  }

  NoteServices.updateNote({
    id: id,
    userId: loggedUserId,
    title: title,
    description: description,
    success: function(note) {
      return res.json(204, []);
    },
    error: function(error) {
      return res.json(500, error);
    }
  });
};

exports.destroy = function(req, res) {
  var loggedUserId = getLoggedUser(req),
    id = req.params.id;

  if (!loggedUserId) {
    return res.json(401, {
      message: 'Unauthorized access when trying to delete note'
    });
  }

  try {
    check(id).isInt();
  } catch(e) {
    return res.json(400, {
      message: 'The ID for the note to be deleted is not a number',
      error: e
    });
  }

  NoteServices.deleteNote({
    id: id,
    userId: loggedUserId,
    success: function(note) {
      return res.json(204, []);
    },
    error: function(error) {
      return res.json(500, error);
    }
  });
};