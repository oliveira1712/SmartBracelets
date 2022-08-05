/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./main/homepage */ "./resources/js/main/homepage.js");

__webpack_require__(/*! ./recursos/loadingspiwrap */ "./resources/js/recursos/loadingspiwrap.js");

__webpack_require__(/*! ./recursos/navclearonscroll */ "./resources/js/recursos/navclearonscroll.js");

__webpack_require__(/*! ./recursos/customselectdropdown */ "./resources/js/recursos/customselectdropdown.js");

__webpack_require__(/*! ./recursos/customselectdropdown2 */ "./resources/js/recursos/customselectdropdown2.js");

/***/ }),

/***/ "./resources/js/main/homepage.js":
/*!***************************************!*\
  !*** ./resources/js/main/homepage.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//Select element function
var selectElement = function selectElement(element) {
  return document.querySelector(element);
};

var menuToggler = selectElement('.menu-toggle');
/* Quero selecionar o menu-toggle */

var body = selectElement('body');
/* Quero selecionar o body */

menuToggler.addEventListener('click', function () {
  body.classList.toggle('open');
}); //Scroll reveal

window.sr = ScrollReveal();
sr.reveal('.animate-left', {
  origin: 'left',
  duration: 1000,
  distance: '25rem',
  delay: 300 //Quanto tempo demora a animacao a comecar

});
sr.reveal('.animate-right', {
  origin: 'right',
  duration: 1000,
  distance: '25rem',
  delay: 600 //Quanto tempo demora a animacao a comecar

});
sr.reveal('.animate-top', {
  origin: 'top',
  duration: 1000,
  distance: '25rem',
  delay: 600 //Quanto tempo demora a animacao a comecar

});
sr.reveal('.animate-bottom', {
  origin: 'bottom',
  duration: 1000,
  distance: '25rem',
  delay: 600 //Quanto tempo demora a animacao a comecar

});

/***/ }),

/***/ "./resources/js/recursos/customselectdropdown.js":
/*!*******************************************************!*\
  !*** ./resources/js/recursos/customselectdropdown.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$("select[data-menu]").each(function () {
  var select = $(this),
      options = select.find("option"),
      menu = $("<div />").addClass("select-menu"),
      button = $("<div />").addClass("button"),
      list = $("<ul />"),
      arrow = $("<em />").prependTo(button);
  options.each(function (i) {
    var option = $(this);
    list.append($("<li />").text(option.text()));
  });
  menu.css("--t", select.find(":selected").index() * -41 + "px");
  select.wrap(menu);
  button.append(list).insertAfter(select);
  list.clone().insertAfter(button);
});
$(document).on("click", ".select-menu", function (e) {
  var menu = $(this);

  if (!menu.hasClass("open")) {
    menu.addClass("open");
  }
});
$(document).on("click", ".select-menu > ul > li", function (e) {
  var li = $(this),
      menu = li.parent().parent(),
      select = menu.children("select"),
      selected = select.find("option:selected"),
      index = li.index();
  menu.css("--t", index * -41 + "px");
  selected.attr("selected", false);
  select.find("option").eq(index).attr("selected", true);
  menu.addClass(index > selected.index() ? "tilt-down" : "tilt-up");
  setTimeout(function () {
    menu.removeClass("open tilt-up tilt-down");
  }, 500);
});
$(document).click(function (e) {
  e.stopPropagation();

  if ($(".select-menu").has(e.target).length === 0) {
    $(".select-menu").removeClass("open");
  }
});

/***/ }),

/***/ "./resources/js/recursos/customselectdropdown2.js":
/*!********************************************************!*\
  !*** ./resources/js/recursos/customselectdropdown2.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(".custom-select").each(function () {
  var classes = $(this).attr("class"),
      id = $(this).attr("id"),
      name = $(this).attr("name");
  var template = '<div class="' + classes + '">';
  template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + "</span>";
  template += '<div class="custom-options">';
  $(this).find("option").each(function () {
    template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + "</span>";
  });
  template += "</div></div>";
  $(this).wrap('<div class="custom-select-wrapper"></div>');
  $(this).hide();
  $(this).after(template);
});
$(".custom-option:first-of-type").hover(function () {
  $(this).parents(".custom-options").addClass("option-hover");
}, function () {
  $(this).parents(".custom-options").removeClass("option-hover");
});
$(".custom-select-trigger").on("click", function () {
  $("html").one("click", function () {
    $(".custom-select").removeClass("opened");
  });
  $(this).parents(".custom-select").toggleClass("opened");
  event.stopPropagation();
});
$(".custom-option").on("click", function () {
  $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
  $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
  $(this).addClass("selection");
  $(this).parents(".custom-select").removeClass("opened");
  $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
});

/***/ }),

/***/ "./resources/js/recursos/loadingspiwrap.js":
/*!*************************************************!*\
  !*** ./resources/js/recursos/loadingspiwrap.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//para o loading
var spinnerWrapper = document.querySelector('.spinner-wrapper');
window.addEventListener('load', function () {
  //spinnerWrapper.style.display = 'none';
  spinnerWrapper.parentElement.removeChild(spinnerWrapper);
});

/***/ }),

/***/ "./resources/js/recursos/navclearonscroll.js":
/*!***************************************************!*\
  !*** ./resources/js/recursos/navclearonscroll.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
window.addEventListener("scroll", function () {
  var scrollTop = window.pageYOffset || this.document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    headerlist.style.top = "-7.2rem";
  } else {
    headerlist.style.top = "0";
  }

  lastScrollTop = scrollTop;
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\SmartBracelets\resources\js\main.js */"./resources/js/main.js");


/***/ })

/******/ });