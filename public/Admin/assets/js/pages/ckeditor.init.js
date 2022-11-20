$(function(){
    $('.basic-editor').each(function(){
        var heightEditor = $(this).data('height')??200,
        $this = $(this)
        ClassicEditor.create(this, {
            toolbar: {
                items: [
                    'bold', 'italic', 'underline', 'link', '|',
                    'undo', 'redo'
                ]
            },
            language: 'pt-br',
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
        })
        .then(editor => {
            // console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })

    $('.normal-editor').each(function(){
        var heightEditor = $(this).data('height')??400,
        $this = $(this)
        ClassicEditor.create(this, {
            toolbar: {
                items: [
                    'bold', 'italic', 'underline', 'link', 'bulletedList',, 'numberedList', '|',
                    'undo', 'redo'
                ]
            },
            language: 'pt-br',
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
        })
        .then(editor => {
            // console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })

    $('.complete-editor').each(function(){
        var heightEditor = $(this).data('height')??500,
        $this = $(this)

        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                return new MyUploadAdapter( loader );
            };
        }

        ClassicEditor.create(this, {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            licenseKey: '',
        })
        .then(editor => {
            // console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })
})

if($('.basic-editor').length){
    $('body').append(`
        <style>
            .basic-editor__content .ck-editor__editable{
                min-height: 300px;
            }
            .basic-editor__content .image__caption_highlighted{
                min-height: auto !important;
            }
        </style>
    `);
}

if($('.normal-editor').length){
    $('body').append(`
        <style>
            .normal-editor__content .ck-editor__editable{
                min-height: 400px;
            }
            .normal-editor__content .image__caption_highlighted{
                min-height: auto !important;
            }
        </style>
    `);
}

if($('.complete-editor').length){
    $('body').append(`
        <style>
            .complete-editor__content .ck-editor__editable{
                min-height: 500px;
            }
            .complete-editor__content .image__caption_highlighted{
                min-height: auto !important;
            }
        </style>
    `);
}
