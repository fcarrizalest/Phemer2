define([
    'jquery',
    'underscore',
    'backbone',
    'app/views/loginView',
    'app/views/homeView',
    'app/models/userModel',


],function($, _, Backbone, loginView , homeView, userModel  ){

//Routers
    var AppRouter = Backbone.Router.extend({

        routes:{
            "home"  : "home",
            "newclient" : "newClient",
            "client": "clientList",
            "client/:id/edit": "editclient",
            "client/:id": "viewclient",
            "proyect": "proyectList",
            "*actions"  :   "defaultRoute"      //Home (Backbone will try match the route above first)
        }
    });

    //Initialize
    var initialize = function(){

        // Instantiate the router, model, collection
        var app_router  =   new AppRouter();
        var loginview   =   new loginView();
        var homeview    =   new homeView();
        var usermodel   =   new userModel();
        
        
        loginview.usermodel = usermodel;
        homeview.usermodel = usermodel;
        
        loginview.app_router = app_router;
        homeview.app_router = app_router;



          //Route Proyect
        app_router.on('route:proyectList', function(){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                
                homeview.proyectList();

            }

            
            
        });


         //Route Clients
        app_router.on('route:newClient', function(){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                
                homeview.newClient();

            }

            
            
        });

        
        app_router.on('route:editclient', function($id ){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                
                console.log("entreamos a editclient");

                homeview.editclient($id);

            }

            
            
        });

        app_router.on('route:viewclient', function($id ){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                
                homeview.viewclient($id);

            }

            
            
        });




         //Route home
        app_router.on('route:clientList', function(){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                homeview.clientList();

            }

            
            
        });


         //Route home
        app_router.on('route:home', function(){

             if(! usermodel.isLogin() ){
                // no estamos logeados 
               app_router.navigate("login", {trigger: true, replace: true});

            }else{
                homeview.render();

            }

            
            
        });


        //Route Login
        app_router.on('route:defaultRoute', function(){

        
            if(! usermodel.isLogin() ){
                loginview.render();
                

            }else{
                homeview.render();
            }   


        });

        

        // Start Backbone history a necessary step for bookmarkable URL's
        Backbone.history.start();
    };

    return {
        initialize: initialize
    };


} );