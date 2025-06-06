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

<div class="row">
    <!-- Pesan Masuk -->
    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-envelope"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pesan Masuk</span>
                <span class="info-box-number">5</span>
            </div>
        </div>
    </div>

    <!-- Komentar -->
    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-comments"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Komentar</span>
                <span class="info-box-number">12</span>
            </div>
        </div>
    </div>

    <!-- Event -->
    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Event</span>
                <span class="info-box-number">{{ $totalEvent }}</span>
            </div>
        </div>
    </div>

    <!-- Testimoni -->
    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Testimoni</span>
                <span class="info-box-number">8</span>
            </div>
        </div>
    </div>
</div>
