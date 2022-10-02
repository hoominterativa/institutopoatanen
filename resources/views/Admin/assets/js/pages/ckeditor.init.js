$(function(){
    $('.basic-editor').each(function(){
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
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })

    $('.normal-editor').each(function(){
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
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })

    $('.complete-editor').each(function(){
        ClassicEditor.create(this, {
            toolbar: {
                items: [
                    'bold', 'italic', 'underline', 'alignment', 'fontBackgroundColor', 'fontColor', 'link', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                    'code', 'codeBlock', '|',
                    'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'
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
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    })
})
