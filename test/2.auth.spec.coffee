User = require './lib/user'

describe 'Authentication', ->

  describe 'Register, Login and Fetch my Profile', ->

    before (done)->
      @user = new User(
        email: 'test@test.com'
        password: 'test123'
      )
      done()

    it 'should register a new user and return a token', (done) ->
      @user.register ( err, obj )->
        assert.isNull err
        assert.jsonSchema(obj, chai.tv4.getSchema 'auth' )
        done()

    it 'should login as user and return new a token', (done) ->
      @user.login ( err, obj )->
        assert.isNull err
        assert.jsonSchema(obj, chai.tv4.getSchema 'auth' )
        done()

    it 'should forbid access without a token', (done) ->
      client.get '/echo-auth', (err, req, res, obj) ->
        assert.equal err.statusCode, 401
        assert.equal err.name, 'UnauthorizedError'
        done()

    it 'should allow access with a Bearer token', (done) ->
      @user.client.get "/echo-auth", (err, req, res, profile) ->
        assert.ifError err
        assert.equal res.statusCode, 200
        done()

  describe 'Failed Registration Scenarios', ->
    it 'empty data set, should return 412', (done) ->
      client.post '/api/register', {}, ( err, req, res )->
        assert.equal err.statusCode, 412
        done()

