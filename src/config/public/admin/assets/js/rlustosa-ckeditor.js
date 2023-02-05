/**
 * Created by rupertlustosa on 16/11/15.
 */

if($('#texto').length){
    CKEDITOR.replace('texto', {
        "filebrowserBrowseUrl": $('meta[name="url-filemanager-show"]').attr('content'),
        toolbar: [
            {name: 'document', items: ['Source', '-', 'NewPage', 'Preview']},	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            {
                name: 'basicstyles',
                groups: ['basicstyles', 'cleanup'],
                items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
            },
            {
                name: 'paragraph',
                groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
            },
            '/',
            {
                name: 'insert',
                items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
            },
            {name: 'links', items: ['Link', 'Unlink']}
        ],
        height: 800,
        resize_dir: 'both',
        resize_minWidth: 200,
        resize_minHeight: 300,
        resize_maxWidth: 800
    });
}


if($('#conteudo').length) {
    CKEDITOR.replace('conteudo', {
        "filebrowserBrowseUrl": $('meta[name="url-filemanager-show"]').attr('content'),
        toolbar: [
            {name: 'document', items: ['Source', '-', 'NewPage', 'Preview']},	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
            {
                name: 'basicstyles',
                groups: ['basicstyles', 'cleanup'],
                items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
            },
            {
                name: 'paragraph',
                groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
            },
            '/',
            {
                name: 'insert',
                items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
            },
            {name: 'links', items: ['Link', 'Unlink']}
        ],
        height: 800,
        resize_dir: 'both',
        resize_minWidth: 200,
        resize_minHeight: 300,
        resize_maxWidth: 800
    });
}






CKEDITOR.stylesSet.add('default', [
    // Block Styles
    {name: 'Blue Title', element: 'h3', styles: {'color': 'Blue'}},
    {name: 'Red Title', element: 'h3', styles: {'color': 'Red'}},

    // Inline Styles
    {name: 'Marker: Yellow', element: 'span', styles: {'background-color': 'Yellow'}},
    {name: 'Marker: Green', element: 'span', styles: {'background-color': 'Lime'}},

    // Object Styles
    /*{
     name: 'Imagem na esquerda',
     element: 'img',
     attributes: {
     style: 'padding: 5px; margin-right: 5px',
     border: '2',
     align: 'left'
     }
     },*/
    /*http://chipcullen.com/how-to-apply-classes-ckeditor-4-in-drupal-7/*/
    {
        name: 'Bootstrap - Imagem na esquerda',
        element: 'img',
        attributes: {
            'class': 'align-left'
        }
    },
    {
        name: 'Bootstrap - Imagem na direita',
        element: 'img',
        attributes: {
            'class': 'align-right'
        }
    },
    /*http://docs.ckeditor.com/#!/guide/dev_howtos_styles*/
    {
        name: 'Bootstrap - Imagem adaptável',
        element: 'img',
        attributes: {'class': 'img-responsive'}
    },
    {
        name: 'Bootstrap - Imagem thumbnail',
        element: 'img',
        attributes: {'class': 'img-thumbnail'}
    },
    {
        name: 'Bootstrap - Imagem rounded',
        element: 'img',
        attributes: {'class': 'img-rounded'}
    }
]);