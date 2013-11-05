
//begin notesModel





module.exports = (function () {

    var mongoose = require('mongoose'),
        autoIncrement = require('mongoose-auto-increment'),
        db = mongoose.connection;



    var Note = null;
    var _this = null;
    
   
    var notesModel = function () {
        _this = notesModel;
        return _this;
    };

    var createSchema = function (c) {


        var noteSchema = mongoose.Schema({
            title: String
            ,body: String
            ,updatedDate: {type:Date, default:Date.now}
            ,createdDate: Date
        });



        autoIncrement.initialize(c);
        noteSchema.plugin(autoIncrement.plugin, "Note");
        Note = mongoose.model("Note" , noteSchema);


    };



    notesModel.createNote = function (data, user, callback) { 

    
        var note = new Note(data);
        note.save(callback);       


    };

    notesModel.getNote = function (id, user, callback) { 


        if(id !== undefined) 
            Note.findOne({_id : id}).lean().exec(callback);
        else
            Note.find().lean().exec(callback);

    };

    notesModel.updateNote = function(id , data, user, callback) { 
       
        Note.update({ _id: id} , data, callback);

    };

    notesModel.delNote = function(id, user, callback) {

        Note.remove({_id:id} , callback);
    };


    notesModel.connect = function (host, options) {
        db.on('error' , function () {
            console.log("Something Went Wrong", arguments);
        });

        db.once('open' , function () {
            console.log("Database Connected");
        });

        
        var c = mongoose.connect(host , options);
        createSchema(c);
        

    };




    return notesModel;




}());


