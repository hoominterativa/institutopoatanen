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
            toolbar: {
                items: [
                    'bold', 'italic', 'underline', 'alignment', 'fontBackgroundColor', 'fontColor', 'link', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                    'code', 'codeBlock', '|',
                    'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo', 'toggleImageCaption', 'imageTextAlternative'
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
})

if($('.basic-editor').length){
    $('body').append(`
        <style>
            .basic-editor__content .ck-editor__editable{
                min-height: 300px
            }
        </style>
    `);
}

if($('.normal-editor').length){
    $('body').append(`
        <style>
            .normal-editor__content .ck-editor__editable{
                min-height: 400px
            }
        </style>
    `);
}

if($('.complete-editor').length){
    $('body').append(`
        <style>
            .complete-editor__content .ck-editor__editable{
                min-height: 500px
            }
        </style>
    `);
}


class MyUploadAdapter {
    constructor( loader ) {
        // CKEditor 5's FileLoader instance.
        this.loader = loader;

        // URL where to send files.
        this.url = $url+'/storage/uploads/tmp';
    }

    // Starts the upload process.
    upload() {
        return new Promise( ( resolve, reject ) => {
            this._initRequest();
            this._initListeners( resolve, reject );
            this._sendRequest();
        } );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Example implementation using XMLHttpRequest.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        xhr.open( 'POST', this.url, true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            resolve( {
                default: response.url
            } );
        } );

        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest() {
        const data = new FormData();

        data.append( 'upload', this.loader.file );

        this.xhr.send( data );
    }
}
