define([
  'underscore',
  'backbone',
], function(_, Backbone ){

  var townCollection = Backbone.Collection.extend({
      
    url: 'town',
    initialize : function() {
      
    },
    
    /*parse : function(data) {
      this.model = data;
      return data;
    }*/      
     
  });

  return townCollection;

});