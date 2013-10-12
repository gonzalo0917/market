define([ 
  'jquery',
  'underscore',
  'backbone',
  'highcharts',
  'collections/dataCollection',
  'collections/townCollection',
  'collections/measureCollection',
  'text!templates/chartTemplate.html'
  ], function($, _, Backbone, highcharts, dataCollection, townCollection, measureCollection, chartTemplate ) {

  var App = Backbone.View.extend({
    el: $("#marketer-content"),
    events:{
      "change #marketer-options": "changeTwon"
    },
    initialize: function() {
      //_.bindAll( this );
      var self = this;
      this.towns = new townCollection();
      this.towns.fetch({
        success:function( collection, response, options ){
          self.render( response );
        },
        error: function(collection, response, options){
          alert('Error');
        }
      });
      /*this.brand =  new dataCollection();
      this.brand.fetch();*/
      //this.render();
    },
    render: function( data ){

      var compiledHtml = _.template( chartTemplate, { data:data });
      this.$el.html( compiledHtml );      
    },
    changeTwon: function(e){
      this.getMeasure( this.$el.find( '#marketer-options option:selected' ).val() );
    },
    getMeasure: function( idTown ){

      var self = this;
      this.measures = new measureCollection();
      this.measures.fetch({
        data: {idTown: idTown},
        success: function(collection, response, options){
          self.createChart( response.output );
        },
        error: function(collection, response, options){

        }
      });
    },
    createChart: function( response ){
      this.$el.find('#marketer-chart').highcharts({
            title: {
                text: 'Monthly Average Value',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: response.month
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: response.measures
        });
    }
  });

  return App;
});