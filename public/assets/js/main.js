


/* ================= NEWS SLIDER ================= */



$(document).ready(function() {
  const slider = $('.news-slider');

  // Initialize slick slider
  slider.slick({
    centerMode: true,
    variableWidth: true,
    slidesToShow: 1,
    arrows: false,
    infinite: true,
    speed: 700,
    cssEase: 'ease-out',
    waitForAnimate: true,
    useTransform: true,
    useCSS: true,
    adaptiveHeight: false
  });

  $('.prev-btn').on('click', function () {
    slider.slick('slickPrev');
  });

  $('.next-btn').on('click', function () {
    slider.slick('slickNext');
  });

  // Use event delegation to make news cards clickable
  slider.on('click', '.news-card', function(e) {
    if (!$(e.target).is('a')) { // Ignore clicks on links
      const link = $(this).data('link');
      if (link) {
        window.location.href = link;
      }
    }
  });
});

/* ================= HERO SLIDER + SIDEBAR ================= */
$(document).ready(function(){

  $('.hero-slider').slick({
    dots: true,
    infinite: true,
    speed: 800,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    arrows: false,
    fade: false,
    cssEase: 'ease-in-out',
    swipe: true,
    touchMove: true,

    customPaging: function(slider, i) {
      return `
        <div class="custom-dot-wrapper">
          <svg class="dot-active" viewBox="0 0 24 24" fill="none" style="display:none; width:100%; height:100%;">
            <path d="M5 3L19 12L5 21V3Z" fill="#D9E378" stroke="#D9E378" stroke-width="2"/>
          </svg>
          <svg class="dot-regular" viewBox="0 0 24 24" fill="none" style="display:block; width:100%; height:100%;">
            <path d="M5 3L19 12L5 21V3Z" stroke="white" stroke-width="2"/>
          </svg>
        </div>`;
    }
  });

  function updateDots() {
    $('.slick-dots li').each(function() {
      if ($(this).hasClass('slick-active')) {
        $(this).find('.dot-active').show();
        $(this).find('.dot-regular').hide();
      } else {
        $(this).find('.dot-active').hide();
        $(this).find('.dot-regular').show();
      }
    });
  }

  updateDots();
  $('.hero-slider').on('afterChange', updateDots);

  // Sidebar
  $('#sidebarToggle').click(function() {
    $('#mainSidebar').addClass('active');
    $('body').addClass('overflow-hidden');
  });

  $('#sidebarClose').click(function() {
    $('#mainSidebar').removeClass('active');
    $('body').removeClass('overflow-hidden');
  });

});



/* ================= COUNTERS ================= */
document.addEventListener("DOMContentLoaded", function() {
  if (!window.countUp) return;

  const elements = document.querySelectorAll('[id^="counter-"]');
  
  elements.forEach(el => {
    const endVal = parseInt(el.dataset.value) || 0;
    const suffix = el.dataset.suffix || "";

    const countUp = new window.countUp.CountUp(el.id, endVal, {
      duration: 2,
      separator: ",",
      suffix: suffix
    });

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          countUp.reset();
          countUp.start();
        }
      });
    }, { threshold: 0.5 });

    observer.observe(el);
  });
});
