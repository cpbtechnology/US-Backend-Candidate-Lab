var CONFIG = require('config')
  , mongoose = require( 'mongoose' )
  , restify = require('restify');

// Database
// ----------------------------------------------------------------------------
if( !mongoose.connection.readyState ){
  mongoose.connect( 'mongodb://localhost/cpb-api-dev', function( err ){
    if( err ){
      console.log('Unable to connect to Mongo!', err );
      process.exit(1);
    }
  });
}

// Logs
// ----------------------------------------------------------------------------
var Logger = require( 'bunyan' );
global.log = new Logger( {
  name   : 'cpb-api',
  streams: [
    {
      level : 'info',
//      path : 'logs/api-debug.log'  // log ERROR and above to a file
      stream: process.stdout // log INFO and above to stdout
    },
    {
      level: 'error',
      path : 'logs/api-error.log'  // log ERROR and above to a file
    },
    {
      level: 'debug',
      path : 'logs/debug.log'  // log ERROR and above to a file
    }
  ]
});

// Server
// ----------------------------------------------------------------------------
global.server = require('./src/server');

server.on('after', restify.auditLogger({
  log: Logger.createLogger({
    name: 'audit',
    stream: process.stdout
  })
}));

server.listen( 8000, function() {
  console.log( '%s listening at %s', server.name, server.url );
});
