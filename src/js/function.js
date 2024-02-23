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
    // swiper.slides[activeMenuIndex].classList.add('active');
    swiper.slides.forEach((slide, index) => {
      if (index === activeMenuIndex) {
          slide.classList.add('active');
      } else {
          slide.classList.remove('active');
      }
    });

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

//팝업 열기
export const popupOpen = (id) => {
  $('#' + id).fadeIn(200).addClass("on");
}

//팝업 닫기
export const popupClose = (t) => {
  t.fadeOut(200).removeClass("on");
}

// 링크 복사
export const clipCopy = (str) => {
  var tempElement = document.createElement("textarea");

  tempElement.value = str;

  document.body.appendChild(tempElement);

  tempElement.select();

  tempElement.setAttribute("readonly", "");
  tempElement.setAttribute("contenteditable", "false");
  tempElement.style.position = 'absolute';
  tempElement.style.left = '-9999px';
  tempElement.setSelectionRange(0, tempElement.value.length);

  document.execCommand('copy');

  document.body.removeChild(tempElement);

  alert("링크가 복사되었습니다.");
}

// 별점 기능
export const scoreF = () => {
  const scoreInput = document.querySelectorAll('.score-list input[type="radio"]');
  const scoreView = document.querySelector('.score-add');
  
  scoreInput.forEach(radio => {
    radio.addEventListener('change', function() {
      scoreView.textContent = this.value;
    });
  });
  
  const scoreResult = document.querySelector('.score-list input[type="radio"]:checked');
  if (scoreResult) {
    scoreView.textContent = scoreResult.value;
  }
}

// 이미지 업로드 (미리보기)
export const previewImage = (event) => {
  const imgUploadInput = event.target;
  const imgUploadItem = imgUploadInput.parentElement;
  const imgUploadFile = imgUploadInput.files[0];
  const imgReader = new FileReader();

  imgReader.onload = function() {
    const imgUploadView = imgUploadItem.querySelector('.img-upload-view');
    imgUploadView.classList.add('active');
    imgUploadView.style.backgroundImage = `url(${imgReader.result})`;
    imgUploadItem.querySelector('.img-upload-delete').style.display = 'block';
  }
  imgReader.readAsDataURL(imgUploadFile);
}

// 이미지 업로드 (삭제)
export const deleteImage = (index) => {
  const imgUploadInput = document.querySelector(`#imgUpload${index}`);
  const imgUploadItem = imgUploadInput.parentElement;
  const imgUploadDel = imgUploadItem.querySelector('.img-upload-delete');
  const imgUploadView = imgUploadItem.querySelector('.img-upload-view');

  const confirmDelete = confirm("해당 이미지를 삭제하시겠습니까?");
  if (confirmDelete) {
    imgUploadView.classList.remove('active');
    imgUploadView.style.backgroundImage = '';
    imgUploadInput.value = '';
    imgUploadDel.style.display = 'none';
  }
}