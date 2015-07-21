define([
    'jquery',
    'underscore',
    'backbone',
    'mustache',
    'text!templates/proyectTemplate.html',
    'datatables2',
    'text!templates/newproyectformTemplate.html',
    'app/models/clientModel',
    'text!templates/abcProyectButtonBarTemplate.html',
    'app/collections/clientCollection',
    'text!templates/proyectViewTemplate.html',
    
], function($, _, Backbone , Mustache ,  homeTemplate  , datatables ,newproyectformTemplate,clientModel,abcClientButtonBarTemplate,clientCollection,proyectViewTemplate){

	var View = Backbone.View.extend({ 

		el: $("#content"),
		initialize:function(){ 
            
            console.log("inicializador de proyectView ");
            this.newProyectFlag = false;
            this.viewProyectFlag = false;
            this.editProyectFlag = false;

            this.model = new clientModel();
            this.collection = new clientCollection();




            this.model.urlRoot = './api/proyect';
            //this.collection.url = function() { return './api/proyect' } ;
             

        },
        renderActionsButtons:function(row, data, dataIndex){

        	console.log("dentro de renderActionsButtons");
        	console.log(row);
        	console.log(data);
        	console.log(dataIndex);
        	
        	$('td:eq(2)', row).html( Mustache.to_html( abcClientButtonBarTemplate , data ) );
        	this.collection.add(data, {merge: true}); 


        	

        },
        render: function(){ 


	 		
	 		if( this.newProyectFlag ){ 
		 		$(this.el).html(Mustache.to_html( newproyectformTemplate ));
				
				

				//$("#donewProyect").on("submit", this.donewProyect );		 		
	 		}else if(this.viewProyectFlag){

	 			
	 			this.viewProyect();

	 		}else if(this.editProyectFlag ){

	 			this.editProyect();
	 		}else{
	 			
	 			this.renderIndex();

	 		}
	 		this.newProyectFlag = false;
            this.viewProyectFlag = false;
            this.editProyectFlag = false;

	 		return this;
	 		
	 	},
	 	editProyect:function(){
	 		if( this.collection.get(this.id) ){

	 			this.model = this.collection.get(this.id);

	 			console.log(this.model);
	 			//console.log("tenemos");
	 			$(this.el).html(Mustache.to_html( newproyectformTemplate , this.model.toJSON() ));

	 		}else{
	 			//console.log("notenemos")
	 			this.model.set("id",this.id);
	 			var $selft = this;

	 			 this.model.fetch({ success:function(model,response){
	 			 	
	 			 	console.log("algo");
	 			 	$selft.model.set(response);

	 			 	$($selft.el).html(Mustache.to_html( newproyectformTemplate , $selft.model.toJSON() ));

	 			 	console.log($selft.model.toJSON());
	 			 	

	 			 }} );
	 		}

	 	},
	 	viewProyect:function(){

	 		//console.log("back");
	 		
	 		if( this.collection.get(this.id) ){

	 			this.model = this.collection.get(this.id);

	 			//console.log("tenemos");
	 			$(this.el).html(Mustache.to_html( proyectViewTemplate , this.model.toJSON() ));

	 		}else{
	 			console.log("notenemos")
	 			this.model.set("id",this.id);
	 			var $selft = this;

	 			 this.model.fetch({ success:function(model,response){
	 			 	
	 			 	$selft.model.set(response);
	 			 	$($selft.el).html(Mustache.to_html( proyectViewTemplate , $selft.model.toJSON() ));


	 			 }} );
	 		}

	 		

	 	},
	 	renderIndex:function(){

	 		$(this.el).html(Mustache.to_html( homeTemplate ));

		 	
		 	var table = $('#example').dataTable({
		 		 	"processing": true,
		 		 	
		 		 	"serverSide": true,
		 		 	 "columns": [
            			{ "data": "id" },
            			{ "data": "name" },
            			{ "data": "id"  }

            
        			],
	    			"ajax": {
	        				"url": './api/proyect',
	        				"type": 'GET'
	    			},
	    			"rowCallback": this.renderActionsButtons,


		 		 });
		 	table.collection = this.collection;


	 	},
	 	donewproyect: function(e){
	 		e.preventDefault();
	 		console.log("se presiono ");
	 		console.log(e);
	 		var $self =this;

	 		this.model.set({ 
	 					'id': null,
	 					'name': $("#name").val(), 
	 					'description': $("#description").val()
	 					

	 				} );

	 		this.model.save( null , {success:function(){

	 			$self.newClientFlag = false;
	 			$self.app_router.navigate("proyect", {trigger: true, replace: true});

	 		}});

	 		console.log("success")
	 		$self.newClientFlag = false;
	 		

	 	},
	 	editdonewproyect:function(e){

	 		e.preventDefault();
	 		console.log("se presiono ");
	 		console.log(e);
	 		var $self =this;
	 		this.model.set({ 
	 					
	 					'name': $("#name").val(), 
	 					'description': $("#description").val(),
	 					

	 				} );

	 		console.log(this.model);
	 		this.model.save(null, {success:function(){

	 			$self.editClientFlag = false;
	 			$self.app_router.navigate("proyect", {trigger: true, replace: true});
	 			con
	 		}});

	 	},
	 	deleteproyecte:function(e){

	 		e.preventDefault();
	 		console.log(e);

	 		var $id = $(e.currentTarget).data("id");

	 		console.log($id );
	 		if( this.collection.get($id ) ){
	 			var model = this.collection.get($id ) ;

	 			
	 			model = this.collection.remove($id);

	 			model.urlRoot = './api/proyect';
            
	 			console.log("tenemos el modelo");

	 			console.log(model);

	 			var $self = this;
	 			model.destroy({success: function(model, response) {
  						
  						$self.renderIndex();

				}});
	 			//this.collection.sync();

	 		}
	 	},
	 	events:{
        	'submit #donewproyect'  : "donewproyect",
        	'submit #editdonewproyect'  : "editdonewproyect",

        	'click .deleteproyect' : "deleteproyecte"
        },

	});

	return View;
});