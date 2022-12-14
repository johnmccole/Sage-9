{{-- Off Canvas Navigation --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

    <form class="d-flex mt-3" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</div>

@if( class_exists( 'WooCommerce' ) )
<a class="cart-contents basket" href="{!! wc_get_cart_url() !!}" title="{!! _e( 'View your shopping cart' ) !!}">
  <span class="hidden-xs">{!! sprintf ( _n( '%d</span>' . ' <span class="item-count"> item</span>', '%d</span>' . ' <span class="item-count"> items</span>', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ) !!} - </span>
  <span class="basket-total">{!! WC()->cart->get_cart_total() !!}</span>
</a>
@endif

{{-- Main header --}}
<header class="banner {!! $header_style !!}">
  <div class="container d-flex align-items-center justify-content-between">
    <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <nav class="nav-primary d-flex align-items-center justify-content-end">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
      <button class="navbar-toggler hamburger {!! $hamburger_style !!} {!! $hamburger_breakpoint !!}" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
    </nav>
  </div>
</header>
