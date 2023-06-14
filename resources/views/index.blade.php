@extends('layouts.app')

@php 
 global $wp_query;
@endphp

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @php 

  $args = array (
    'post_type'           => 'post',
    'posts_per_page'      => 6,
    'id'                  => 'post-list',
    'container_type'      => 'div',
    'css_classes'         => 'post-list',
    'transition'          => 'masonry',
    'masonry_selector'    => '.post',
    'masonry_animation'   => 'slide-up',
  );

  @endphp

  @if( function_exists('alm_render') )
    {!! alm_render($args) !!}
  @else
    <div class="post-list" id="post-list" data-masonry='{ "itemSelector": ".post", "percentPosition": true }' data-page="<?= get_query_var('paged') ? get_query_var('paged') : 1; ?>" data-max="<?= $wp_query->max_num_pages; ?>" data-per-page="<?=  esc_attr( get_option( 'posts_per_page' ) ); ?>" data-post-type="posts">
      @while (have_posts()) @php the_post() @endphp
        @include('partials.content-'.get_post_type())
      @endwhile
    </div>

    <div class="mb-5">
      <button class="load-more btn btn-primary rounded">Load More</button>
    </div>
  @endif

  {{-- get_the_posts_navigation() --}}
@endsection 
