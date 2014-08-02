
var restify = require('restify')
  , mongoose = require('mongoose')
  , _ = require('lodash')
  ;

/**
 * Returns a plugin that will parse the client's Authorization header.
 *
 * Subsequent handlers will see `req.authorization`, which looks like:
 *
 * {
 *   scheme: <Bearer>,
 *   token: <Token>,
 *   userId: $userId
 * }
 *
 * `req.userId` will also be set, and defaults to 'null'.
 *
 * @return {Function} restify handler.
 * @throws {TypeError} on bad input
 */
function authorizationParser( options ) {
  options = options || {};

  var AccessToken = mongoose.model('AccessToken')
    , User = mongoose.model('User');

  function parseAuthorization(req, res, next) {
    req.authorization = {};
    req.userId = null;

    if (!req.headers.authorization)
      return (next());

    var pieces = req.headers.authorization.split(' ', 2);
    if (!pieces || pieces.length !== 2) {
      var e = new restify.InvalidHeaderError('BearerAuth content is invalid.');
      return (next(e));
    }

    req.authorization.scheme = pieces[0];
    req.authorization.token = pieces[1];

    AccessToken.verify( pieces[1], function( err, token ){
      if( err ){
        var e = new restify.UnauthorizedError('Invalid Token!');
        return (next(e));
      }

      req.userId = token._userId;
      req.userToken = token;

      User.findOne({ _id: req.userId }, function( err, user ){
        if( err ){
          var e = new restify.UnauthorizedError('Invalid Token!');
          return (next(e));
        }

        // attach profile to the request
        req.user = user;
        req.userId = user._id.toString();
        return (next());
      });

    });
  }

  return (parseAuthorization);
}

function mustBeAuthorized( options ){
  options = options || {};

  function isAuthorized( req, res, next ){
    if(_.isNull( req.userId ) ){
      var e = new restify.UnauthorizedError('Must be authenticated!');
      return (next(e));
    }
    return (next());
  }

  return ( isAuthorized );
}


module.exports.authorizationParser = authorizationParser;
module.exports.mustBeAuthorized = mustBeAuthorized;
