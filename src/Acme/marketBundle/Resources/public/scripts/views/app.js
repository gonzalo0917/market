define([ 
  'jquery',
  'underscore',
  'backbone',
  'ajaxfileupload',
  'views/chartView',
  'views/brandView',
  'text!templates/messageTemplate.html'
  ], function($, _, Backbone, ajaxfileupload, chartView, brandView, messageTemplate) {

  var App = Backbone.View.extend({
    existsFile:false,
    fileElementId: 'file',
    el: $("#marketer-page"),
    events:{
      "click #marketer-btn-upload": "uploadFile",
      "change #file": "validateFile",
      "click #marketer-menu li > a": "xaction"
    },
    initialize: function() {
      //_.bindAll(this);
      //console.log( $('#marketer-menu li'));
    },
    validateFile: function( e ){

      var re_text = /\.csv|\.xls/i;
      var filename = $(e.currentTarget).val();
      if (filename.search(re_text) == -1){
        
        alert('The extension file is not of type(.csv).');      
      }
      else{
        this.existsFile = true;
      }

    },
    xaction: function(e){
      this.$el.find('#marketer-menu li[class*=active]').removeClass('active');
      this.$el.find( e.currentTarget ).parent().addClass('active');
      switch( this.$el.find(e.currentTarget).attr('xaction') ){
        case 'edit':          
          new brandView();
          break;
        case 'chart':
          new chartView();
          break;
        default:
          break;
      }
      
    },
    uploadFile: function(e){
      var self =  this;
      if(this.existsFile){
        $.ajaxFileUpload({
        url:'upload', 
        secureuri:false,
        fileElementId: this.fileElementId,
        dataType: 'text',
        data: {},
        success: function (data, status){ 
          var response = data.replace('</pre>','').replace('<pre>','');   
          response = $.parseJSON( response );
          var compiledHtml = _.template( messageTemplate, response );
          self.$el.find('#marketer-content').html( compiledHtml );

        },
        error: function (data, status){
          alert('It is '+ status);
        }
      });
      }

    }
  });

  return App;
});