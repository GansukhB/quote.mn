CKEDITOR.plugins.add( 'red',
{
  requires : [ 'basicstyles', 'button' ],

  init : function( editor )
  {
    // This "addButtonCommand" function isn't needed, but
    // would be useful if you want to add multiple buttons
    var addButtonCommand = function( buttonName, buttonLabel, commandName, styleDefiniton )
    {
      var style = new CKEDITOR.style( styleDefiniton );
      editor.attachStyleStateChange( style, function( state )
        {
          !editor.readOnly && editor.getCommand( commandName ).setState( state );
        });

      editor.addCommand( commandName, new CKEDITOR.styleCommand( style ) );
      editor.ui.addButton( buttonName,
        {
          label : buttonLabel,
          command : commandName,
          icon: CKEDITOR.plugins.getPath('red') + 'images/red.jpeg'
        });
    };

    var config = editor.config,
      lang = editor.lang;

    // This version uses the language functionality, as used in "basicstyles"
    // you'll need to add the label to each language definition file
    addButtonCommand( 'Tweet this!'   , lang.red    , 'red'   , config.coreStyles_red );

    // This version hard codes the label for the button by replacing `lang.red` with 'Red'
    addButtonCommand( 'Tweet this!'   , 'Tweet this!'   , 'red'   , config.coreStyles_red );
  }
});

// The basic configuration that you requested
CKEDITOR.config.coreStyles_red = { element : 'span', attributes : {'class': 'tweet-this-span'} };

// You can assign multiple attributes too
CKEDITOR.config.coreStyles_red = { element : 'span', attributes : { 'class': 'tweet-this-span', 'style' : 'background-color: #e2f1f9;', 'title' : 'Share to twitter' } };