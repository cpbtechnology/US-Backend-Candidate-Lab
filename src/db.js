var Q = require('q');
var mongodb = require('mongodb');
var BSON = mongodb.BSONPure;

var serverAddr = '127.0.0.1';
var serverPort = 27017;
var dbName = 'test';

var getCollection = function(name) {
    return Q.try(function() {
        var server = new mongodb.Server(serverAddr, serverPort, {});
        return new mongodb.Db(dbName, server, { w: 1 });
    }).ninvoke('open').then(function(client) {
        return new mongodb.Collection(client, name);
    });
};

var hasEntity = function(type, query) {
    return getCollection(type).ninvoke('findOne', query).then(function(data) {
        return data ? true : false;
    });
};

var getEntity = function(type, query) {
    return getCollection(type).ninvoke('findOne', query);
};

var insertEntity = function(type, data) {
    return getCollection(type).ninvoke('insert', data);
};

var putEntity = function(type, query, data) {
    delete data._id;
    return getCollection(type).ninvoke('update', query, { $set: data }, { upsert: true });
};

var deleteEntity = function(type, query) {
    return getCollection(type).ninvoke('remove', query);
};

var getEntities = function(type, query) {
    return getCollection(type).ninvoke('find', query).ninvoke('toArray');
};

module.exports.hasEntity = hasEntity;
module.exports.getEntity = getEntity;
module.exports.putEntity = putEntity;
module.exports.getEntities = getEntities;
module.exports.deleteEntity = deleteEntity;
module.exports.insertEntity = insertEntity;
module.exports.oid = function (id) {
  return new BSON.ObjectID(id);
}

module.exports.getCollection = getCollection;
