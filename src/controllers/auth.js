var mongoose = require('mongoose')
  , restify = require('restify')
  , _ = require('lodash')
  , C = require('config').OAuth
  , User = mongoose.model('User')
  , AccessToken = mongoose.model('AccessToken')
  ;

// ### Register
exports.register = function (req, res, next) {

  var user = new User( req.params );
  user.validate( function( err ){
    if( err ){ next( new restify.PreconditionFailedError );}

    user.save( function(err, user) {
      next.ifError(err);

      AccessToken.create({ _userId: user._id  }, function (err, token) {
        next.ifError(err);
        res.send(token);
      });

    });
  });
};

// ### Login
exports.login = function (req, res, next) {

  User.findOne( { email: req.params.login }, function( err, user ){
    next.ifError( err );
    if(_.isEmpty( user )){ return next( new restify.InvalidCredentialsError()); }

    user.verifyPassword( req.params.password, function(err, isMatch ){
      next.ifError( err );

      if( !isMatch ){
        return next( new restify.InvalidCredentialsError());
      }

      AccessToken.create({ _userId: user._id }, function( err, token ){
        next.ifError( err );
        res.send( token );
      });

    })
  });
};

// ## Logout User and Delete Token
exports.logout = function( req, res, next ){
  AccessToken.findByIdAndRemove( req.userToken._id , function( err ) {
    next.ifError( err );
    res.send( 204 );
    return next();
  });
};

