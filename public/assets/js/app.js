document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".faq-item").forEach((item) => {
    item.addEventListener("click", function () {
      this.classList.toggle("active");

      let answer = this.querySelector(".faq-answer");
      if (this.classList.contains("active")) {
        answer.style.maxHeight = answer.scrollHeight + "px";
      } else {
        answer.style.maxHeight = null;
      }
    });
  });
});

// **********************//
var swiper = new Swiper(".custom-swiper", {
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  speed: 1200,
});
// **********************//
var swiper = new Swiper(".hero-slider", {
  loop: false,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  effect: "fade",
  fadeEffect: {
    crossFade: true,
  },
  speed: 1000,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
// **********************//
var companySwiper = new Swiper(".companySwiper", {
  slidesPerView: 6,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".companySwiper .swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    1024: {
      slidesPerView: 6,
    },
    768: {
      slidesPerView: 4,
    },
    480: {
      slidesPerView: 2,
    },
    100: {
      slidesPerView: 1,
    },
  },
});
// **********************//
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    1024: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 2,
    },
    480: {
      slidesPerView: 1,
    },
    100: {
      slidesPerView: 1,
    },
  },
});
