@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@push('scripts_vendor')
    <script src="{{ asset('/AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $('.summernote').summernote({
            //fontNames: [''],
            height: 450,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', ]]
            ]
        });
        $('.note-btn-group.note-fontname').remove();
        setTimeout(() => {
            $('.note-btn-group.note-fontname').remove();
        }, 300);
    </script>
@endpush
