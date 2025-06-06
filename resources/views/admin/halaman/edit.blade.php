@extends('layouts.app')

@section('title', 'Edit Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('halaman.index') }}">Daftar Halaman</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <form id="form-halaman" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <x-card>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-edit"></i> Edit Halaman</span>
                            <a href="{{ route('halaman.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Halaman</label>
                        <input id="judul" name="judul" type="text" class="form-control"
                            value="{{ old('judul', $halaman->judul) }}" placeholder="Masukkan judul halaman"
                            autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">Isi</label>
                        <textarea id="summernote" name="isi" class="form-control summernote" rows="20" cols="20"
                            placeholder="Tulis isi di sini...">{{ old('isi', $halaman->isi) }}</textarea>
                    </div>
                </x-card>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-cogs"></i> Pengaturan Tambahan</strong>
                    </x-slot>

                    <div class="mb-3">
                        <label for="file" class="form-label">Dokumen Lampiran</label>
                        <input type="file" name="file" id="file" class="form-control">
                        @php
                            $namaFile = $halaman->file ? basename($halaman->file) : null;
                        @endphp

                        @if ($halaman->file)
                            donwload file : <a href="{{ asset('storage/' . $halaman->file) }}" download>
                                {{ $namaFile }}</a>
                        @else
                            <p>Tidak ada file</p>
                        @endif
                    </div>

                    <div class="mb-2">
                        <label for="nama_file" class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_file" id="nama_file" class="form-control"
                            value="{{ old('nama_file', $halaman->nama_file) }}" placeholder="Contoh: Panduan.pdf">
                        <small class="text-muted">Nama ini akan tampil sebagai link download.</small>
                    </div>

                    <div class="mb-2">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" name="status">
                            <option disabled>Pilih salah satu</option>
                            <option value="publish" {{ $halaman->status == 'publish' ? 'selected' : '' }}>Publik</option>
                            <option value="arsip" {{ $halaman->status == 'arsip' ? 'selected' : '' }}>Arsip</option>
                            <option value="draft" {{ $halaman->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="published_at">Tanggal Posting <span class="text-danger">*</span></label>
                        <div class="input-group datetimepicker" id="published_at" data-target-input="nearest">
                            <input type="text" name="published_at" class="form-control datetimepicker-input"
                                data-target="#published_at" data-toggle="datetimepicker" autocomplete="off"
                                value="{{ old('published_at', $halaman->published_at) }}" />
                            <div class="input-group-append" data-target="#published_at" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Update Halaman
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
        // AJAX Update Artikel
        $('#form-halaman').on('submit', function(e) {
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
                url: '{{ route('halaman.update', $halaman->id) }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Halaman berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('halaman.index') }}';
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
