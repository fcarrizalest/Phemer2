define([
    'underscore',
    'backbone',
    'app/models/clientModel'

], function(_, Backbone , clientModel){

    //Collection
    var Collection = Backbone.Collection.extend({

        model: clientModel,
        url : function() { return './api/client'; }, 
        //Parse
        parse: function(data) {
            return data.data;
        }
        
    });

    //Return Collection
    return Collection;

});