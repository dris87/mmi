@extends('web.layouts.app')
@section('title')
    {{ __('messages.post.blog') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/front-blogs.css') }}">
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web_front/css/header-span.css') }}">
@endsection
@section('content')
    {{--    <section class="page-header blog-page-header">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-md-12">--}}
    {{--                    <h2>{{ __('messages.post.blog') }}</h2>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    {{--    <section class="blog-listing ptb80 custom-ptb-60-30" id="version1">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-md-8 col-xs-12 blog-posts-wrapper">--}}
    {{--                    @forelse($blogs as $blog)--}}
    {{--                        <article class="col-md-12 blog-post">--}}
    {{--                            <div class="col-md-4 blog-thumbnail">--}}
    {{--                                <a href="{{ route('front.posts.details',$blog->id) }}" class="hover-link">--}}
    {{--                                    <img src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url :asset('assets/img/main-logo.png')  }}"--}}
    {{--                                            class="img-responsive" alt="Blog Image">--}}
    {{--                                </a>--}}
    {{--                                <div class="date">--}}
    {{--                                    <span class="day">{{ $blog->created_at->format('d') }}</span>--}}
    {{--                                    <span class="publish-month">{{ $blog->created_at->format('M') }}</span>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-offset-4 blog-desc">--}}
    {{--                                <h5>--}}
    {{--                                    <a href="{{ route('front.posts.details',$blog->id) }}" class="hover-color">{{ html_entity_decode($blog->title) }}</a>--}}
    {{--                                </h5>--}}
    {{--                                <div class="post-detail pt10 pb20">--}}
    {{--                                    <span><i class="fa fa-user"></i>{{ $blog->user->full_name }}</span>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-8 post-detail-category-badge web-post-box blog-category-sm mt-1">--}}
    {{--                                @foreach($blog->postAssignCategories as $counter => $category)--}}
    {{--                                    @if($counter < 1)--}}
    {{--                                        <span class="font-size-13px post-badge badge-pill {{ $counter }} badge-primary">{{html_entity_decode($category->name)}}</span>--}}
    {{--                                    @elseif($counter == (count($blog->postAssignCategories )) - 1)--}}
    {{--                                        <label class="badge badge-pill badge-secondary font-size-13px">{{ "+" . $counter ." "."more"}}</label>--}}
    {{--                                    @endif--}}
    {{--                                @endforeach--}}
    {{--                            </div>--}}

    {{--                            <div class="col-md-8 blog-desc position-relative h110 blog-desc-sm">--}}

    {{--                               <div class="web-blog-description">--}}
    {{--                                       {!! !empty($blog->description) ? $blog->description :__('messages.common.n/a') !!}--}}
    {{--                               </div>--}}
    {{--                                <a href="{{ route('front.posts.details',$blog->id) }}"--}}
    {{--                                   class="btn btn-purple btn-effect mt10 position-absolute bottom-0">{{ __('web.post_menu.read_more') }}</a>--}}
    {{--                            </div>--}}
    {{--                        </article>--}}

    {{--                    @empty--}}
    {{--                        <h6><span class="no-blog-available">--}}
    {{--                               {{ __('messages.post.no_posts_available') }}--}}
    {{--                            </span></h6>--}}
    {{--                    @endforelse--}}
    {{--                </div>--}}
    {{--                @include('web.blogs.blog-sidebar')--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        @if(count($blogs) > 0)--}}
    {{--            <div class="col-12 custom-pagination">--}}
    {{--                {{ $blogs->withQueryString()->links() }}--}}
    {{--            </div>--}}
    {{--        @endif--}}
    {{--    </section>--}}

    <!--New Blog theme -->

    <!--Page Title-->
    <!-- Preloader -->
    <section class="page-title ptb80">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{ __('messages.post.blog') }}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('front.home') }}">{{ __('web.home') }}</a></li>
                    <li>{{ __('messages.post.blog') }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Sidebar Page Container -->
    <section class="blog-listing ptb80 custom-ptb-60-30" id="version1">
        <div class="sidebar-page-container">
            <div class="auto-container">
                <div class="row">
                    <!--Content Side-->
                    <div class="content-side col-lg-8 col-md-12 col-sm-12">
                        <div class="blog-grid">
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <!-- News Block -->
                                    <div class="news-block-two">
                                        <div class="inner-box">
                                            <div class="image-box">
                                                <figure class="image ml-3">
                                                    <a href="{{ route('front.posts.details',$blog->id) }}">
                                                        <img src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url :asset('assets/img/main-logo.png')  }}"
                                                             alt="Blog Image">
                                                    </a>
                                                </figure>
                                            </div>
                                            <div class="content-box">
                                                <ul class="post-meta">
                                                    <li>
                                                        <a href="#">{{ \Carbon\Carbon::parse($blog->created_at)->isoFormat('MMM Do YYYY')}}</a>
                                                    </li>
                                                    <li><a href="#">{{ isset($comments) ? count($comments) : 0 }}
                                                            {{ __('web.web_blog.comments') }}</a></li>
                                                </ul>
                                                <h3>
                                                    <a href="{{ route('front.posts.details',$blog->id) }}">{{ html_entity_decode($blog->title) }}</a>
                                                </h3>
                                                <p class="text">{!! !empty(strip_tags($blog->description)) ? Str::limit(strip_tags($blog->description),70,'...') :__('messages.common.n/a') !!}</p>
                                                <a href="{{ route('front.posts.details',$blog->id) }}"
                                                   class="read-more">{{ __('web.post_menu.read_more') }} <i
                                                            class="fa fa-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h6><span class="no-blog-available">
                               {{ __('messages.post.no_posts_available') }}
                            </span></h6>
                        @endif
                        <!-- Pagination -->

                            <nav class="ls-pagination">
                                {{ $blogs->withQueryString()->links() }}
                            </nav>
                        </div>
                    </div>

                    <!--Sidebar Side-->
                    @include('web.blogs.blog-sidebar')
                </div>
            </div>
        </div>
    </section>
    <!-- End Sidebar Container -->
@endsection
