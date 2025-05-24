@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalKategori }}</h3>
                    <p>Kategori</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pricetags"></i> <!-- Cocok untuk Kategori -->
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalBerita }}</h3>
                    <p>Artikel</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i> <!-- Cocok untuk Artikel -->
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalMenu }}</h3>
                    <p>Menu</p>
                </div>
                <div class="icon">
                    <i class="ion ion-navicon-round"></i> <!-- Cocok untuk Menu navigasi -->
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalHalaman }}</h3>
                    <p>Halaman</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-paper"></i> <!-- Cocok untuk Halaman -->
                </div>
            </div>
        </div>
    </div>
@endsection
