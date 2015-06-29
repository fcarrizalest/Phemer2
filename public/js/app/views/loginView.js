define([
    'jquery',
    'underscore',
    'backbone',
    'mustache',
    'text!templates/loginTemplate.html',

], function($, _, Backbone , Mustache ,  loginTemplate  ){

	 var HomeView = Backbone.View.extend({ 
	 	el: $("#page"),
	 	
	 	render: function(){ 


	 		$(this.el).html(Mustache.to_html( loginTemplate ));



	 	},
	 	 events:{
            "click .dologin" : "doLogin"
        },

        doLogin:function(){

        	var $username = $("#username").val();
        	var $password = $("#password").val();

            console.log( this.usermodel);
        	
            this.usermodel.set(  {username: $username , password:$password  } );

           // console.log( this.usermodel);
            
            var $self = this;
            this.usermodel.save(null,{ 
                        error: function(){

                        },success: function(model, response){
                            console.log("entramos a success");
                            console.log(response);
                            model.set("ticket",  response.ticket );

                            localStorage.setItem('ticket', response.ticket );

                            $self.app_router.navigate("home", {trigger: true, replace: true});

                        }
            });




        }


	 });

	 return HomeView;
});