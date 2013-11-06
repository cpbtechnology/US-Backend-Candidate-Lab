
//begin notesModels





module.exports = (function () {

    var mongoose = require('mongoose'),
        autoIncrement = require('mongoose-auto-increment'),
        db = mongoose.connection,
        crypto = require("crypto"),
        restify = require("restify");





    var Note = null;
    var User = null;
    var _this = null;
    
   
    var notesModels = function () {
        _this = notesModels;
        return _this;
    };

    var createSchema = function (c) {


        //Note
        var noteSchema = mongoose.Schema({
            title: String
            ,body: String
            ,updatedDate: {type:Date, default:Date.now}
            ,createdDate: Date
        });

        //User
        var userSchema = mongoose.Schema({
            email:String
            ,username: String
            ,password: String
            ,createdDate: Date
            
        });

        userSchema.methods.validatePassword = function (password) {
            var hash = crypto.createHash('md5').update(password+this.createdDate.toISOString()).digest('hex');
            if(hash === this.password)
                return true;
            else
                return false;
        }

        //init auto increment plugin
        autoIncrement.initialize(c);
        noteSchema.plugin(autoIncrement.plugin, "Note");
        userSchema.plugin(autoIncrement.plugin, "User");

        //declare models
        Note = mongoose.model("Note" , noteSchema);      
        User = mongoose.model("User" , userSchema);

    };


    notesModels.createUser = function (user , callback) {
        
        //ToDo
        // Salt with DOB


        var user = user;
        _this.getUser(user.username , function (err, userExists) {
            if(userExists)
                callback(new restify.InvalidArgumentError("Username Exists"));
            else {
                var now = new Date().toISOString();
    
                
                user.password = hash;
                var newUser = new User(user);
                newUser.createdDate = now;
                newUser.save(callback);
            }
        });

        



    }

    notesModels.authUser = function (userCred , callback) {

        
        
        _this.getUser(userCred.username , function (err, user) {
            if(err) {
                callback(new restify.InternalError(err));
            }else if(user) {                
                if(user.validatePassword(userCred.password)) {
                    callback(null, user);
                }
                else{
                    callback(new restify.NotAuthorizedError("Access Denied"));
                }

            }else{
                callback(new restify.ResourceNotFoundError("User Does Not Exist"))
            }  
        });


    }

    notesModels.getUser = function (username, callback) { 
        User.findOne({username:username}).lean().exec(function (err, user) {
            if(err)
                callback("User Does Not Exist");
            else if(user)
                callback(null, user)
            else
                callback("User Does Not Exist");

        });

    }



    notesModels.createNote = function (data, user, callback) { 

    
        var note = new Note(data);
        note.createdDate = new Date().toISOString();
        note.save(callback);       


    };

    notesModels.getNote = function (id, user, callback) { 


        if(id !== undefined) 
            Note.findOne({_id : id}).lean().exec(callback);
        else
            Note.find().lean().exec(callback);

    };

    notesModels.updateNote = function(id , data, user, callback) { 
       
        Note.update({ _id: id} , data, callback);

    };

    notesModels.delNote = function(id, user, callback) {

        Note.remove({_id:id} , callback);
    };


    notesModels.connect = function (host, options) {
        db.on('error' , function () {
            console.log("Something Went Wrong", arguments);
        });

        db.once('open' , function () {
            console.log("Database Connected");
        });

        
        var c = mongoose.connect(host , options);
        createSchema(c);
        

    };




    return notesModels;




}());


