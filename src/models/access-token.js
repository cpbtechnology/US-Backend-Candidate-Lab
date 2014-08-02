var  mongoose = require( 'mongoose')
  , CONFIG = require('config').Security
  , crypto = require('crypto')
  , moment = require('moment')
  ;

function generateToken(){
  return crypto.randomBytes(16).toString('hex')
}

var AccessTokenSchema = new mongoose.Schema({
  token  : { type: String, default: generateToken, unique: true }
  , _userId : { type: mongoose.Schema.ObjectId }
  , expires : { type: Date, default: moment().add('s', CONFIG.tokenTTL).utc().format(), index: { expires: CONFIG.tokenTTL }}
});

AccessTokenSchema.static('verify', function( token, done ){
  this.findOne( { token: token }, function( err, user ){
    if( err ){ return done( err ); }
    if( !user ){ return done( null, false ); }
    return done( null, user )
  });
});

module.exports = mongoose.model('AccessToken',  AccessTokenSchema)
