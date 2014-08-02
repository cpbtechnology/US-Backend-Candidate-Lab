var mongoose = require('mongoose')
  , timestamps = require('mongoose-timestamp')
  , bcrypt   = require('bcrypt')
  , C = require('config')
  ;

var UserSchema = new mongoose.Schema({
  email    : { type: String, required: true, unique: true }
  , password : { type: String, required: true }
});

// Check password update
UserSchema.pre('save', function(next){
  var user = this;

  // not changing password
  if(!user.isModified('password')) return next();
  bcrypt.genSalt( C.Security.saltWorkFactor , function(err, salt ){
    if( err ) return next( err );

    bcrypt.hash( user.password, salt, function( err, hash ){
      if( err ) return next( err );

      user.password = hash;
      next();
    })
  })

});

// Verify password
UserSchema.method('verifyPassword', function( candidatePassword, cb ){
  bcrypt.compare( candidatePassword, this.password, function( err, isMatch ){
    if(err) return cb( err );

    cb(null, isMatch );
  })
});

// Plugins
UserSchema.plugin(timestamps);

module.exports = mongoose.model('User', UserSchema)
