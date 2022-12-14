{{--
  Title: Video Background
  Description: Video Background with optional overlays
  Category: formatting
  Icon: video-alt3
  Keywords: video
  Mode: preview
  Align: center
  SupportsAnchor: true
  SupportsAlign: wide center full
  SupportsInnerBlocks: true
--}}

@php

  $fh = get_field('full_height');

@endphp

<div data-{{ $block['id'] }} class="{{ $block['classes'] }} custom-block d-flex align-items-center @if($fh) has-full-height @endif my-0">
    <div class="container">
      <InnerBlocks />
    </div>
</div>
