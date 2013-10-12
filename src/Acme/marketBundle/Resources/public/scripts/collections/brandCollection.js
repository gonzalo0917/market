define([
  'underscore',
  'backbone',
], function(_, Backbone ){

  var townCollection = Backbone.Collection.extend({
      
    url: 'brand',
    initialize : function() {
      
    },
    
    /*parse : function(data) {
      this.model = data;
      return data;
    }*/      
     
  });

  return townCollection;

});