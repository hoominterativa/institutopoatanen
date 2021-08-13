ClassicEditor
    .create(document.querySelector('#basic-editor'), {
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

ClassicEditor
    .create(document.querySelector('#complete-editor'), {
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
