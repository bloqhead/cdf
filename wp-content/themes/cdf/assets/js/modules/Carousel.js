(function() {
  jQuery(document).ready(function($) {
    var $dreams_max_slides, $partners_max_slides, $vp, $vp_width;
    $vp = $(window);
    $vp_width = $vp.width();
    $partners_max_slides;
    $dreams_max_slides;
    if ($vp_width <= 768) {
      $partners_max_slides = 2;
      $dreams_max_slides = 2;
    } else {
      $partners_max_slides = 5;
      $dreams_max_slides = 5;
    }
    $(".carousel--partners").bxSlider({
      auto: true,
      speed: 800,
      pause: 5000,
      infiniteLoop: true,
      easing: "ease-in-out",
      pager: false,
      controls: false,
      minSlides: $partners_max_slides,
      maxSlides: $partners_max_slides,
      moveSlides: $partners_max_slides,
      slideWidth: 225,
      slideMargin: 20
    });
    $(".dreams__carousel-wrapper .dreams__carousel").bxSlider({
      auto: false,
      speed: 800,
      infiniteLoop: false,
      easing: "ease-in-out",
      pager: true,
      pagerCustom: ".dreams__pager",
      controls: false
    });
    return $(".dreams__pager-wrapper .dreams__pager").bxSlider({
      auto: false,
      speed: 800,
      infiniteLoop: false,
      easing: "ease-in-out",
      pager: false,
      controls: true,
      minSlides: $dreams_max_slides,
      maxSlides: $dreams_max_slides,
      moveSlides: $dreams_max_slides,
      slideWidth: 156,
      slideMargin: 5
    });
  });

}).call(this);
