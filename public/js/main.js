(function ($) {
  "use strict";

  new WOW().init();

  //navbar cart
  $(".cart_link > a").on("click", function () {
    getCardItems();
    $(".mini_cart").addClass("active");
  });

  $(".mini_cart_close > a").on("click", function () {
    $(".mini_cart").removeClass("active");
  });



    //navbar cart
    $(".cart_link_hem > a").on("click", function () {
      $(".mini_cart_hem").addClass("active");
    });
  
    $(".mini_cart_close_hem > a").on("click", function () {
      $(".mini_cart_hem").removeClass("active");
    });

  //sticky navbar
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 100) {
      $(".sticky-header").removeClass("sticky");
    } else {
      $(".sticky-header").addClass("sticky");
    }
  });

  // background image
  function dataBackgroundImage() {
    $("[data-bgimg]").each(function () {
      var bgImgUrl = $(this).data("bgimg");
      $(this).css({
        "background-image": "url(" + bgImgUrl + ")", // concatenation
      });
    });
  }

  $(window).on("load", function () {
    dataBackgroundImage();
  });

  //for carousel slider of the slider section
  $(".slider_area").owlCarousel({
    animateOut: "fadeOut",
    autoplay: true,
    loop: true,
    nav: false,
    autoplayTimeout: 6000,
    items: 1,
    dots: true,
  });

  //product column responsive
  $(".product_column3").slick({
    centerMode: true,
    centerPadding: "0",
    slidesToShow: 5,
    arrows: true,
    rows: 2,
    prevArrow:
      '<button class="prev_arrow"><i class="ion-chevron-left"></i></button>',
    nextArrow:
      '<button class="next_arrow"><i class="ion-chevron-right"></i></button>',
    responsive: [
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        },
      },
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4,
        },
      },
    ],
  });

  //for tooltip
  $('[data-toggle="tooltip"]').tooltip();

  //tooltip active
  $(".action_links ul li a, .quick_button a").tooltip({
    animated: "fade",
    placement: "top",
    container: "body",
  });

  // //product row activation responsive
  // $(".product_row1").slick({
  //   centerMode: true,
  //   centerPadding: "0",
  //   slidesToShow: 5,
  //   arrows: true,
  //   prevArrow:
  //     '<button class="prev_arrow"><i class="ion-chevron-left"></i></button>',
  //   nextArrow:
  //     '<button class="next_arrow"><i class="ion-chevron-right"></i></button>',
  //   responsive: [
  //     {
  //       breakpoint: 400,
  //       settings: {
  //         slidesToShow: 1,
  //         slidesToScroll: 1,
  //       },
  //     },
  //     {
  //       breakpoint: 768,
  //       settings: {
  //         slidesToShow: 2,
  //         slidesToScroll: 2,
  //       },
  //     },
  //     {
  //       breakpoint: 992,
  //       settings: {
  //         slidesToShow: 3,
  //         slidesToScroll: 3,
  //       },
  //     },
  //     {
  //       breakpoint: 1200,
  //       settings: {
  //         slidesToShow: 4,
  //         slidesToScroll: 4,
  //       },
  //     },
  //   ],
  // });
  


  // blog section
  $(".blog_column3").owlCarousel({
    autoplay: true,
    loop: true,
    nav: true,
    autoplayTimeout: 5000,
    items: 3,
    dots: false,
    margin: 30,
    navText: [
      '<i class="ion-chevron-left m-0"></i>',
      '<i class="ion-chevron-right m-0"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
    },
  });

  //navactive responsive
  $(".product_navactive").owlCarousel({
    autoplay: false,
    loop: true,
    nav: true,
    items: 4,
    dots: false,
    navText: [
      '<i class="ion-chevron-left arrow-left"></i>',
      '<i class="ion-chevron-right arrow-right"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      250: {
        items: 2,
      },
      480: {
        items: 3,
      },
      768: {
        items: 4,
      },
    },
  });

  $(".modal").on("shown.bs.modal", function (e) {
    $(".product_navactive").resize();
  });

  $(".product_navactive a").on("click", function (e) {
    e.preventDefault();
    var $href = $(this).attr("href");
    $(".product_navactive a").removeClass("active");
    $(this).addClass("active");
    $(".product-details-large .tab-pane").removeClass("active show");
    $(".product-details-large " + $href).addClass("active show");
  });
  getCardItems();
  
})(jQuery);

function getCardItems() {
  $.ajax({
      type: "GET",
      url: "/get-cart-items",
      success: function(response) {
          // Assuming 'response' contains an array of cart items
          let cartItemsContainer = $('#card-items');
          cartItemsContainer.empty(); // Clear any existing cart items
          console.log(response);
          response.cartItems.forEach(function(item) {

                  let = item.product.images[0].image_path;
              let cartItemHtml = `
                <div class="cart_item">
                  <div class="cart_img">
                    <a href="/product-details/${item.product.slug}"><img src="/${item.product.images[0].image_path}" alt="${item.product.title}"></a>
                  </div>
                  <div class="cart_info">
                    <a href="/product-details/${item.product.slug}">${item.product.title}</a>
                    <span class="quantity">Qty : ${item.quantity}</span>
                    <span class="price_cart"> ${formatPriceNepali(item.total_price)}</span>
                  </div>
                  <div class="cart_remove">
                    <a href="/cart/${item.id}"><i class="ion-android-close"></i></a>
                  </div>
                </div>
              `;
              // Append the cart item to the container
              cartItemsContainer.append(cartItemHtml);
          });

          //total-amount
          $('#total-amount').text(formatPriceNepali(response.totalAmount));
          // card-total 
          $('#cart-total').text(formatPriceNepali(response.totalAmount));
          // card aquantity
          $('#cart-quantity').text(response.cartItems.length);
            
      },
  });
}

function formatPriceNepali(price) {
  return new Intl.NumberFormat('ne-NP', {
      style: 'currency',
      currency: 'NPR',
      minimumFractionDigits: 0
  }).format(price);
}