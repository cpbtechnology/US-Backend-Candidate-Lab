chai = require 'chai'
chai.use( require 'chai-json-schema' )

authSchema =
  id: 'auth'
  type: 'object'
  required: [ 'token', 'expires']
  properties:
    token:
      type: 'string'
    expires:
      type: 'string'

userNoteSchema =
  id: 'userNote'
  type: 'object'
  required: [ '_id', 'title', 'description',  'createdAt']
  properties:
    _id:
      type: 'string'
    title:
      type: 'string'
    description:
      type: 'string'

userNotesSchema =
  id: 'userNotes'
  type: 'array'
  items:
    $ref: 'userNote'

# Register Schemas
chai.tv4.addSchema userNotesSchema
chai.tv4.addSchema userNoteSchema
chai.tv4.addSchema authSchema