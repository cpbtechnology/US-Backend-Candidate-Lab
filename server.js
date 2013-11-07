









var notesApi = (function () {


    var fs = require('fs');
    var restify = require('restify');
    var pkg = require('./package.json');
    var notesModel = require("./model.js");
    var model = new notesModel();
    var passport = require('passport')
        ,LocalStrategy = require('passport-local').Strategy
        ,BasicStrategy = require('passport-http').BasicStrategy;




    //Context Helper
    var _this = null;
    var cors = function (req , res , next) {
        res.header('Access-Control-Allow-Origin', "*")
        res.header('Access-Control-Allow-Methods', 'GET,OPTIONS,PUT,POST,DELETE')
        res.header('Access-Control-Allow-Headers', 'Content-Type')

        next()
    }



    var notesApi = function () {

        notesApi.server = restify.createServer({
                key: fs.readFileSync('ssl/server.key', 'utf8')
                ,certificate: fs.readFileSync('ssl/server.crt', 'utf8')
                ,name: pkg.name
                ,version: pkg.version
        });
        
        _this = notesApi;      

        return _this;
    };  


    var initAuth = function () {



        passport.use(new BasicStrategy(function(username, password, done) {
                model.getUser(username, function(err, user) {
                    if(err) return done(new Error(err));
                    if(!user.passValidate(password, user.createdDate)) done(null, false);
                    done(null, user);            
                });               
            }
        ));
    }
    

    notesApi.start = function() {
        
        model.connect("mongodb://localhost/notes");
        initAuth();
       
        //_this.server.use(restify.authorizationParser());
        _this.server.use(restify.dateParser());
        _this.server.use(restify.queryParser());
        _this.server.use(restify.jsonp());
        _this.server.use(restify.gzipResponse());
        _this.server.use(restify.bodyParser());
        _this.server.use(cors);
        _this.server.use(passport.initialize());
        _this.server.use(passport.session());
        _this.setupRoutes();



         _this.server.listen(8080 , function() {
            console.log(pkg.name + " online.");
        });
    };


    notesApi.setupRoutes = function () {

        var server = _this.server;

        server.put("/api/user" , _this.actionCreateUser);
        server.get("/api/user" , passport.authenticate('basic', {session: false }) , _this.actionGetUser);
        server.get("/api/notes" , passport.authenticate('basic', {session: false}), _this.actionGet);
        server.get("/api/notes/:id" , passport.authenticate('basic', {session: false}), _this.actionGet);
        server.put("/api/notes" , passport.authenticate('basic', {session: false}), _this.actionCreate);
        server.post("/api/notes/:id" , passport.authenticate('basic', {session: false}), _this.actionUpdate);
        server.del("/api/notes/:id" , passport.authenticate('basic', {session: false}), _this.actionDelete);
        

    };

    //User Crud
    notesApi.actionCreateUser = function (req, res, next) {
        try {
            model.createUser(JSON.parse(req.body), function (err, data) {
                if(err){
                    return next(err);
                }else{
                    console.log("send");
                    res.send(201);

                }
                    
            });  
         } catch(err){
            return next(err);
        }
        
    };

    notesApi.actionGetUser = function (req, res, next) {
        try {     

            delete req.user.password;
            res.send(200, req.user);
            


         } catch(err){
            return next(err);
        }
        
    };


    //Notes Crud
    notesApi.actionGet = function(req, res, next) { 
        
        try {
            model.getNote(req.params.id, req.user, function (err, data) {
                if(data === null || data === undefined) data = [];
                if(err || data.length < 1)
                    return next(new restify.ResourceNotFoundError(err ? err : ""));
                else
                    res.send(200, data);
            });  
         } catch(err){
            return next(new restify.InternalError(err));
        }
    };
    
    notesApi.actionCreate = function(req, res, next) {  

        try {
            model.createNote(JSON.parse(req.body), req.user , function (err, data) {
                if(err)
                    return next(new restify.InternalError(err));
                else
                    res.send(201);
            });            
        } catch(err){
            return next(new restify.InternalError(err));
        }

    };
    
    notesApi.actionUpdate = function(req, res, next) { 
        try {
            model.updateNote(req.params.id , JSON.parse(req.body) ,req.user , function (err, updRows ,data) {
                if(err)
                    return next(new restify.ResourceNotFoundError(err));
                else
                    res.send(204);
            });            
        } catch(err){
            return next(new restify.InternalError(err));
        }
    };

    notesApi.actionDelete = function(req, res, next) { 
        try {
            model.delNote(req.params.id , req.user , function (err,  data) {
                if(err)
                    next(new restify.ResourceNotFoundError(err));
                else
                    res.send(204);
            });            
        } catch(err){
            return next(new restify.InternalError(err));
        }
    };
    



    

    return notesApi;
}());


var notes = new notesApi();

notes.start();








