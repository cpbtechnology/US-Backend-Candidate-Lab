var Sequelize = require('../config/sequelizeConfig.js').Sequelize,
    database = require('../config/sequelizeConfig.js').database,
    User = require('./user.js');

var NoteRecord = database.define('Note', {
  id: {type: Sequelize.BIGINT, primaryKey: true, autoIncrement: true},
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
