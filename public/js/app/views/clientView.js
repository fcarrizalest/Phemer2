define([
    'jquery',
    'underscore',
    'backbone',
    'mustache',
    'text!templates/clientTemplate.html',
    'datatables2',
    'text!templates/newclientformTemplate.html',
    'app/models/clientModel',
    'text!templates/abcClientButtonBarTemplate.html'
    
     

], function($, _, Backbone , Mustache ,  homeTemplate  , datatables , newclientformTemplate , clientModel, abcClientButtonBarTemplate  ){



	 var ClientView = Backbone.View.extend({ 

	 	el: $("#content"),

	 	initialize:function(){ 
            
            console.log("inicializador de clientView ");
            this.newClientFlag = false;
            this.model = new clientModel();


        },
        renderActionsButtons:function(row, data, dataIndex){

        	console.log("dentro de renderActionsButtons");
        	console.log(row);
        	console.log(data);
        	console.log(dataIndex);
        	



        	$('td:eq(4)', row).html( Mustache.to_html( abcClientButtonBarTemplate , data ) );





        },
	 	render: function(){ 

	 		
	 		if( !this.newClientFlag ){ 
		 		
		 		$(this.el).html(Mustache.to_html( homeTemplate ));

		 		console.log(datatables);
		 		 $('#example').dataTable({
		 		 	"processing": true,
		 		 	
		 		 	"serverSide": true,
		 		 	 "columns": [
            			{ "data": "id" },
            			{ "data": "title" },
            			{ "data": "firstname" },
            			{ "data": "lastname" },
            			{ "data": "id"  }

            
        			],
	    			"ajax": {
	        				"url": './api/client',
	        				"type": 'GET'
	    			},
	    			"rowCallback": this.renderActionsButtons,


		 		 });

	 		}else{

	 			$(this.el).html(Mustache.to_html( newclientformTemplate ));

	 		}
	 	},

	 	donewclient: function(e){
	 		e.preventDefault();
	 		console.log("se presiono ");
	 		console.log(e);
	 		var $self =this;

	 		this.model.set({ 
	 					'title': $("#title").val(), 
	 					'firstname': $("#firstname").val(),
	 					'lastname': $("#lastname").val()

	 				} );

	 		this.model.save();

	 		console.log("success")
	 		$self.newClientFlag = false;
	 		$self.app_router.navigate("client", {trigger: true, replace: true});


	 	},
	 	events:{
        	'submit #donewclient'  : "donewclient"

        },



	 } );

	 return ClientView;
} );