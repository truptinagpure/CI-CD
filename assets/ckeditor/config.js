/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.dtd.a.div = 1;
CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    //config.uiColor = '#ffffff';
    if($('html')[0].lang.length){
        config.language = $('html')[0].lang;
    }
    
    config.filebrowserImageBrowseUrl = 'https://somaiya.com/ckfinder/ckfinder.html?type=Images';
    config.filebrowserImageUploadUrl = 'https://somaiya.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    config.filebrowserUploadUrl = 'https://somaiya.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    config.filebrowserBrowseUrl= 'https://somaiya.com/ckfinder/ckfinder.html?resourceType=Files';
    
    config.allowedContent = true;
    config.autoParagraph = false;
    config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';
    config.protectedSource.push(/<i[^>]*><\/i>/g);
};
