@extends('layouts.app')

@section('title', 'Edit Event')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Daftar Event</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <form id="form-event" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <x-card>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-edit"></i> Edit Event</span>
                            <a href="{{ route('event.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Event</label>
                        <input id="judul" name="judul" type="text" class="form-control"
                            value="{{ old('judul', $event->judul) }}" placeholder="Masukkan judul artikel"
                            autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">Isi Event</label>
                        <textarea id="summernote" name="isi" class="form-control summernote" rows="20" cols="20"
                            placeholder="Tulis isi di sini...">{{ old('isi', $event->deskripsi) }}</textarea>
                    </div>
                </x-card>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-image"></i> Thumbnail</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Unggah Gambar</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                    </div>
                    <div class="text-center">
                        <img id="preview-thumbnail" src="{{ $event->gambar ? asset('storage/' . $event->gambar) : '#' }}"
                            class="img-thumbnail {{ $event->gambar ? '' : 'd-none' }} mt-2" style="max-height: 200px;"
                            alt="Preview thumbnail">
                    </div>
                </x-card>

                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-cogs"></i> Pengaturan Tambahan</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="file" class="form-label">Dokumen Lampiran</label>
                        <input type="file" name="file" id="file" class="form-control">
                        @php
                            $namaFile = $event->file ? basename($event->file) : null;
                        @endphp

                        @if ($event->file)
                            donwload file : <a href="{{ asset('storage/' . $event->file) }}" download>
                                {{ $namaFile }}</a>
                        @else
                            <p>Tidak ada file</p>
                        @endif
                    </div>

                    <div class="mb-2">
                        <label for="nama_file" class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_file" id="nama_file" class="form-control"
                            value="{{ old('nama_file', $event->nama_file) }}" placeholder="Contoh: Panduan.pdf">
                        <small class="text-muted">Nama ini akan tampil sebagai link download.</small>
                    </div>

                    <div class="mb-2">
                        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div class="input-group datetimepicker" id="tanggal_mulai" data-target-input="nearest">
                            <input type="text" name="tanggal_mulai" class="form-control datetimepicker-input"
                                data-target="#tanggal_mulai" data-toggle="datetimepicker" autocomplete="off"
                                value="{{ old('tanggal_mulai', $event->tanggal_mulai) }}" />
                            <div class="input-group-append" data-target="#tanggal_mulai" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Update Artikel
                    </button>
                </x-card>
            </div>
        </div>
    </form>
@endsection

@include('includes.summernote')
@include('includes.datepicker')

@push('scripts')
    <script>
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

        // AJAX Update Artikel
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
                url: '{{ route('event.update', $event->id) }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Artikel berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('event.index') }}';
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
