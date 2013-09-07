var Note = require('../models/note.js');

exports.findAllNotes = function(config) {
  Note.findAll({
    where: {
      UserId: config.userId
    },
    attributes: ['id', 'title', 'description']
  })
  .success(config.success)
  .error(config.error);
};

exports.saveNewNote = function(config) {
  Note.create({
    UserId: config.userId,
    title: config.title,
    description: config.description
  })
  .success(config.success)
  .error(config.error);
};
