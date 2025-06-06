@extends('layouts.app')

@section('title', 'Form Event')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Daftar Artikel</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <form id="form-event" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-9">
                <x-card>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-edit"></i> Form Event</span>
                            <a href="{{ route('berita.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul</label>
                        <input id="judul" name="judul" type="text" class="form-control"
                            placeholder="Masukkan judul" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">Isi</label>
                        <textarea id="summernote" name="isi" class="form-control summernote" rows="20" cols="20"
                            placeholder="Tulis isi di sini..."></textarea>
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
                        <strong><i class="fas fa-map-marked"></i> Lokasi</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Tempat Kegiatan</label>
                        <input type="text" class="form-control" autocomplete="off" name="lokasi">
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
                            <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                            <div class="input-group datetimepicker" id="tanggal_mulai" data-target-input="nearest">
                                <input type="text" name="tanggal_mulai" class="form-control datetimepicker-input"
                                    data-target="#tanggal_mulai" data-toggle="datetimepicker" autocomplete="off" />
                                <div class="input-group-append" data-target="#tanggal_mulai" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                            <div class="input-group datetimepicker" id="tanggal_selesai" data-target-input="nearest">
                                <input type="text" name="tanggal_selesai" class="form-control datetimepicker-input"
                                    data-target="#tanggal_selesai" data-toggle="datetimepicker" autocomplete="off" />
                                <div class="input-group-append" data-target="#tanggal_selesai"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Simpan Data
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
            const now = moment(); // sekarang, termasuk jam dan menit

            $('#tanggal_mulai').datetimepicker({
                format: 'YYYY-MM-DD HH:mm', // pakai jam dan menit
                useCurrent: false,
                minDate: now // tidak boleh pilih waktu sebelum sekarang
            });

            $('#tanggal_selesai').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                useCurrent: false,
                minDate: now
            });

            // Saat tanggal mulai diubah, tanggal selesai harus >= tanggal mulai
            $('#tanggal_mulai').on('change.datetimepicker', function(e) {
                const startDate = e.date;
                $('#tanggal_selesai').datetimepicker('minDate', startDate);
            });
        });


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
        $('#form-event').on('submit', function(e) {
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
                url: '{{ route('event.store') }}', // Ubah sesuai route simpan artikel kamu
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
                            '{{ route('event.index') }}'; // Redirect setelah simpan
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
