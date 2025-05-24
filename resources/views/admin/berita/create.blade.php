@extends('layouts.app')

@section('title', 'Form Artikel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Daftar Artikel</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <form id="form-artikel" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-9">
                <x-card>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-edit"></i> Form Artikel</span>
                            <a href="{{ route('berita.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Artikel</label>
                        <input id="judul" name="judul" type="text" class="form-control"
                            placeholder="Masukkan judul artikel" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">Isi Artikel</label>
                        <textarea id="summernote" name="isi" class="form-control summernote" rows="20" cols="20"
                            placeholder="Tulis isi artikel di sini..."></textarea>
                    </div>
                </x-card>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-3">
                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-image"></i> Thumbnail</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Unggah Gambar</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                    </div>
                    <div class="text-center">
                        <img id="preview-thumbnail" src="#" class="img-thumbnail d-none mt-2"
                            style="max-height: 200px;" alt="Preview thumbnail">
                    </div>
                </x-card>

                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-image"></i> Kategori</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Pilih Kategori</label>
                        <select id="kategori_id" class="form-control select2" name="kategori_id" style="width: 100%;">
                        </select>
                    </div>
                </x-card>

                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-cogs"></i> Pengaturan Tambahan</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="file" class="form-label">Dokumen Lampiran</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="nama_file" class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_file" id="nama_file" class="form-control"
                            placeholder="Contoh: Panduan.pdf">
                        <small class="text-muted">Nama ini akan tampil sebagai link download.</small>
                    </div>
                    <div class="mb-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" name="status">
                                <option disabled selected>Pilih salah satu</option>
                                <option value="publish">Publik</option>
                                <option value="arsip">Arsip</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-group">
                            <label for="published_at">Tanggal Posting <span class="text-danger">*</span></label>
                            <div class="input-group datetimepicker" id="published_at" data-target-input="nearest">
                                <input type="text" name="published_at" class="form-control datetimepicker-input"
                                    data-target="#published_at" data-toggle="datetimepicker" autocomplete="off"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d HH:mm:ss') }}" />

                                <div class="input-group-append" data-target="#published_at" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Simpan Artikel
                    </button>
                </x-card>
            </div>
        </div>
    </form>
@endsection

@include('includes.summernote')
@include('includes.datepicker')
@include('includes.select2')

@push('scripts')
    <script>
        $(document).ready(function() {
            // Ajax mengambil kategori_id
            $.ajax({
                url: '{{ route('kategori.getAll') }}',
                method: 'GET',
                success: function(response) {
                    $('#kategori_id').append('<option value="">Pilih Kategori</option>');
                    $.each(response.data, function(index, item) {
                        $('#kategori_id').append(
                            `<option value="${item.id}">${item.nama}</option>`
                        );
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Kategori',
                        text: 'Terjadi kesalahan saat mengambil data kategori.'
                    });
                }
            });
        })

        // Preview Gambar
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-thumbnail');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
            }
        });

        // AJAX Simpan Artikel
        $('#form-artikel').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Harap tunggu, data sedang diproses',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('berita.store') }}', // Ubah sesuai route simpan artikel kamu
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Artikel berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href =
                            '{{ route('berita.index') }}'; // Redirect setelah simpan
                    });
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg
                    });

                    if (xhr.status === 422) {
                        loopErrors(xhr.responseJSON.errors);
                    }
                }
            });
        });
    </script>
@endpush
