@extends('layouts.front')

@section('content')
    <!-- Main Slider -->
    @include('frontend.sliders.index')
    <!-- Main Slider -->
    <div class="content-block">

        @include('frontend.event.index')

        <!-- Testimonials -->
        @include('frontend.testimonials.index')
        <!-- Testimonials END -->

        <!-- Recent News -->
        @include('frontend.berita.index')
        <!-- Recent News End -->

    </div>
    <!-- contact area END -->
    <div class="page-banner contact-page">
        <div class="container">
            <div class="row m-lr0">
                <div class="col-lg-12 col-md-12 p-lr0 d-flex">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3448.1298878182047!2d-81.38369578541523!3d30.204840081824198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88e437ac927a996b%3A0x799695b1a2b970ab!2sNona+Blue+Modern+Tavern!5e0!3m2!1sen!2sin!4v1548177305546"
                        class="align-self-stretch d-flex" style="width:100%; width:100%; min-height: 300px;"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area END -->
@endsection
