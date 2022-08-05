<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
  <meta name="facebook-domain-verification" content="bwnuzheewywvrkyj3abyqt32xgtncl" />
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-PXJ8MMZ');
  </script>
  <!-- End Google Tag Manager -->

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154793366-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-154793366-1');
  </script>

  <!-- Facebook Pixel Code -->
  <script>
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2365050086940455');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2365050086940455&ev=PageView&noscript=1" /></noscript>
  <!-- End Facebook Pixel Code -->

  <!-- Twitter universal website tag code -->
  <script>
    ! function(e, t, n, s, u, a) {
      e.twq || (s = e.twq = function() {
          s.exe ? s.exe.apply(s, arguments) : s.queue.push(arguments);
        }, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src = '//static.ads-twitter.com/uwt.js',
        a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a))
    }(window, document, 'script');
    // Insert Twitter Pixel ID and Standard Event data below
    twq('init', 'o31b8');
    twq('track', 'PageView');
  </script>
  <!-- End Twitter universal website tag code -->
</head>

<body <?php body_class(); ?>>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXJ8MMZ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div id="page" class="site">

    <header id="header">
      <div class="wrap">
        <?php
        $class = (theme_get_custom_logo()) ? 'image' : 'text';
        echo '<h1 class="site-title ' . $class . '">';
        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
        if (theme_get_custom_logo()) echo '<img src="' . theme_get_custom_logo() . '" class="site-logo" alt="' . htmlspecialchars(get_bloginfo('name')) . '" />';
        echo '<strong>' . get_bloginfo('name') . '</strong>';
        echo '</a>';
        echo '</h1>';
        ?>
        <nav id="site-navigation" class="main-navigation">
          <button class="menu-toggle openmenu" aria-controls="primary-menu" aria-expanded="false"><span>Menú</span></button>
          <?php
          if ((basename(get_permalink()) != 'checkout') && (basename(get_permalink()) != 'contratar')) {
            wp_nav_menu(array(
              'theme_location' => 'menu-1',
              'menu_id' => 'primary-menu',
              'container_id' => 'primary-menu-container'
            ));
          } else {
            // Mostrar título del checkout
          }
          ?>
        </nav>
      </div>
    </header>

    <main id="content" class="site-content">
