/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/custom/input_price_format.js":
/*!**********************************************************!*\
  !*** ./resources/assets/js/custom/input_price_format.js ***!
  \**********************************************************/
/***/ (() => {

eval("\n\nwindow.addCommas = function (nStr) {\n  nStr += '';\n  var x = nStr.split('.');\n  var x1 = x[0];\n  var x2 = x.length > 1 ? '.' + x[1] : '';\n  var rgx = /(\\d+)(\\d{3})/;\n  while (rgx.test(x1)) {\n    x1 = x1.replace(rgx, '$1' + ',' + '$2');\n  }\n  return x1 + x2;\n};\nwindow.getFormattedPrice = function (price) {\n  if (price != '' || price > 0) {\n    if (typeof price !== 'number') {\n      price = price.replace(/,/g, '');\n    }\n    return addCommas(price);\n  }\n};\nwindow.priceFormatSelector = function (selector) {\n  $(document).on('input keyup keydown keypress', selector, function (event) {\n    var price = $(this).val();\n    if (price === '') {\n      $(this).val('');\n    } else {\n      if (/[0-9]+(,[0-9]+)*$/.test(price)) {\n        $(this).val(getFormattedPrice(price));\n        return true;\n      } else {\n        $(this).val(price.replace(/[^0-9 \\,]/, ''));\n      }\n    }\n  });\n};\npriceFormatSelector('.price-input');//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL2N1c3RvbS9pbnB1dF9wcmljZV9mb3JtYXQuanMiLCJtYXBwaW5ncyI6IkFBQWE7O0FBRWJBLE1BQU0sQ0FBQ0MsU0FBUyxHQUFHLFVBQVVDLElBQUksRUFBRTtFQUMvQkEsSUFBSSxJQUFJLEVBQUU7RUFDVixJQUFJQyxDQUFDLEdBQUdELElBQUksQ0FBQ0UsS0FBSyxDQUFDLEdBQUcsQ0FBQztFQUN2QixJQUFJQyxFQUFFLEdBQUdGLENBQUMsQ0FBQyxDQUFDLENBQUM7RUFDYixJQUFJRyxFQUFFLEdBQUdILENBQUMsQ0FBQ0ksTUFBTSxHQUFHLENBQUMsR0FBRyxHQUFHLEdBQUdKLENBQUMsQ0FBQyxDQUFDLENBQUMsR0FBRyxFQUFFO0VBQ3ZDLElBQUlLLEdBQUcsR0FBRyxjQUFjO0VBQ3hCLE9BQU9BLEdBQUcsQ0FBQ0MsSUFBSSxDQUFDSixFQUFFLENBQUMsRUFBRTtJQUNqQkEsRUFBRSxHQUFHQSxFQUFFLENBQUNLLE9BQU8sQ0FBQ0YsR0FBRyxFQUFFLElBQUksR0FBRyxHQUFHLEdBQUcsSUFBSSxDQUFDO0VBQzNDO0VBQ0EsT0FBT0gsRUFBRSxHQUFHQyxFQUFFO0FBQ2xCLENBQUM7QUFFRE4sTUFBTSxDQUFDVyxpQkFBaUIsR0FBRyxVQUFVQyxLQUFLLEVBQUU7RUFDeEMsSUFBSUEsS0FBSyxJQUFJLEVBQUUsSUFBSUEsS0FBSyxHQUFHLENBQUMsRUFBRTtJQUMxQixJQUFJLE9BQU9BLEtBQUssS0FBSyxRQUFRLEVBQUU7TUFDM0JBLEtBQUssR0FBR0EsS0FBSyxDQUFDRixPQUFPLENBQUMsSUFBSSxFQUFFLEVBQUUsQ0FBQztJQUNuQztJQUNBLE9BQU9ULFNBQVMsQ0FBQ1csS0FBSyxDQUFDO0VBQzNCO0FBQ0osQ0FBQztBQUVEWixNQUFNLENBQUNhLG1CQUFtQixHQUFHLFVBQVVDLFFBQVEsRUFBRTtFQUM3Q0MsQ0FBQyxDQUFDQyxRQUFRLENBQUMsQ0FBQ0MsRUFBRSxDQUFDLDhCQUE4QixFQUFFSCxRQUFRLEVBQUUsVUFBVUksS0FBSyxFQUFFO0lBQ3RFLElBQUlOLEtBQUssR0FBR0csQ0FBQyxDQUFDLElBQUksQ0FBQyxDQUFDSSxHQUFHLENBQUMsQ0FBQztJQUN6QixJQUFJUCxLQUFLLEtBQUssRUFBRSxFQUFFO01BQ2RHLENBQUMsQ0FBQyxJQUFJLENBQUMsQ0FBQ0ksR0FBRyxDQUFDLEVBQUUsQ0FBQztJQUNuQixDQUFDLE1BQU07TUFDSCxJQUFJLG1CQUFtQixDQUFDVixJQUFJLENBQUNHLEtBQUssQ0FBQyxFQUFFO1FBQ2pDRyxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNJLEdBQUcsQ0FBQ1IsaUJBQWlCLENBQUNDLEtBQUssQ0FBQyxDQUFDO1FBQ3JDLE9BQU8sSUFBSTtNQUNmLENBQUMsTUFBTTtRQUNIRyxDQUFDLENBQUMsSUFBSSxDQUFDLENBQUNJLEdBQUcsQ0FBQ1AsS0FBSyxDQUFDRixPQUFPLENBQUMsV0FBVyxFQUFFLEVBQUUsQ0FBQyxDQUFDO01BQy9DO0lBQ0o7RUFDSixDQUFDLENBQUM7QUFDTixDQUFDO0FBRURHLG1CQUFtQixDQUFDLGNBQWMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvY3VzdG9tL2lucHV0X3ByaWNlX2Zvcm1hdC5qcz9mMDExIl0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0Jztcblxud2luZG93LmFkZENvbW1hcyA9IGZ1bmN0aW9uIChuU3RyKSB7XG4gICAgblN0ciArPSAnJztcbiAgICBsZXQgeCA9IG5TdHIuc3BsaXQoJy4nKTtcbiAgICBsZXQgeDEgPSB4WzBdO1xuICAgIGxldCB4MiA9IHgubGVuZ3RoID4gMSA/ICcuJyArIHhbMV0gOiAnJztcbiAgICB2YXIgcmd4ID0gLyhcXGQrKShcXGR7M30pLztcbiAgICB3aGlsZSAocmd4LnRlc3QoeDEpKSB7XG4gICAgICAgIHgxID0geDEucmVwbGFjZShyZ3gsICckMScgKyAnLCcgKyAnJDInKTtcbiAgICB9XG4gICAgcmV0dXJuIHgxICsgeDI7XG59O1xuXG53aW5kb3cuZ2V0Rm9ybWF0dGVkUHJpY2UgPSBmdW5jdGlvbiAocHJpY2UpIHtcbiAgICBpZiAocHJpY2UgIT0gJycgfHwgcHJpY2UgPiAwKSB7XG4gICAgICAgIGlmICh0eXBlb2YgcHJpY2UgIT09ICdudW1iZXInKSB7XG4gICAgICAgICAgICBwcmljZSA9IHByaWNlLnJlcGxhY2UoLywvZywgJycpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBhZGRDb21tYXMocHJpY2UpO1xuICAgIH1cbn07XG5cbndpbmRvdy5wcmljZUZvcm1hdFNlbGVjdG9yID0gZnVuY3Rpb24gKHNlbGVjdG9yKSB7XG4gICAgJChkb2N1bWVudCkub24oJ2lucHV0IGtleXVwIGtleWRvd24ga2V5cHJlc3MnLCBzZWxlY3RvciwgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgIGxldCBwcmljZSA9ICQodGhpcykudmFsKCk7XG4gICAgICAgIGlmIChwcmljZSA9PT0gJycpIHtcbiAgICAgICAgICAgICQodGhpcykudmFsKCcnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGlmICgvWzAtOV0rKCxbMC05XSspKiQvLnRlc3QocHJpY2UpKSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS52YWwoZ2V0Rm9ybWF0dGVkUHJpY2UocHJpY2UpKTtcbiAgICAgICAgICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS52YWwocHJpY2UucmVwbGFjZSgvW14wLTkgXFwsXS8sICcnKSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9KTtcbn07XG5cbnByaWNlRm9ybWF0U2VsZWN0b3IoJy5wcmljZS1pbnB1dCcpO1xuIl0sIm5hbWVzIjpbIndpbmRvdyIsImFkZENvbW1hcyIsIm5TdHIiLCJ4Iiwic3BsaXQiLCJ4MSIsIngyIiwibGVuZ3RoIiwicmd4IiwidGVzdCIsInJlcGxhY2UiLCJnZXRGb3JtYXR0ZWRQcmljZSIsInByaWNlIiwicHJpY2VGb3JtYXRTZWxlY3RvciIsInNlbGVjdG9yIiwiJCIsImRvY3VtZW50Iiwib24iLCJldmVudCIsInZhbCJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/js/custom/input_price_format.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/custom/input_price_format.js"]();
/******/ 	
/******/ })()
;