/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
      config.filebrowserUploadUrl ='/uploader/upload.php';
	config.extraPlugins='simpleuploads,imagecrop';

      config.imagecrop = {
      cropsizes : [
            {width:120, height:120, title:"120px square", name:"Thumbnail"},
            {width:400, height:300, title:"400 * 300", name:"Content picture"},
            {width:960, height:350, title:"960 * 350", name:"Big header"},
            {width:0, height:0, title:"No restrictions", name:"Free crop"}
            ],
      formats : [
            { title:"JPG - Low quality", value:"jpg60"},
            { title:"JPG - Normal quality", value:"jpg80", attributes:"selected"},
            { title:"JPG - High quality", value:"jpg90"},
            { title:"PNG (for texts)", value:"png"}
            ],
      maximumDimensions : {width:1024, height:1024}
};
	
};
