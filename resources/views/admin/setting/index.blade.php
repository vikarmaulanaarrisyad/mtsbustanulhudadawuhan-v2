@extends('layouts.app')

@section('title', 'Pengaturan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-12 col-md-12">
            <form action="{{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <x-card>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nomorwa">No. Wa</label>
                                <input type="text" class="form-control @error('nomorwa') is-invalid @enderror"
                                    name="nomorwa" id="nomorwa" value="{{ old('nomorwa') ?? $setting->nomorwa }}">
                                @error('nomorwa')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama_yayasan">Nama Yayasan</label>
                                <input type="text" class="form-control @error('nama_yayasan') is-invalid @enderror"
                                    name="nama_yayasan" id="nama_yayasan"
                                    value="{{ old('nama_yayasan') ?? $setting->nama_yayasan }}">
                                @error('nama_yayasan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama_madrasah">Nama Madrasah</label>
                                <input type="text" class="form-control @error('nama_madrasah') is-invalid @enderror"
                                    name="nama_madrasah" id="nama_madrasah"
                                    value="{{ old('nama_madrasah') ?? $setting->nama_madrasah }}">
                                @error('nama_madrasah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Singkat</label>
                                {{--  <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                        name="deskripsi" id="deskripsi" value="{{ old('deskripsi') ?? $setting->deskripsi }}">  --}}
                                <textarea class="form-control summernote @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                    rows="5">{{ old('deskripsi') ?? $setting->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tentang">Tentang Madrasah</label>
                                <textarea class="form-control summernote @error('tentang') is-invalid @enderror" name="tentang" id="tentang"
                                    rows="5">{{ old('tentang') ?? $setting->tentang }}</textarea>
                                @error('tentang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-3">
                            <div class="form-group text-center">
                                <label for="logo">Logo</label><br>
                                @if ($setting->logo)
                                    <img src="{{ asset('storage/' . $setting->logo) }}" class="img-thumbnail mb-2"
                                        style="max-height: 100px;">
                                @endif
                                <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                    name="logo" id="logo">
                                @error('logo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group text-center">
                                <label for="logo_login">Logo Login</label><br>
                                @if ($setting->logo_login)
                                    <img src="{{ asset('storage/' . $setting->logo_login) }}" class="img-thumbnail mb-2"
                                        style="max-height: 100px;">
                                @endif
                                <input type="file" class="form-control @error('logo_login') is-invalid @enderror"
                                    name="logo_login" id="logo_login">
                                @error('logo_login')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group text-center">
                                <label for="favicon">Favicon</label><br>
                                @if ($setting->favicon)
                                    <img src="{{ asset('storage/' . $setting->favicon) }}" class="img-thumbnail mb-2"
                                        style="max-height: 100px;">
                                @endif
                                <input type="file" class="form-control @error('favicon') is-invalid @enderror"
                                    name="favicon" id="favicon">
                                @error('favicon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group text-center">
                                <label for="background_image">Background</label><br>
                                @if ($setting->background_image)
                                    <img src="{{ asset('storage/' . $setting->background_image) }}"
                                        class="img-thumbnail mb-2" style="max-height: 100px;">
                                @endif
                                <input type="file" class="form-control @error('background_image') is-invalid @enderror"
                                    name="background_image" id="background">
                                @error('background_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer">
                        <div class="text-end">
                            <button type="reset" class="btn btn-dark">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </x-slot>

                </x-card>
            </form>
        </div>
    </div>
@endsection
