<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 450,
        plugins: 'link image media table code lists fullscreen',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image media | code fullscreen',
        relative_urls: false,
        remove_script_host: false,
        document_base_url: "{{ url('/') }}/",
    });
</script>