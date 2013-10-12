define([
  'underscore',
  'backbone',
], function( _, Backbone ){

  var townCollection = Backbone.Collection.extend({
      
    url: 'measure',
    initialize : function() {
      
    }     
     
  });

  return townCollection;

});