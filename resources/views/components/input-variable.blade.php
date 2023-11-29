<script>
    let csrf_token = document.querySelector('[name="csrf_token"]').content;
    let addNoteForm = document.querySelector('#addNoteForm');
    let title_input = addNoteForm.querySelector('[name="title"]').value;
    let desc_input = addNoteForm.querySelector('[name="description"]').value;
    let title_error = addNoteForm.querySelector('#title_error');
    let desc_error = addNoteForm.querySelector('#desc_error');
</script>