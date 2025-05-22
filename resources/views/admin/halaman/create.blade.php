@extends('layouts.app')

@section('title', 'Form Artikel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('halaman.index') }}">Daftar Artikel</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <form id="form-halaman" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <x-card>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-edit"></i> Form Halaman</span>
                            <a href="{{ route('halaman.index') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </x-slot>

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Halaman</label>
                        <input id="judul" name="judul" type="text" class="form-control"
                            placeholder="Masukkan judul halaman" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">Isi Halaman</label>
                        <textarea id="summernote" name="isi" class="form-control summernote" rows="20" cols="20"
                            placeholder="Tulis isi halaman di sini..."></textarea>
                    </div>
                </x-card>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <x-card>
                    <x-slot name="header">
                        <strong><i class="fas fa-list"></i> Menu</strong>
                    </x-slot>

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="menu_id">Menu <span class="text-danger">*</span></label>
                            <select id="menu_id" class="form-control select2" name="menu_id" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="menu_parent_id">Sub Menu <span class="text-danger">*</span></label>
                            <select id="menu_parent_id" class="form-control select2" name="menu_parent_id"
                                style="width: 100%;">
                                <option value="">Pilih Sub Menu</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <img id="preview-thumbnail" src="#" class="img-thumbnail d-none mt-2"
                            style="max-height: 200px;" alt="Preview thumbnail">
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
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Simpan Halaman Baru
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
            // Load data menu_id via AJAX
            $.ajax({
                url: '{{ route('getAll.menu') }}',
                method: 'GET',
                success: function(response) {
                    $('#menu_id').append('<option value="">Pilih Menu</option>');
                    $.each(response.data, function(index, item) {
                        $('#menu_id').append(
                            `<option value="${item.id}">${item.menu_title}</option>`
                        );
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Menu',
                        text: 'Terjadi kesalahan saat mengambil data menu.'
                    });
                }
            });

            // Disable menu_parent_id saat awal
            $('#menu_parent_id').prop('disabled', true);

            // Saat menu_id dipilih, ambil submenu
            $('#menu_id').on('change', function() {
                let menuId = $(this).val();
                $('#menu_parent_id').prop('disabled', true).html('<option value="">Memuat...</option>');

                if (menuId) {
                    Swal.fire({
                        title: 'Mengambil Sub Menu...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '{{ route('getAll.submenu') }}',
                        method: 'GET',
                        data: {
                            menu_id: menuId
                        },
                        success: function(response) {
                            $('#menu_parent_id').empty();

                            if (response.data.length === 0) {
                                $('#menu_parent_id').append(
                                    '<option value="">Tidak ada sub menu</option>');
                                $('#menu_parent_id').prop('disabled', true);
                            } else {
                                $('#menu_parent_id').append(
                                    '<option value="">Pilih Sub Menu</option>');
                                $.each(response.data, function(key, submenu) {
                                    $('#menu_parent_id').append(
                                        `<option value="${submenu.id}">${submenu.menu_title}</option>`
                                    );
                                });
                                $('#menu_parent_id').prop('disabled', false);
                            }

                            Swal.close();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat',
                                text: 'Tidak dapat mengambil sub menu. Silakan coba lagi.'
                            });
                            $('#menu_parent_id').prop('disabled', true).html(
                                '<option value="">Pilih Sub Menu</option>');
                        }
                    });
                } else {
                    $('#menu_parent_id').html('<option value="">Pilih Sub Menu</option>').prop('disabled',
                        true);
                }
            });


            // Simpan artikel via AJAX
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
                    url: '{{ route('halaman.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
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
        });
    </script>
@endpush
