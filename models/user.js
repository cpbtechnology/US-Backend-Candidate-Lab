var Sequelize = require('../config/sequelizeConfig.js').Sequelize,
    database = require('../config/sequelizeConfig.js').database,
    Note = require('./note.js'),
    bcrypt = require('bcrypt'),
    SALT_WORK_FACTOR = 10;


var User = database.define('User', {
    UserId: {type: Sequelize.INTEGER, unique: true, autoIncrement: true},
    username: {type: Sequelize.STRING, primaryKey: true},
    password: {type: Sequelize.STRING, allowNull: false}
  },
  {
    classMethods: {
      generateHash: function(value, callback) {
        bcrypt.genSalt(SALT_WORK_FACTOR, function(err, salt) {
          if (err) {
            callback(err, null)
          }
          bcrypt.hash(value, salt, function(err, hash) {
            if (err) {
              callback(err, null)
            };
            callback(null, hash);
          });
        });
      }
    },
    instanceMethods: {
      comparePassword: function(candidatePassword, callback) {
        var that = this;

        bcrypt.compare(candidatePassword, this.password, function(err, isMatch) {
          if (err) {
            return callback(err);
          }
          callback(null, isMatch);
        });
      }
    }
  }
);

User.hasMany(Note, {as: 'notes'});
Note.belongsTo(User);

User.sync();

database.sync().success(function() {
  console.log('Successfully created Table User');
}).error(function(error) {
  console.log('Failed creating Table User');
});

module.exports = User;
