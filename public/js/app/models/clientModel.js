define([
     'jquery',
    'underscore',
    'backbone',
   

], function($, _ , Backbone) {

    //Model
    var userModel = Backbone.Model.extend({



        initialize:function(){

            

         

        },
       
        urlRoot : './api/client', 


       
        //Parse
        parse: function(data) {
            return data.data;
        },



    });


    //Return model
    return userModel;

});
