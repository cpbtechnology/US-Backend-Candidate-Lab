async = require 'async'
_ = require 'lodash'
restify = require 'restify'
qs = require 'querystring'

module.exports = class User

  defaults:
    client:
      url: 'http://localhost:8081'

  constructor: ( @userData, options )->
    @setOptions options
    @client = restify.createJsonClient @options.client

  setOptions: (options) ->
    @options = _.merge @defaults, options
    this

  login: ( done )->
    @client.post '/api/login', { login: @userData.email, password: @userData.password }, ( err, req, res, auth)=>
      if( err )
        done( err )
      @auth = auth
      @setToken auth.token
      done( null, auth )

  register: ( done )->
    @client.post '/api/register', @userData, ( err, req, res, auth )=>
      if( err )
        done( err )
      @auth = auth
      @setToken auth.token
      done( null, auth )

  setHeaders: ( headers )->
    @client.headers = _.merge( @client.headers, headers )

  setToken: ( token )->
    @setHeaders { Authorization: "Bearer #{token}" }

  @setup: ( userData, options, done )->
    user = new @( userData, options)

    user.register (err)->
      if err
        done err

      user.getProfile ()->
        if err
          done err

        done null, user
