@extends('layouts.front')

@section('content')
    <!-- Inner Content Box ==== -->
    <div class="page-content bg-white">
        <!-- Page Heading Box ==== -->
        <div class="page-banner ovbl-dark" style="background-image:url({{ Storage::url($setting->background_image) }});">
            <div class="container">
                <div class="page-banner-entry">
                    {{--  <h1 class="text-white">Blog Classic</h1>  --}}
                </div>
            </div>
        </div>
        <div class="breadcrumb-row">
            <div class="container">
                <ul class="list-inline">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li>Berita Madrasah</li>
                </ul>
            </div>
        </div>
        <!-- Page Heading Box END ==== -->
        <!-- Page Content Box ==== -->
        <div class="content-block">
            <!-- Blog Grid ==== -->
            <div class="section-area section-sp1">
                <div class="container">
                    <div class="ttr-blog-grid-3 row" id="masonry">
                        @foreach ($listBerita as $b)
                            <div class="post action-card col-lg-4 col-md-6 col-sm-12 col-xs-12 m-b40">
                                <div class="recent-news">
                                    <div class="action-box">
                                        <img src="{{ Storage::url($b->thumbnail) }}" alt="">
                                    </div>
                                    <div class="info-bx">
                                        <ul class="media-post">
                                            <li>
                                                <a href="#"><i class="fa fa-calendar"></i>
                                                    {{ tanggal_indonesia($b->published_at, true) }}</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-user"></i> By {{ $b->user->name }}</a>
                                            </li>
                                        </ul>
                                        <h5 class="post-title" style="font-size: 18px !important;">
                                            <a href="{{ route('homepage.detail', $b->slug) }}">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($b->judul), 200, '...') }}
                                            </a>
                                        </h5>
                                        <p class="text-justify">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 100, '...') }}
                                        </p>
                                        <div class="post-extra">
                                            <a href="{{ route('homepage.detail', $b->slug) }}" class="btn-link">READ
                                                MORE</a>
                                            <a href="#" class="comments-bx">
                                                <i class="fa fa-comments-o"></i> {{ $b->komentars->count() }} Komentar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination ==== -->
                    @if ($listBerita->hasPages())
                        <div class="pagination-bx rounded-sm gray clearfix">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($listBerita->onFirstPage())
                                    <li class="previous disabled"><span><i class="ti-arrow-left"></i> Prev</span></li>
                                @else
                                    <li class="previous"><a href="{{ $listBerita->previousPageUrl() }}"><i
                                                class="ti-arrow-left"></i> Prev</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($listBerita->getUrlRange(1, $listBerita->lastPage()) as $page => $url)
                                    @if ($page == $listBerita->currentPage())
                                        <li class="active"><a href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($listBerita->hasMorePages())
                                    <li class="next"><a href="{{ $listBerita->nextPageUrl() }}">Next <i
                                                class="ti-arrow-right"></i></a></li>
                                @else
                                    <li class="next disabled"><span>Next <i class="ti-arrow-right"></i></span></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <!-- Pagination END ==== -->
                </div>
            </div>
            <!-- Blog Grid END ==== -->
        </div>
        <!-- Page Content Box END ==== -->
    </div>
@endsection
