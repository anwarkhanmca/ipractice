﻿/*
 Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
/*
CKEDITOR.dialog.add("placeholder",function(a){var b=a.lang.placeholder;a=a.lang.common.generalTab;return{title:b.title,minWidth:300,minHeight:80,contents:[{id:"info",label:a,title:a,elements:[{id:"name",type:"text",style:"width: 100%;",label:b.name,"default":"",required:!0,validate:CKEDITOR.dialog.validate.regex(/^[^\[\]<>]+$/,b.invalidName),setup:function(a){this.setValue(a.data.name)},commit:function(a){a.setData("name",this.getValue())}}]}]}});


*/

console.log('placeholder');

CKEDITOR.dialog.add("placeholder", function(a) {
    var b = a.lang.placeholder;
    a = a.lang.common.generalTab;
    return {
        title: b.title,
        minWidth: 300,
        minHeight: 80,
        contents: [{
            id: "info",
            label: a,
            title: a,
            elements: [{
                
                id: "name",
                type : 'select',
                items : [ [ 'option1' ], [ 'option2' ],[ 'option3' ], [ 'option4' ] ],
                'default' : 'option4',
              //  type: "text",
                style: "width: 100%;",
                
                
                label: b.name,
                //"default": "",
                required: !0,
                validate: CKEDITOR.dialog.validate.regex(/^[^\[\]<>]+$/, b.invalidName),
                setup: function(a) {
                    this.setValue(a.data.name)
                },
                commit: function(a) {
                    a.setData("name", this.getValue())
                }
            }]
            
            
        }]
    }
});