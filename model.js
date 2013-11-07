
//begin notesModels





module.exports = (function () {

    var mongoose = require('mongoose'),
        autoIncrement = require('mongoose-auto-increment'),
        db = mongoose.connection,
        crypto = require("crypto"),
        restify = require("restify"),
        Schema = mongoose.Schema;





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
            ,_author: {type:String, ref: 'User'}
        });

        //User
        var userSchema = mongoose.Schema({
            email:String
            ,username: String
            ,password: String
            ,createdDate: Date
            ,notes: [{ type: Number , ref: 'Note' }]
            
        });

        userSchema.methods.passValidate = function (password) {
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
                var hash = crypto.createHash('md5').update(user.password+now).digest('hex');                
                var newUser = new User(user);
                newUser.password = hash;
                newUser.createdDate = now;
                newUser.save(callback);
            }
        });

        



    }

 

    notesModels.getUser = function (username, callback) { 
        User.findOne({username:username}).populate("notes").exec(function (err, user) {
            if(err){
                callback("User Does Not Exist");
            }else if(user) {
                callback(null, user)
            }else{
                callback("User Does Not Exist");
            }   

        });

    }



    notesModels.createNote = function (data, user, callback) { 

        


        var note = new Note(data)
        note.createdDate = new Date().toISOString();
        note._author = user.username;
        note.save(function(err) {
            if(err) {

            }
      
            user.notes.push(note._id);
            user.save(callback);       
        });
       

    };

    notesModels.getNote = function (id, user, callback) { 

     
        if(id !== undefined) 
            Note.findOne({_id : id, _author: user.username}).lean().exec(callback);
        else
            callback(null, user.notes);

    };

    notesModels.updateNote = function(id , data, user, callback) {        
        data.updatedDate = new Date().toISOString();
        Note.findOneAndUpdate({_id : id, _author: user.username}, data).lean().exec(callback);
    };

    notesModels.delNote = function(id, user, callback) {

        Note.findOneAndRemove({_id:id, _author:user.username} , callback);
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


