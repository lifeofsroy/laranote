<script>
    tinymce.init({
        selector: '#mydesc',
        plugins: 'save anchor autolink charmap codesample emoticons image link lists advlist media searchreplace table visualblocks wordcount visualchars searchreplace quickbars preview pagebreak insertdatetime fullscreen',
        toolbar: 'save undo redo preview | blocks fontfamily fontsize | bold italic underline strikethrough | link image media | align lineheight | numlist bullist indent outdent | emoticons charmap searchreplace | removeformat visualchars | table pagebreak insertdatetime codesample advlist fullscreen',
        quickbars_insert_toolbar: 'quicktable image media codesample',
        quickbars_selection_toolbar: 'bold italic underline | blocks | bullist numlist | blockquote quicklink',
        codesample_languages: [{
                text: 'HTML/XML',
                value: 'markup'
            },
            {
                text: 'JavaScript',
                value: 'javascript'
            },
            {
                text: 'CSS',
                value: 'css'
            },
            {
                text: 'PHP',
                value: 'php'
            },
        ],

        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },

        image_title: true,
        image_caption: true,
        automatic_uploads: true,
        image_advtab: true,
        a11y_advanced_options: true,
        file_picker_types: 'image, file, media',
        image_description: true,
        image_dimensions: true,
        image_uploadtab: true,
        branding: false,
        images_file_types: 'jpg,svg,webp,png',
        images_upload_base_path: '/tinymce',
        images_upload_url: '{{ route('upload') }}'
    });
</script>
