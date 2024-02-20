'use stict'

/**
 * Swiper Slider
 * @param {string} t : 타겟(id or class)
 * @param {*} opt : swiper options
 * @returns {el, swiper} 선택자(타겟), 생성된 swiper
 */
export const slider = function(t, opt) {
  if(document.querySelectorAll(t).length > 0){
    const options = opt;
    const swiper = new Swiper(t, options);
    const el = document.querySelector(t);
    const swiperControl = el?.querySelector(".swiper-control");

    if (swiperControl) {
      if(swiper.slides.length <= 1) {
        el.querySelector(".swiper-control").classList.remove('on');
      } else {
        el.querySelector(".swiper-control").classList.add('on');
      }
    }

    return {
      el: el,
      swiper: swiper
    }
  }
}

/**
 * 가로 스크롤 메뉴
 * @param {string} t : 타겟(id or class)
 * @param {string} a : 활성할 메뉴(data-id)
 * @returns {el, swiper} 선택자(타겟), 생성된 swiper
 */
export const hrizonMenu = function(t, a) {
  if(document.querySelectorAll(t).length > 0){
    const options = {
      slidesPerView: "auto",
      freeMode: true
    }
    const swiper = new Swiper(t, options);
    const el = document.querySelector(t);
    const activeMenuEl = el.querySelector(`[data-id="${a}"]`);
    let activeMenuIndex = "";
    
    if(a) {
      activeMenuIndex = Array.from(activeMenuEl?.parentNode.children).indexOf(activeMenuEl);
    } else {
      activeMenuIndex = 0;
    }

    swiper.slideTo(activeMenuIndex);
    swiper.slides[activeMenuIndex].classList.add('active');

    return {
      el: el,
      swiper: swiper
    }
  }
}

/**
 * 타이머 남은 시간계산
 * @param {string} deadline // d-day (yyyy-mm-dd hh:mm:ss)
 * @returns {string} d-day까지 남은 시간 (n일 시:분:초)
 */
const timer = function(deadline) {
  let result = "";
  let now = new Date().getTime();
  let diff = Math.max(0, new Date(deadline).getTime() - now);
  let days = Math.max(0, Math.floor(diff / (1000 * 60 * 60 * 24)));
  let hours = Math.max(0, Math.floor((diff / (1000 * 60 * 60)) % 24));
  let minutes = Math.max(0, Math.floor((diff / (1000 * 60)) % 60));
  let seconds = Math.max(0, Math.floor((diff / 1000) % 60));

  if (diff === 0) {
    result = "";
  } else {
    days = days == 0 ? '' : days+'일';
    hours = hours < 10 ? '0'+hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds < 10 ? '0'+seconds : seconds;

    result = `${days} ${hours}:${minutes}:${seconds}`;
  }

  return result;
}

/**
 * 타이머(남은시간) 랜더링
 * @param {string} t : 랜더링 타겟 요소(id or class)
 */
export const timeSale = function(t) {
  if(document.querySelectorAll(t).length > 0){
    const elList = document.querySelectorAll(t);
    let newTime = "";


    elList.forEach(function(el) {
      let deadline = el.getAttribute("data-deadline");

      setInterval(() => {
        newTime = timer(deadline);

        if(newTime) {
          el.innerHTML = newTime;
        }
      }, 1000);
    })
  }
}

/**
 * 할인율 계산 : ((공급가 - 판매가) / 공급가) * 100
 * @param {number} supPrice : 공급가
 * @param {number} salePrice : 판매가
 * @returns {number} 할인율
 */
export const dcPercent = (supPrice, salePrice) => {
  const percent = Math.round(((supPrice - salePrice) / supPrice) * 100);

  return percent;
}

//아코디언 메뉴
export const arcodianF = () => {
  let arcoBtn = $('.arcodianBtn');
  arcoBtn.on('click',function(){
    const $this = $(this);
    $this.toggleClass('active');
    if($this.hasClass('active')){
      $this.next().slideDown();
    }else{
      $this.next().slideUp();
    }
  });
  
  let arcoCheck = $('.arcodianBtn .frm-choice');
  if(arcoCheck) {
    arcoCheck.click(function(e){ 
        event.stopPropagation();   
    });
  }
}