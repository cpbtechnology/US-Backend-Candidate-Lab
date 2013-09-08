var Note = require('../models/note.js');

exports.findNote = function(config) {
  Note.findAll({
    where: {
      UserId: config.userId,
      id: config.id
    },
    attributes: ['id', 'title', 'description']
  })
  .success(config.success)
  .error(config.error);
};

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

exports.updateNote = function(config) {
  Note.update(
    {title: config.title, description: config.description},
    {id: config.id, UserId: config.userId}
  )
  .success(config.success)
  .error(config.error);
};

exports.deleteNote = function(config) {
  Note.destroy({
    id: config.id, UserId: config.userId
  })
  .success(config.success)
  .error(config.error);
};
