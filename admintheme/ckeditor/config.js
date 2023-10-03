/**

 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.md or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here. For example:

	// config.language = 'fr';

	// config.uiColor = '#AADC6E';

	//config.contentsCss ='/frontassets/css/styles.css';
	config.contentsCss ='./admintheme/ckeditor/fonts.css';
    config.font_names = 'Futura-Medium;' + config.font_names;

   /*  config.contentsCss = './admintheme/ckeditor/fonts.css';

    config.font_names =  'Futura-Medium'+config.font_names; */

	//config.doksoft_include_js={'/path3/js2.js','/path4/js/js.js'};

		config.allowedContent = true;

	config.extraAllowedContent = '*{*}';

 	CKEDITOR.dtd.$removeEmpty.span=0;

 	config.removePlugins = 'htmldataprocessor';

 	//config.entities = false;

 	config.htmlEncodeOutput = false;

 	CKEDITOR.config.autoParagraph = false;

 	//CKEDITOR.dtd.select.custom_tag = 1;

 	config.fillEmptyBlocks = false;

	CKEDITOR.dtd.$removeEmpty['i'] = false;

	config.autoParagraph = false;

	//config.protectedSource.push( /<i class[\s\S]*?\>/g );

    //config.protectedSource.push( /<\/i>/g );

	 

};

CKEDITOR.on('instanceReady', function (ev) {

// Ends self closing tags the HTML4 way, like <br>.

ev.editor.dataProcessor.htmlFilter.addRules(

    {

        elements:

        {

            $: function (element) {

                // Output dimensions of images as width and height

                if (element.name == 'img') {

                    var style = element.attributes.style;



                    if (style) {

                        // Get the width from the style.

                        var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec(style),

                            width = match && match[1];



                        // Get the height from the style.

                        match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);

                        var height = match && match[1];



                        if (width) {

                            element.attributes.style = element.attributes.style.replace(/(?:^|\s)width\s*:\s*(\d+)px;?/i, '');

                            element.attributes.width = width;

                        }



                        if (height) {

                            element.attributes.style = element.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');

                            element.attributes.height = height;

                        }

                    }

                }







                if (!element.attributes.style)

                    delete element.attributes.style;



                return element;

            }

        }

    });

});