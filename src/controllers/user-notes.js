var mongoose = require( 'mongoose' )
  , _ = require('lodash')
  , CONFIG = require('config')
  , async = require('async')
  , UserNote = mongoose.model( 'UserNote' )
  ;

// ### Get Note by ID
exports.findOne = function( req, res, next ) {
  UserNote.findById( req.params.id )
    .exec( function( err, note ) {
      next.ifError( err );
      res.send( note );
      return next();
    });
};

// ### Add Note
exports.insert = function( req, res, next ) {
  var note = new UserNote( req.body );
  note.set('userId', req.userId);
  note.save( function( err, note ) {
    next.ifError( err );
    res.send( 201, note );
    return next();
  });
};

// ### Update Note
exports.update = function( req, res, next ) {
  UserNote.findByIdAndUpdate( req.params.id, { $set: req.body }, function( err, note ){
    next.ifError( err );
    res.send( 202, note );
    return next();
  });
};

// ### Delete Place
exports.remove = function( req, res, next ) {
  UserNote.findByIdAndRemove( req.params.id , function( err ) {
    next.ifError( err );
    res.send( 204 );
    return next();
  } );
};

// ### Query Notes
exports.findAll = function( req, res, next ) {
  UserNote
    .aggregate()
    .match( { userId: res.userId } )
    .sort({ createdAt: -1 })
    .project("_id")
    .limit( 100 )
    .exec( function( err, noteIds ){
      next.ifError( err );
      UserNote.find( { _id : { $in : _.pluck( noteIds, '_id') } })
        .sort({ createdAt: -1 })
        .exec( function( err, notes ){
          res.send( notes );
          return next();
        });
    });
};