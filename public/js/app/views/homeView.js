define([
    'jquery',
    'underscore',
    'backbone',
    'mustache',
    'text!templates/homeTemplate.html',
    'app/views/clientView',

], function($, _, Backbone , Mustache ,  homeTemplate , clientView ){

	 var HomeView = Backbone.View.extend({ 
	 	el: $("#page"),
	 	initialize:function(){ 

         
            this.clientview = new clientView();

           


        },
	 	render: function(){ 

            if( this.dyView){
                //this.dyView.remove();
                this.dyView = false;

                

            }

	 		$(this.el).html(Mustache.to_html( homeTemplate ));


            console.log("Tenemos el ticket???");

            console.log( this.usermodel.get("ticket"));
            
            $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#page-content-wrapper").toggleClass("toggled");
            $("#sidebar-wrapper").toggleClass("toggled");
            $(".sidebar-nav").toggleClass("toggled");
            $("#wrapper").toggleClass("toggled");
            

    });
            

	 	},

        clientList: function () {

            console.log("entramos a client List ");

            this.render();

            console.log("ejecutamos render");
            
            
            if(!this.dyView){
                this.dyView =  this.clientview;
                this.dyView.setElement (  $("#content") );

            }
            this.dyView.app_router = this.app_router;

            console.log( this.clientView );

            this.dyView.render();

        },

        newClient: function(){

            this.render();

            console.log("Render newClient");
            console.log(this.dyView);
            if(!this.dyView){
                this.dyView =  this.clientview;
                this.dyView.setElement (  $("#content") );
                
            }
                //this.dyView = new clientView( { el: $("#content") });

            console.log("Render dyView");
            console.log(this.dyView);

            this.dyView.newClientFlag = true ;
            this.dyView.app_router = this.app_router;
            
            console.log( this.clientView );

            this.dyView.render();

        },
        viewclient: function($id){
            this.render();


            if(!this.dyView){
                this.dyView =  this.clientview;
                this.dyView.setElement (  $("#content") );
                
            }
                //this.dyView = new clientView( { el: $("#content") });

            this.dyView.viewClientFlag = true ;
            this.dyView.id = $id ;
            this.dyView.app_router = this.app_router;
            
            //console.log( this.clientView );

            this.dyView.render();



        },
	 	events:{
        

        },

       


	 });

	 return HomeView;
});