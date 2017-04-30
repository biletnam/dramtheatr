$(document).ready(function() {
    NProgress.start();

    $('.select-lang').on('click', function(e){
        e.preventDefault();
        $(this).next().slideToggle(500);
    });
    $('.top-line-menu .under-menu .right-top-block .right-top-langauges-block .lang a').on('click',function(){
        $('.top-line-menu .under-menu .right-top-block .right-top-langauges-block .lang').slideToggle(500);
    });

    $('.hamburger').on('click', function(){
        $(this).next().animate({
          "width": "toggle"
      }, 800 );
    });

    /*$('.reper-list a').on('mouseover', function(){
        $(this).parent().find('img').css({'-webkit-transform' : 'scale(1.1)',
                            '-moz-transform' : 'scale(1.1)',
                            '-o-transform' : 'scale(1.1)'
                            });
    });
    $('.reper-list a').on('mouseout', function(){
        $(this).parent().find('img').css({'-webkit-transform' : 'scale(1)',
                            '-moz-transform' : 'scale(1)',
                            '-o-transform' : 'scale(1)'
                            });
    });*/

    // Репертур //
    $('.menu-line nav ul li a').click(function(e) {
        e.preventDefault();
        var animationName = 'animated fadeIn';
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $('.menu-line .active').removeClass('active');
        $(this).addClass('active');
        var atr = $(this).attr('href');
        $('.reper-list').not(atr).css({'display':'none'});
        $(atr).fadeIn(500).addClass(animationName);
    });

    // Прaцівники //
    $('.menu-line nav ul li a').click(function(e) {
        e.preventDefault();
        var animationName = 'animated fadeIn';
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $('.menu-line .active').removeClass('active');
        $(this).addClass('active');
        var atr = $(this).attr('href');
        $('.team-list').not(atr).css({'display':'none'});
        $(atr).fadeIn(400).addClass(animationName);
    });

    // Театр//
    $('.menu-line nav ul li a').click(function(e) {
        e.preventDefault();
        var animationName = 'animated fadeIn';
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $('.menu-line .active').removeClass('active');
        $(this).addClass('active');
        var atr = $(this).attr('href');
        $('.theatre-block').not(atr).css({'display':'none'});
        $(atr).fadeIn(400).addClass(animationName);
    });

    var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

    var hamburgers = document.querySelectorAll(".hamburger");
    if (hamburgers.length > 0) {
      forEach(hamburgers, function(hamburger) {
        hamburger.addEventListener("click", function() {
          this.classList.toggle("is-active");
        }, false);
      });
    }

    /* Message */
    $("#form").submit(function() {
        $.ajax({
            type: "POST",
            url: "/mail.php",
            data: $(this).serialize()
        }).done(function() {
            $("form.form").css('opacity','0');
            setTimeout(function() {
                $('.done').fadeIn();
            }, 800);
        });
        return false;
    });

    $('.carousel').slick({
          dots: true,
          infinite: true,
          speed: 500,
          fade: true,
          cssEase: 'linear'
    });


});


$(window).load(function(){
    setTimeout(function(){
        $('.wrapper').removeClass('out');
        $('.loader').addClass('dn').removeClass('loader');
        NProgress.done();
    }, 500);
});