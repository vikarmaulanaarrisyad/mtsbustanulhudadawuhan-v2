<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                <select id="kategori_id" class="form-control select2" name="kategori_id" style="width: 100%;">
                    <option value="">Pilih Kategori</option>
                </select>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#kategori_id').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Kategori',
                allowClear: true,
                ajax: {
                    url: '{{ route('kategori.getAll') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

        });
    </script>
@endpush
