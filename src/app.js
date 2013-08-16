var express = require('express');
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

app.listen(3000);

console.log('server is running at http://localhost:3000/');
