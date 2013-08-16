var Q = require('q');
var mongodb = require('mongodb');

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

var hasEntity = function(type, id) {
    return getCollection(type).ninvoke('findOne', { _id: id }).then(function(data) {
        return data ? true : false;
    });
};

var getEntity = function(type, id) {
    return getCollection(type).ninvoke('findOne', { _id: id });
};

var putEntity = function(type, id, data) {
    delete data._id;
    return getCollection(type).ninvoke('update', { _id: id }, { $set: data }, { upsert: true });
};

var deleteEntity = function(type, id) {
    return getCollection(type).ninvoke('remove', { _id: id });
};

var getEntities = function(type) {
    return getCollection(type).ninvoke('find').ninvoke('toArray');
};

module.exports.hasEntity = hasEntity;
module.exports.getEntity = getEntity;
module.exports.putEntity = putEntity;
module.exports.getEntities = getEntities;
module.exports.deleteEntity = deleteEntity;

module.exports.getCollection = getCollection;
