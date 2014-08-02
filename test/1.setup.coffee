global.restify = require 'restify'
global.mongoose = require 'mongoose'
mongoose.connect 'mongodb://localhost/cpb-api-test'
Logger = require 'bunyan'

global.chai = require 'chai'
global.assert = chai.assert

require './schemas' ## Load schemas

global.log = new Logger {
  name: 'meelocal-api-test'
  streams:[
    {
      level: 'info'
      path: 'logs/info-tests.log'
    }
    {
      level: 'debug'
      path: 'logs/debug-tests.log'
    }
  ]
}

global.server = require './../src/server'
global.client = restify.createJsonClient {
  url: 'http://localhost:8081'
}
global.httpClient = restify.createHttpClient {
  url: 'http://localhost:8081'
}

server.on 'after', restify.auditLogger {
  log: Logger.createLogger {
    name: 'audit'
    streams: [
      path: 'logs/audit-tests.log'
    ]
  }
}

global.qs = require 'querystring'
global._ = require 'lodash'
global.async = require 'async'

describe 'Setting Up', ->

  it 'should clear the TEST database', (done)->
    mongoose.connection.on 'open', ()->
      mongoose.connection.db.dropDatabase done

  it 'should start the SERVER', (done)->
    server.listen 8081, '127.0.0.1', done()

  it 'should have respond to ECHO', (done)->
    q = _.random 0, 10
    client.get "/echo?q=#{q}", (err, req, res, obj)->
      assert.equal obj.q, q
      done()

  after (done) ->

    done()