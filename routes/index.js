
/*
 * GET home page.
 */

exports.index = function(req, res){
  var message = (req.user) ? 'Logged in as: ' + req.user.username : null;

  res.render('index', { title: 'Weightr', status: message });
};
