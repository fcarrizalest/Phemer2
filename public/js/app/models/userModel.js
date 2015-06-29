define([
     'jquery',
    'underscore',
    'backbone',
   

], function($, _ , Backbone) {

    //Model
    var userModel = Backbone.Model.extend({



        initialize:function(){

            

            var ticket = localStorage.getItem("ticket");

            this.set("ticket", ticket);
            

            console.log("Iniciamos modelo de Usuario.");

        },
       
        urlRoot : 'index.php/api/dologin', 


        isLogin:function(){

            console.log("Entramos a isLogin() ");
            console.log( this.get("ticket"));

            if( !this.get("ticket") ){
                //estamos logeados
                console.log("No estamos logeados ");

                return false;

            }

            return true;
        },
        //Parse
        parse: function(data) {
            return data.data;
        },



    });


    //Return model
    return userModel;

});
