/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
//header("Access-Control-Allow-Origin: *");
CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    //config.uiColor = '#ffffff';
    if($('html')[0].lang.length){
        config.language = $('html')[0].lang;
    }

    config.filebrowserImageBrowseUrl = 'https://www.somaiya.com/ckfinder/ckfinder.html?type=Images';
    config.filebrowserImageUploadUrl = 'https://www.somaiya.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    config.filebrowserUploadUrl = 'https://www.somaiya.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    config.filebrowserBrowseUrl= 'https://www.somaiya.com/ckfinder/ckfinder.html?resourceType=Files';

    config.allowedContent = true;
    config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';
    config.protectedSource.push(/<i[^>]*><\/i>/g);
};
