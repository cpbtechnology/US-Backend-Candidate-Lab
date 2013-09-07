var Sequelize = require('../config/seqConfig.js').Sequelize,
    database = require('../config/seqConfig.js').database;

var NoteRecord = database.define('Note', {
  id: {type: Sequelize.BIGINT, primaryKey: true, autoIncrement: true},
  timestamp: {type: Sequelize.DATE, allowNull: false},
  title: {type: Sequelize.STRING, allowNull: false},
  description: {type: Sequelize.TEXT, allowNull: false}
});


NoteRecord.sync();

database.sync().success(function() {
  console.log('Successfully created Note');
}).error(function(error) {
  console.log('Failed creating Note');
});

module.exports = NoteRecord;
