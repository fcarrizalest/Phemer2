require.config({
 
  config: { 'waitSeconds':100 },
  paths: {
      jquery        :   'vendor/jquery',
      underscore    :   'vendor/underscore',
      backbone      :   'vendor/backbonejs',
      mustache      :   'vendor/mustache',
      templates     :   'templates',
      datatables    :   "vendor/jquery.dataTables.min", 
      datatables2    :   "vendor/dataTables.foundation.min", 
  }

});


require([
  // Load our app module and pass it to our definition function
  'app',
  
], function(App){

  // The "app" dependency is passed in as "App"
  // Again, the other dependencies passed in are not "AMD" therefore don't pass a parameter to this function
  App.initialize();
});