/**
 * @license Modifica e usa come vuoi
 *
 * Creato da TurboLab.it - 01/01/2014 (buon anno!)
 */
CKEDITOR.dialog.add( 'tliyoutubeDialog', function( editor ) {

    return {
        title: 'Insert URL of a YouTube video.',
        minWidth: 400,
        minHeight: 75,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'youtubeURL',
                        label: 'Insert URL of a YouTube video.'
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
			var url=dialog.getValueOf( 'tab-basic', 'youtubeURL').trim();
			var regExURL=/v=([^&$]+)/i;
			var id_video=url.match(regExURL);
			
			if(id_video==null || id_video=='' || id_video[0]=='' || id_video[1]=='')
				{
				alert("URL incorrect! In example a\n\n\t http://www.youtube.com/watch?v=abcdef \n\n is correct!");
				return false;
				}

            var oTag = editor.document.createElement( 'iframe' );
			
            oTag.setAttribute( 'width', '560' );
			oTag.setAttribute( 'height', '315' );
			oTag.setAttribute( 'src', '//www.youtube.com/embed/' + id_video[1] + '?rel=0');
			oTag.setAttribute( 'frameborder', '0' );
			oTag.setAttribute( 'allowfullscreen', '1' );

            editor.insertElement( oTag );
        }
    };
});