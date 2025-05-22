@extends('layouts.front')

@section('content')
    <div class="page-content bg-white">
        <!-- inner page banner -->
        <div class="page-banner ovbl-dark pt-4"
            style="background-image:url({{ asset('template') }}/assets/images/banner/banner2.jpg);">
            <div class="container">
                <div class="page-banner-entry">
                    {{--  <h1 class="text-white">Blog Details</h1>  --}}
                </div>
            </div>
        </div>
        <!-- Breadcrumb row -->
        <div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li>{{ $halaman->judul }}</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb row END -->
        <div class="content-block">
            <div class="section-area section-sp1">
                <div class="container">
                    <div class="row">
                        <!-- Left part start -->
                        <div class="col-lg-11 col-xl-11">
                            <!-- blog start -->
                            <div class="recent-news blog-lg">
                                <div class="info-bx">
                                    <h5 class="post-title"><a href="#">{{ $halaman->judul }}</a></h5>
                                    <p>
                                        {!! $halaman->isi !!}
                                    </p>
                                    <div class="ttr-divider bg-gray"><i class="icon-dot c-square"></i></div>
                                </div>
                            </div>
                            <!-- blog END -->
                        </div>
                        <!-- Left part END -->
                        <!-- Side bar start -->
                        <div class="col-lg-4 col-xl-4" style="display: none;">
                            <aside class="side-bar sticky-top">
                                <div class="widget recent-posts-entry">
                                    <h6 class="widget-title">Unduhan</h6>
                                    <div class="widget-post-bx">
                                        <div class="widget-post clearfix">
                                            {{--  <div class="ttr-post-info">
                                                <div class="ttr-post-header">
                                                    <h6 class="post-title"><a
                                                            href="{{ route('homepage.halaman.detail', $r->slug) }}">{{ $r->judul }}</a>
                                                    </h6>
                                                </div>
                                                <ul class="media-post">
                                                    <li><a href="#"><i
                                                                class="fa fa-calendar"></i>{{ tanggal_indonesia($r->published_at, true) }}</a>
                                                    </li>
                                                    <li><a href="#"><i
                                                                class="fa fa-comments-o"></i>{{ $r->komentars->count() }}
                                                            Komentar</a>
                                                    </li>
                                                </ul>
                                            </div>  --}}
                                        </div>

                                    </div>
                                </div>

                            </aside>
                        </div>
                        <!-- Side bar END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
