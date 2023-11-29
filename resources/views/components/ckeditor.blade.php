<script type="module">
    let desc = document.querySelector('#description');

    ClassicEditor.create(desc)
        .then(res => {
            // console.log(res);
        })
        .catch(err => {
            console.log(err);
        })
</script>