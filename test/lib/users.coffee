User = require './user'

module.exports = class Users

  defaults:
    setupTasks:
      register: true

  users: []

  constructor: ( @users, @options )->
#    @setUsers users
#    @setOptions options

  setUsers: (users) ->
    @users = _.merge @users, users
    this

  setOptions: (options) ->
    @options = _.merge @defaults, options
    this

  create: ( user, cb )->
    User.setup user, null, ( err, user)=>
      if err
        cb err

      @users.push user
      cb null, user

  getAll: ()->
    return @users

  get: ( name )->
    return _(@users).chain().where( { name: name }).first().value()

  getNames: ()->
    return _.pluck( @users, 'name')

  @setup: ( usersData, done )->
    if !_.isArray usersData
      usersData = [ usersData ]

    async.map usersData, ( userData, cb )->

      User.setup userData, null, cb

    , ( err, usersObj )=>
      if err
        done err

      users = new @(usersObj)
      done null, users
