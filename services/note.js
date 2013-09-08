var Note = require('../models/note.js');

/**
 * Finds a note that matches the given configuration
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
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

/**
 * Finds all the notes for a given user.
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
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

/**
 * Saves a new note associated to the user that created it.
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
exports.saveNewNote = function(config) {
	Note.create({
		UserId: config.userId,
		title: config.title,
		description: config.description
	})
	.success(config.success)
	.error(config.error);
};

/**
 * Updates a note.
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
exports.updateNote = function(config) {
	Note.update(
		{title: config.title, description: config.description},
		{id: config.id, UserId: config.userId}
	)
	.success(config.success)
	.error(config.error);
};

/**
 * Deletes a note.
 * @param config {object} A Configuration object that describes the where clause
 * 				and the success and error callbacks.
 */
exports.deleteNote = function(config) {
	Note.destroy({
		id: config.id, UserId: config.userId
	})
	.success(config.success)
	.error(config.error);
};
