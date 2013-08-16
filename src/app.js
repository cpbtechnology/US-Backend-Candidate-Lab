var express = require('express');
var db = require('./db');
var app = express();

app.use(express.logger());
app.use(app.router);
app.use(function (err, req, res, next) {
    console.error(err.stack);
    res.writeHead(500, err.stack);
    res.end();
    next(err);
});
app.use(function (err, req, res, next) {
    next(err);
});

app.get(/\/notes\/(\d+)/, function (req, res) {
  var id = req.params[0];
  db.getEntity('notes', id).then(function (data) {
    res.send(data);
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send("failed: "  + err);
  });;
});

app.get(/\/notes/, function (req, res) {
  db.getEntities('notes').then(function () {
    res.send("ok: "  + JSON.stringify(arguments));
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });
});

app.delete(/\/notes\/(\d+)/, function (req, res) {
  var id = req.params[0];
  db.deleteEntity('notes', id).then(function () {
    res.send("ok: "  + JSON.stringify(arguments));
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });
});

app.post(/\/notes\/(\d+)/, function (req, res) {
  var id = req.params[0];
  db.putEntity('notes', id, { text: '123' }).then(function (ok) {
    res.send("ok: "  + JSON.stringify(arguments));
  }, function (err) {
    res.writeHead(400, "Bad request");
    res.send(err);
  });;
});

app.listen(3000);

console.log('server is running at http://localhost:3000/');
