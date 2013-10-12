define([ 
  'jquery',
  'underscore',
  'backbone',
  'collections/brandCollection',
  'text!templates/brandTemplate.html',
  'text!templates/modalTemplate.html'
  ], function($, _, Backbone, brandCollection, brandTemplate, modalTemplate ) {

  var App = Backbone.View.extend({
    el: $("#marketer-content"),
    onSelected:{},
    events:{
      "click #marketer-tbl tbody tr": "onSelectRow",
      "click #close": "hideModal",
      "click .close": "hideModal",
      "click #save": "updateBrand"
    },
    initialize: function() {
      var self = this;
      this.towns = new brandCollection();
      this.towns.fetch({
        success:function( collection, response, options ){
          self.render( response );
        },
        error: function(collection, response, options){
          alert('Error');
        }
      });
    },
    getRow: function(e){
      this.onSelected = {
        idbrand: this.$el.find(e.currentTarget).find('td[name=idbrand]').text(),
        brand: this.$el.find(e.currentTarget).find('td[name=brand]').text(),
        description: this.$el.find(e.currentTarget).find('td[name=description]').text(),
      }      
    },
    render: function( data ){
      var compiledHtml = _.template( brandTemplate, { data:data } );
      this.$el.html( compiledHtml );      
    },
    onSelectRow: function(e){
      this.getRow( e );
      this.showModal();
    },
    showModal: function(){

      var compiledHtml = _.template( modalTemplate, { data: this.onSelected });
      this.$el.find('#marketer-tbl-modal').html( compiledHtml );
      this.$el.find('#marketer-tbl-modal-edit').show();
    },
    hideModal: function(e){
      this.$el.find('#marketer-tbl-modal-edit').hide();
    },
    updateBrand: function(){
      var self = this;
      this.brand = new brandCollection();
      this.brand.url = 'brandUpdate';
      this.onSelected.brand = this.$el.find('#marketer-brand').val();
      this.onSelected.description = this.$el.find('#marketer-description').val(),

      this.brand.fetch({
        data: this.onSelected,
        success:function( collection, response, options ){
          alert('El cambio se guardo exitosamente.');
          self.initialize();
        },
        error: function(collection, response, options){
          alert('Error');
        }
      });
    }
  });

  return App;
});