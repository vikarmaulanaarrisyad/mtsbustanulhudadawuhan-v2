@extends('layouts.front')

@section('content')
    <!-- Main Slider -->
    @include('frontend.sliders.index')
    <!-- Main Slider -->
    <div class="content-block">

        <!-- Recent News -->
        {{--  @include('frontend.berita.index')  --}}
        <div class="section-area section-sp2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 heading-bx left">
                        <h2 class="title-head">Berita <span>Terbaru</span></h2>
                        {{--  <p>It is a long established fact that a reader will be distracted by the readable
                            content of a page</p>  --}}
                    </div>
                </div>
                <div class="recent-news-carousel owl-carousel owl-btn-1 col-12 p-lr0">

                    @foreach ($listBerita as $b)
                        <div class="item">
                            <div class="recent-news">
                                <div class="action-box">
                                    <img src="{{ Storage::url($b->thumbnail) }}" alt="">
                                </div>
                                <div class="info-bx">
                                    <ul class="media-post">
                                        <li><a href="#"><i
                                                    class="fa fa-calendar"></i>{{ tanggal_indonesia($b->published_at, true) }}</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-user"></i>By {{ $b->user->name }}</a></li>
                                    </ul>
                                    <h5 class="post-title" style="font-size: 18px !important;"><a
                                            href="{{ route('homepage.detail', $b->slug) }}">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($b->judul), 200, '...') }}</a></h5>
                                    <p class="text-justify">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 100, '...') }}
                                    </p>
                                    <div class="post-extra">
                                        <a href="{{ route('homepage.detail', $b->slug) }}" class="btn-link">READ
                                            MORE</a>
                                        <a href="#" class="comments-bx"><i
                                                class="fa fa-comments-o"></i>{{ $b->komentars->count() }}
                                            Comment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <a href="{{ url('/berita') }}" class="btn btn-primary">Lihat Semua Berita</a>
                </div>

            </div>
        </div>
        <!-- Recent News End -->

        <!-- Testimonials -->
        @include('frontend.testimonials.index')
        <!-- Testimonials END -->
        @include('frontend.event.index')

    </div>
    <!-- contact area END -->
@endsection
