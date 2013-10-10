require.config({
  paths: {
    'jquery': 'vendor/jquery',
    'underscore': 'vendor/underscore',
    'backbone': 'vendor/backbone',
    'ajaxfileupload': 'vendor/ajaxfileupload',
    'highcharts': 'vendor/highcharts',
    'templates': '../templates'
  },
  shim: {
    'backbone': {
      //These script dependencies should be loaded before loading
      //backbone.js
      deps: ['underscore', 'jquery'],
      //Once loaded, use the global 'Backbone' as the
      //module value.
      exports: 'Backbone'
    },
    'underscore': {
        exports: '_'
    },
    'ajaxfileupload':{
      deps: ['jquery']
    },
    'highcharts':{
      deps: ['jquery']
    }
  }
});

require(['views/app'], function(AppView) {
  new AppView();
});