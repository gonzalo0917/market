define([
  'underscore',
  'backbone',
  'models/brandModel'
], function(_, Backbone, brandModel){

  var ContributorsCollection = Backbone.Collection.extend({
      
    model: brandModel,
    url: 'read',
    initialize : function() {
      
    },
    
    parse : function(data) {
      console.log(data);
      return data;
    }      
     
  });

  return ContributorsCollection;

});