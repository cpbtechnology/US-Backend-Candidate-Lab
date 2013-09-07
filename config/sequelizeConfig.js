var Sequelize = require('sequelize'),
    mysql     = require('sequelize-mysql').mysql;

exports.Sequelize = Sequelize;

exports.database = new Sequelize('labnotes', 'root', null, {
  dialect: 'mysql'
});