









var notesApi = (function () {



    var restify = require('restify');
    var pkg = require('./package.json');
    var notesModel = require("./model.js");
    var model = new notesModel();


    //Context Helper
    var _this = null;


    var notesApi = function () {

        notesApi.server = restify.createServer({
                name: pkg.name
                ,version: pkg.version
        });
        
        _this = notesApi;


       

        return _this;
    };  
    

    notesApi.start = function() {
        model.connect("mongodb://localhost/notes");
        _this.server.listen(8080 , function() {
            console.log(pkg.name + " online.");
        });
        _this.server.use(restify.authorizationParser());
        _this.server.use(restify.dateParser());
        _this.server.use(restify.queryParser());
        _this.server.use(restify.jsonp());
        _this.server.use(restify.gzipResponse());
        _this.server.use(restify.bodyParser());
        _this.setupRoutes();
    };


    notesApi.setupRoutes = function () {

        var server = _this.server;
        server.get("/api/notes" , _this.actionGet);
        server.get("/api/notes/:id" , _this.actionGet);
        server.put("/api/notes" , _this.actionCreate);
        server.post("/api/notes/:id" , _this.actionUpdate);
        server.del("/api/notes/:id" , _this.actionDelete);

    };

    //Notes Crud
    notesApi.actionGet = function(req, res, next) { 
        
        try {
            model.getNote(req.params.id, null, function (err, data) {
                if(err)
                    next(err)
                else
                    res.send(200, data);
            });  
         } catch(err){
            return next(err);
        }
    };
    
    notesApi.actionCreate = function(req, res, next) {  

        try {
            model.createNote(JSON.parse(req.body), null , function (err, data) {
                if(err)
                    next(err)
                else
                    res.send(201);
            });            
        } catch(err){
            return next(err);
        }

    };
    
    notesApi.actionUpdate = function(req, res, next) { 
        try {
            model.updateNote(req.params.id , JSON.parse(req.body) ,null , function (err, updRows ,data) {
                if(err)
                    next(err)
                else
                    res.send(204);
            });            
        } catch(err){
            return next(err);
        }
    };

    notesApi.actionDelete = function(req, res, next) { 
        try {
            model.delNote(req.params.id ,null , function (err,  data) {
                if(err)
                    next(err)
                else
                    res.send(204);
            });            
        } catch(err){
            return next(err);
        }
    };
    



    

    return notesApi;
}());


var notes = new notesApi();

notes.start();








