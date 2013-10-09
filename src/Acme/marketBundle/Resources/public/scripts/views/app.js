define([ 
  'jquery',
  'underscore',
  'backbone',
  'ajaxfileupload',
  'text!templates/messageTemplate.html'
  ], function($, _, Backbone, ajaxfileupload, messageTemplate) {

  var App = Backbone.View.extend({
    existsFile:false,
    fileElementId: 'file',
    el: $("#marketer-page"),
    events:{
      "click #marketer-btn-upload": "uploadFile",
      "change #file": "validateFile"
    },
    initialize: function() {
      //_.bindAll(this);
      console.log( 'Wahoo!' );
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
          console.log(response);
          var compiledHtml = _.template( messageTemplate, response );
          self.$el.html( compiledHtml );

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