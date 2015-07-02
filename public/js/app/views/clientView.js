define([
    'jquery',
    'underscore',
    'backbone',
    'mustache',
    'text!templates/clientTemplate.html',
    'datatables2',
    'text!templates/newclientformTemplate.html',
    'app/models/clientModel',
    'text!templates/abcClientButtonBarTemplate.html',
    'app/collections/clientCollection',
    'text!templates/clientViewTemplate.html',
    
     

], function($, _, Backbone , Mustache ,  homeTemplate  , datatables , newclientformTemplate , clientModel, abcClientButtonBarTemplate,clientCollection ,clientViewTemplate ){



	 var ClientView = Backbone.View.extend({ 

	 	el: $("#content"),

	 	initialize:function(){ 
            
            console.log("inicializador de clientView ");
            this.newClientFlag = false;
            this.viewClientFlag = false;

            this.model = new clientModel();
            this.collection = new clientCollection();


        },
        renderActionsButtons:function(row, data, dataIndex){

        	console.log("dentro de renderActionsButtons");
        	console.log(row);
        	console.log(data);
        	console.log(dataIndex);
        	
        	$('td:eq(4)', row).html( Mustache.to_html( abcClientButtonBarTemplate , data ) );
        	this.collection.add(data, {merge: true}); 


        	

        },
	 	render: function(){ 


	 		
	 		if( this.newClientFlag ){ 
		 		$(this.el).html(Mustache.to_html( newclientformTemplate ));
				
				

				//$("#donewclient").on("submit", this.donewclient );		 		
	 		}else if(this.viewClientFlag){

	 			console.log("Entramos a else if");
	 			this.viewclient();

	 		}else{
	 			
	 			this.renderIndex();

	 		}
	 		this.newClientFlag = false;
            this.viewClientFlag = false;

	 		return this;
	 		
	 	},
	 	viewclient:function(){

	 		console.log("back");
	 		
	 		if( this.collection.get(this.id) ){

	 			this.model = this.collection.get(this.id);

	 			console.log("tenemos");
	 			$(this.el).html(Mustache.to_html( clientViewTemplate , this.model.toJSON() ));

	 		}else{
	 			console.log("notenemos")
	 			this.model.set("id",this.id);
	 			var $selft = this;

	 			 this.model.fetch({ success:function(){
	 			 	$($selft.el).html(Mustache.to_html( clientViewTemplate , $selft.model.toJSON() ));


	 			 }} );
	 		}

	 		

	 	},
	 	renderIndex:function(){

	 		$(this.el).html(Mustache.to_html( homeTemplate ));

		 		console.log(datatables);
		 	var table = $('#example').dataTable({
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
		 	table.collection = this.collection;


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