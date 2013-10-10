define([ 
  'jquery',
  'underscore',
  'backbone',
  'highcharts',
  'text!templates/chartTemplate.html'
  ], function($, _, Backbone, highcharts, chartTemplate ) {

  var App = Backbone.View.extend({
    el: $("#marketer-content"),
    events:{},
    initialize: function() {
      //_.bindAll(this);
      this.render();
    },
    render: function(){
      var compiledHtml = _.template( chartTemplate );
      this.$el.html( compiledHtml );
      this.createChart();
    },
    createChart: function(){
      this.$el.find('#marketer-chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Browser market shares at a specific website, 2010'
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Firefox',   45.0],
                ['IE',       26.8],
                {
                    name: 'Chrome',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
                ['Safari',    8.5],
                ['Opera',     6.2],
                ['Others',   0.7]
            ]
        }]
      });
    }
  });

  return App;
});