'use strict'

import * as f from './function.js';

$(document).ready(function () {
  const popDim = $(".popDim");

  // Match Height
  $(".match_h > *").matchHeight();

  // Feather Icon
  feather.replace();

  // Arcodian Function
  f.arcodianF();

  // Score Function
  f.scoreF();

  // Popup Open
  const popOpenBtn = $('.popup-open');
  popOpenBtn.on('click', function(){
    const openPopup = $(this).attr('data-popupId');
    popDim.fadeIn(200);
    f.popupOpen(openPopup);
  });

  // Popup Close
  const popCloseBtn = $('.popup .close');
  popCloseBtn.on('click',function(){
    const closePopup = $(this).closest('.popup');
    if(!$(this).closest(".popup").hasClass('add-in-popup')){
      popDim.fadeOut(200);
    }
    f.popupClose(closePopup);
  });

  // Image Upload (Preview)
  const imgUpload = ".img-upload-input";
  $("#document").on('change', imgUpload, function(e){
    f.previewImage(e);
  });

  // Image Upload (Preview Delete)
  const imgDelete = '.img-upload-delete';
  $("#document").on('click', imgDelete, function(e) {
    f.deleteImage(e);
    e.stopPropagation();
  });

  //Main Top Banner
  const mainTopBannerTarget = '.mtb-wrap .swiper-container';
  const mainTopBannerOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    watchOverflow : true,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    direction: "vertical",
    autoHeight: true,
  };
  const mainTopBannerSlider = f.slider(mainTopBannerTarget, mainTopBannerOptions);

  //Main Top Banner Close
  const mtbCloseBtn = document.querySelector('.mtb-close-btn');
  const mtbWrap = document.querySelector('.mtb-wrap');

  mtbCloseBtn?.addEventListener('click', function() {
    mtbWrap.style.maxHeight = '0';
    mtbWrap.style.paddingTop = '0';
  });

  //Main Popup Banner
  const mainPopBannerTarget = '.mpb-wrap .swiper-container';
  const mainPopBannerOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    // autoplay: {
    //  delay: 3000,
    // },
    speed: 1000,
    centeredSlides: true,
    //direction: "vertical",
    //autoHeight : true,
    //pagination: {
    //  el: `${mainVisualTarget} .pagination`,
    //  type: 'fraction',
    //},
  };
  const mainPopBannerSlider = f.slider(mainPopBannerTarget, mainPopBannerOptions);

  //Main Visual Slide
  const mainVisualTarget = '.main_visual .swiper-container';
  const mainVisualOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
    pagination: {
      el: `${mainVisualTarget} .pagination`,
      type: 'fraction',
    },
  };
  const mainVisualSlider = f.slider(mainVisualTarget, mainVisualOptions);
  const mainVisualPlayBtn = mainVisualSlider?.el.querySelector('.playToggle');

  mainVisualPlayBtn?.addEventListener("click", function(e) {
    if(mainVisualPlayBtn.classList.contains('stop')) {
      mainVisualSlider.swiper.autoplay.start();
      mainVisualPlayBtn.classList.remove('stop');
    } else {
      mainVisualSlider.swiper.autoplay.stop();
      mainVisualPlayBtn.classList.add('stop');
    }
  });

  //Main line Banner01
  const mainLineBanner01Target = '.line-banner01 .swiper-container';
  const mainLineBanner01Options = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides: 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
  };
  const mainLineBanner01Slider = f.slider(mainLineBanner01Target, mainLineBanner01Options);

  //Main line Banner02
  const mainLineBanner02Target = '.line-banner02 .swiper-container';
  const mainLineBanner02Options = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides: 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
  };
  const mainLineBanner02Slider = f.slider(mainLineBanner02Target, mainLineBanner02Options);

  //Main line Banner03
  const mainLineBanner03Target = '.line-banner03 .swiper-container';
  const mainLineBanner03Options = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides: 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
  };
  const mainLineBanner03Slider = f.slider(mainLineBanner03Target, mainLineBanner03Options);

  //Main line Banner04
  const mainLineBanner04Target = '.line-banner04 .swiper-container';
  const mainLineBanner04Options = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides: 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
  };
  const mainLineBanner04Slider = f.slider(mainLineBanner04Target, mainLineBanner03Options);

  //Main Best Slide
  const mainBestTarget = '.main_best-slide .swiper-container';
  const mainBestOptions = {
    slidesPerView: "auto",
    freeMode: true,
    grid: {
      rows: 2,
      fill: "row",
    },
  };
  const mainBestSlider = f.slider(mainBestTarget, mainBestOptions);

  //Main Recommendation Slide
  const mainRecommTarget = '.main_recomm-slide .swiper-container';
  const mainRecommOptions = {
    slidesPerView: "auto",
    freeMode: true
  };
  const mainRecommSlider = f.slider(mainRecommTarget, mainRecommOptions);

  //Main Popular Slide
  const mainNewTarget = '.main_popular-slide .swiper-container';
  const mainNewOptions = {
    slidesPerView: "auto",
    freeMode: true,
    grid: {
      rows: 2,
      fill: "row",
    },
  };
  const mainNewSlider = f.slider(mainNewTarget, mainNewOptions);

  //Main raffle Slide
  const mainRaffTarget = '.main_raffle .swiper-container';
  const mainRaffOptions = {
    slidesPerView: "auto",
    freeMode: true,
  };
  const mainRaffSlider = f.slider(mainRaffTarget, mainRaffOptions);

  //Main Time Sale
  f.timeSale('.main_raffle .cp-timer__num');

  //Main Today Slide
  const mainTodayTarget = '.main_today-slide .swiper-container';
  const mainTodayOptions = {
    slidesPerView: "auto",
    freeMode: true,
    navigation: {
      nextEl: `${mainTodayTarget} .next`,
      prevEl: `${mainTodayTarget} .prev`,
      disabledClass: 'disabled_swiper_button'
    },
    pagination: {
      el: `${mainTodayTarget} .pagination`,
      type: 'custom',
      renderCustom: function (swiper, current, total) {
          return `<span class="current">${current}</span><span class="bar">&#124;</span><span class="total">${total}</span>`;
      }
    },
  };
  const mainTodaySlider = f.slider(mainTodayTarget, mainTodayOptions);

  //Main Time Sale
  f.timeSale('.main_today .cp-timer__num');

  //Main Time Sale
  f.timeSale('.prod-detailThumb .cp-timer__num');

  //Main Live Slide
  const mainLiveTarget = '.main_live-slide .swiper-container';
  const mainLiveOptions = {
    slidesPerView: "auto",
    freeMode: true,
    navigation: {
      nextEl: `${mainLiveTarget} .next`,
      prevEl: `${mainLiveTarget} .prev`,
    },
    pagination: {
      el: `${mainLiveTarget} .pagination`,
      type: 'custom',
      renderCustom: function (swiper, current, total) {
          return `<span class="current">${current}</span><span class="bar">&#124;</span><span class="total">${total}</span>`;
      }
    },
  };
  const mainLiveSlider = f.slider(mainLiveTarget, mainLiveOptions);

  //Product List Top Banner Slide
  const prodTopBannerTarget = '.prod-topBanner .swiper-container';
  const prodTopBannerOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    autoplay: {
      delay: 3000,
    },
    speed: 1000,
    centeredSlides: true,
    pagination: {
      el: `${prodTopBannerTarget} .pagination`,
      type: 'fraction',
    },
  };
  const prodTopBannerSlider = f.slider(prodTopBannerTarget, prodTopBannerOptions);
  const prodTopBannerPlayBtn = prodTopBannerSlider?.el.querySelector('.playToggle');

  prodTopBannerPlayBtn?.addEventListener("click", function(e) {
    if(prodTopBannerPlayBtn.classList.contains('stop')) {
      prodTopBannerSlider.swiper.autoplay.start();
      prodTopBannerPlayBtn.classList.remove('stop');
    } else {
      prodTopBannerSlider.swiper.autoplay.stop();
      prodTopBannerPlayBtn.classList.add('stop');
    }
  });

  //Product Detail Thumb Slide
  const prodDetailThumbTarget = '.prod-detailThumb .swiper-container';
  const prodDetailThumbOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    watchOverflow : true,
    // autoplay: {
    //   delay: 3000,
    // },
    speed: 1000,
    centeredSlides: true,
    pagination: {
      el: `${prodDetailThumbTarget} .pagination`,
      type: 'fraction',
    },
  };
  const prodDetailThumbSlider = f.slider(prodDetailThumbTarget, prodDetailThumbOptions);

  //used,store Detail Thumb Slide
  const flDetailThumbTarget = '.fl-detailThumb .swiper-container';
  const flDetailThumbOptions = {
    slidesPerView: 1,
    loop: true,
    loopAdditionalSlides : 1,
    watchOverflow : true,
    // autoplay: {
    //   delay: 3000,
    // },
    speed: 1000,
    centeredSlides: true,
    pagination: {
      el: `${flDetailThumbTarget} .pagination`,
    },
  };
  const flDetailThumbSlider = f.slider(flDetailThumbTarget, flDetailThumbOptions);

  //Product Detail Info
  const heightCont = $(".ht-cont");
  const heightWrap = $(".ht-wrap");
  const heightView = $(".ht-view");
  const heightWrap_h = parseInt(heightWrap.height());
  const heightView_h = parseInt(heightView.height());
  const heightContMoreBtn = heightCont.find(".more-btn");

  if(heightWrap_h < heightView_h) {
    heightContMoreBtn.show();
  } else {
    heightContMoreBtn.remove();
    heightWrap.addClass("non-hidden");
  }

  heightContMoreBtn.on('click', function(){
    heightCont.addClass("on");
  });


  //Product Detail Related Products Slide
  const prodDetailRelTarget = '.prod-detailRel-slide .swiper-container';
  const prodDetailRelOptions = {
    slidesPerView: "auto",
    freeMode: true
  };
  const prodDetailRelSlider = f.slider(prodDetailRelTarget, prodDetailRelOptions);

  //Product Discount Rate
  /*
  const prodDcEl = $(".prod-info_area");

  prodDcEl.each(function() {
    if($(this).find('.dc-price').length > 0) {
      const prodSupPrice = parseFloat($(this).find('.dc-price').text().replace(/[^0-9]/g, ''));
      const prodSalePrice = parseFloat($(this).find('.sale-price').text().replace(/[^0-9]/g, ''));
      const prodDcPerEl = $(this).find('.dc-percent');
      let dcPercentNum = f.dcPercent(prodSupPrice, prodSalePrice);

      prodDcPerEl.text(dcPercentNum+'%');
    }
  });
  */

  //Product Detail Buy Area
  const buyArea = $(".prod-buy_area");
  const buyArea_class = "prod-buy_area";
  const buyActBox = buyArea.find(".actBox");
  const buyDfBox = buyArea.find(".dfBox");
  const buyOpenBtn = buyArea.find(".buy-btn.dp");
  const buyCloseBtn = buyArea.find(".close-btn");

  buyOpenBtn.on('click', function(){
    buyArea.addClass('on');
    buyActBox.show();
    buyDfBox.hide();
    popDim.fadeIn(200);
  });

  buyCloseBtn.on('click', function(){
    buyArea.removeClass('on');
    buyActBox.hide();
    buyDfBox.show();
    popDim.fadeOut(200);
  });

  //Product Detail Share
  const prodSharePop = $("#prodShare");
  const prodShareOpenBtn = $(".prod-smInfo__head .share-btn");
  const prodShareCloseBtn = prodSharePop.find(".close-btn");

  prodShareOpenBtn.on('click', function(){
    prodSharePop.fadeIn(200).addClass("on");
    popDim.fadeIn(200);
  });

  // prodShareCloseBtn.on('click', function(){
  //   prodSharePop.removeClass('on');
  //   popDim.fadeOut(200);
  // });

  // > Copy Link
  const copyLinkBtn = $(".copyLink-btn");

  copyLinkBtn.on('click', function(){
    let url = $(this).data('url');

    f.clipCopy(url);
    prodSharePop.removeClass('on');
    popDim.fadeOut(200);
  });

  //All menu
  const depth1Btn = $('.all-ct-depth1-list > li');
  depth1Btn.on('click',function(){
    depth1Btn.removeClass('active');
    $(this).addClass('active');
    let idx = $(this).data('d1');
    $('.all-ct-right').find('.all-ct-depth2-list').hide();
    $('.all-ct-right').find(`.all-ct-depth2-list[data-d1=${idx}]`).show();
  });

  //Sort
  const cpSortList = $("#cp-sort__list");
  const cpSortBtn = $(".cp-sort__btn");
  const cpSortClose = cpSortList.find(".close-btn");

  cpSortBtn.on('click', function(){
    cpSortList.fadeIn(200).addClass("on");
    popDim.fadeIn(200);
  });

  //Review More Contents
  const reviewItem = $(".rv-item");
  const reviewConMoreBtn = $(".rv-content-wr .cont-more-btn");

  reviewItem.each(function(){
    let reviewCon = $(this).find(".content_in");
    let reviewConMore = $(this).find(".cont-more-btn");
    let reviewConMax = parseInt(reviewCon.css('max-height'));

    if(reviewCon.height() < reviewConMax) {
      reviewConMore.remove();
    }
  });

  reviewConMoreBtn.on('click', function(){
    $(this).siblings('.content').addClass('auto');
  });

  //popup dim click event
  popDim.on('click', function() {
    if(buyArea.hasClass('on')){
      buyArea.removeClass('on');
      buyActBox.hide();
      buyDfBox.show();
      popDim.fadeOut(200);
    }

    if(prodSharePop.hasClass('on')){
      prodSharePop.fadeOut(200).removeClass('on');
      popDim.fadeOut(200);
    }

    if(cpSortList.hasClass('on')){
      cpSortList.fadeOut(200).removeClass('on');
      popDim.fadeOut(200);
    }
  });

  //Raffle Time
  f.timeSale('.raffle-prod_list .cp-timer__num');
  f.timeSale('.raffleView .cp-timer__num');

  //Scroll Event
  $(window).scroll(function () {
    let scrHeight = $(document).scrollTop();

    // Register Button
    if(scrHeight > 100) {
      $('.regiBtn').addClass('sm');
    } else {
      $('.regiBtn').removeClass('sm');
    }

    // Chat Button
    if(scrHeight > 100) {
      $('.chatListBtn').addClass('sm');
    } else {
      $('.chatListBtn').removeClass('sm');
    }

    // Top Button
    if(scrHeight > 500) {
      $('.btn-moveTop').css('display','block');
    } else {
      $('.btn-moveTop').css('display','none');
    }
  }); //End window scroll
}); //End document