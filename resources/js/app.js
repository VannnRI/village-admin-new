import './bootstrap';
// Jika ada inisialisasi atau import lain yang diperlukan, tambahkan di sini.
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import SourceEditing from '@ckeditor/ckeditor5-source-editing/src/sourceediting';

ClassicEditor.builtinPlugins = [
    ...ClassicEditor.builtinPlugins,
    SourceEditing
];

document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.querySelector('#template_html');
    if (textarea) {
        ClassicEditor.create(textarea, {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                '|', 'insertTable', 'imageUpload', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', 'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', 'imageTextAlternative',
                '|', 'undo', 'redo', 'alignment', 'outdent', 'indent', 'removeFormat', 'htmlEmbed', 'mediaEmbed', 'sourceEditing'
            ],
            image: {
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText',
                    '|', 'imageTextAlternative'
                ],
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight', 'inline', 'wrapText', 'breakText'
                ]
            },
            table: {
                contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ]
            },
            extraPlugins: [SourceEditing]
        }).catch(error => {
            console.error(error);
        });
    }
});


