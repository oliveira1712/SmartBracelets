/*$(function (){
    var scroll = $(document).scrollTop();
    var navHeight = $('.header').outerHeight();

    $(window).scroll(function (){
        var scrolled = $(document).scrollTop();

        if(scrolled > navHeight){
            $('.header').addClass('animate');
        }else{
            $('.header').removeClass('animate');
        }

        if(scrolled > scroll){
            $('.header').removeClass('sticky');
        }else{
            $('.header').addClass('sticky');
        }

        scroll = $(document).scrollTop;

    });
});*/

var lastScrollTop = 0;
    headerlist = document.getElementById("headerlist");
    window.addEventListener("scroll",function (){
        var scrollTop = window.pageYOffset || this.document.documentElement.scrollTop;

        if(scrollTop > lastScrollTop){
            headerlist.style.top="-7.2rem";
        }else{
            headerlist.style.top="0";
        }
        lastScrollTop = scrollTop;
    })