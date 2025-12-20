


/* ================= NEWS SLIDER ================= */
$(function () {
  const slider = $('.news-slider');

  slider.slick({
    centerMode: true,
    variableWidth: true,
    slidesToShow: 1,
    arrows: false,
    infinite: true,
    speed: 550
  });

  $('.prev-btn').on('click', function () {
    slider.slick('slickPrev');
  });

  $('.next-btn').on('click', function () {
    slider.slick('slickNext');
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

  const counters = [
    { id: "counter-buildings", endVal: 9 },
    { id: "counter-students", endVal: 15 },
    { id: "counter-activities", endVal: 100, suffix: "+" }
  ];

  counters.forEach(counter => {
    const el = document.getElementById(counter.id);
    if (!el) return; 

    const countUp = new window.countUp.CountUp(el.id, counter.endVal, {
      duration: 2,
      separator: ",",
      suffix: counter.suffix || ""
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
