var  mongoose = require( 'mongoose')
  , timestamps = require('mongoose-timestamp')
  ;

var UserNoteSchema = new mongoose.Schema( {
  userId: { type: mongoose.Schema.Types.ObjectId, required: true },
  title : { type: String, required: true },
  description : { type: String, required: true }
});

// Indexes
UserNoteSchema.index({ "title" : 1 });

// Plugins
UserNoteSchema.plugin(timestamps);

module.exports = mongoose.model( 'UserNote', UserNoteSchema );