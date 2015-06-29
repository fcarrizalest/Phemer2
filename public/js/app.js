// Filename: app.js
define([
  'app/router' // Request router.js
  //'router'
], function(Router){

  var initialize = function(){
    // Pass in our Router module and call it's initialize function
    Router.initialize();
  };

  return { 
    initialize: initialize
  };
});