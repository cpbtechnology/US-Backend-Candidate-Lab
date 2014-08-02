User = require './lib/user'

describe 'User Note Tests', ->

  describe 'CRUD Tests', ->
    noteId = null
    noteObject = null

    sampleNote =
      title : 'Sample Note'
      description: 'Description - Creating'

    before (done) ->
      @user = new User(
        email: 'test1@test.com'
        password: 'test123'
      )
      @user.register done

    it 'should create a new note and return the note', ( done ) ->
      @user.client.post "/api/user/notes", sampleNote, ( err, req, res, note ) ->
        assert.isNull err
        assert.equal res.statusCode, 201
        assert.jsonSchema(note, chai.tv4.getSchema 'userNote' )
        noteId = note._id
        delete note._id
        delete note.__v
        noteObject = note
        done()

    it 'should return our new note', ( done ) ->
      @user.client.get "/api/user/notes/#{noteId}", ( err, req, res, note ) ->
        assert.isNull err
        assert.jsonSchema note, chai.tv4.getSchema 'userNote'
        done()

    it 'should update our note', ( done ) ->
      putNote =
        description: 'Description - Updating'

      @user.client.put "/api/user/notes/#{noteId}", _.merge( noteObject, putNote ), ( err, req, res, note ) ->
        assert.isNull err
        assert.equal res.statusCode, 202
        assert.jsonSchema note, chai.tv4.getSchema 'userNote'
        assert.equal note.description, putNote.description
        done()

    it 'should delete our note', ( done ) ->
      @user.client.del "/api/user/notes/#{noteId}", ( err, req, res ) =>
        assert.isNull err
        assert.equal res.statusCode, 204
        done()

