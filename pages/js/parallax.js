$(document).ready(function(){
    $('section[data-type="background-image"]').each(function(){
        var $bgobj = $(this); // создаем объект
        $(window).scroll(function() {
            var yPos = -($window.scrollTop() / $bgobj.data('speed')); // вычисляем коэффициент 
            // Присваиваем значение background-position
            var coords = 'center '+ yPos + 'px';
            // Создаем эффект Parallax Scrolling
            $bgobj.css({ backgroundPosition: coords });
        });
    });
});

$(window).scroll(function(){

  var wScroll = $(this).scrollTop();

  $('.logo').css({'-ms-transform':'translate(0, -'+ wScroll /8 +'%)',
                  '-webkit-transform':'translate(0, -'+ wScroll /8 +'%)',
                  'transform':'translate(0, -'+ wScroll /8 +'%)'});
});

//Швидкість прокрутки сторінки

$.fn.moveIt = function(){
  var $window = $(window);
  var instances = [];
  
  $(this).each(function(){
    instances.push(new moveItItem($(this)));
  });
  
  window.onscroll = function(){
    var scrollTop = $window.scrollTop();
    instances.forEach(function(inst){
      inst.update(scrollTop);
    });
  }
}

var moveItItem = function(el){
  this.el = $(el);
  this.speed = parseInt(this.el.attr('data-scroll-speed'));
};

moveItItem.prototype.update = function(scrollTop){
  var pos = scrollTop / this.speed;
  this.el.css('transform', 'translateY(' + -pos + 'px)');
};

$(function(){
  $('[data-scroll-speed]').moveIt();
});

$('.parallax-window-home').parallax({imageSrc: '/img/home-bg.jpg'});

$('.parallax-window-theatre').parallax({imageSrc: '/img/theatre-bg.jpg'});

$('.parallax-window-repertoire').parallax({imageSrc: '/img/repertoire-bg.jpg'});

$('.parallax-window-news').parallax({imageSrc: '/img/news/news-bg.jpg'});

/* Скорость прокрутки */
if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
window.onmousewheel = document.onmousewheel = wheel;

function wheel(event) {
    var delta = 0;
    if (event.wheelDelta) delta = event.wheelDelta / 120;
    else if (event.detail) delta = -event.detail / 3;

    handle(delta);
    if (event.preventDefault) event.preventDefault();
    event.returnValue = false;
}

function handle(delta) {
    var time = 1000;
  var distance = 500;
    
    $('html, body').stop().animate({
        scrollTop: $(window).scrollTop() - (distance * delta)
    }, time );
}