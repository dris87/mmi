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

/***/ "./resources/assets/js/web/js/news_letter/news_letter.js":
/*!***************************************************************!*\
  !*** ./resources/assets/js/web/js/news_letter/news_letter.js ***!
  \***************************************************************/
/***/ (() => {

eval("\n\n$(document).on('submit', '#newsLetterForm', function (event) {\n  event.preventDefault();\n  var email = $('#mc-email').val();\n  console.log(email);\n  var emailExp = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+$/;\n  var emailCheck = email == '' ? true : emailExp.test(email) ? true : false;\n  if (!emailCheck) {\n    displayErrorMessage('Please enter a valid Email');\n    return false;\n  }\n  var loadingButton = jQuery(this).find('#btnLetterSave');\n  loadingButton.button('loading');\n  $.ajax({\n    url: createNewLetterUrl,\n    type: 'post',\n    data: new FormData($(this)[0]),\n    processData: false,\n    contentType: false,\n    success: function success(result) {\n      displaySuccessMessage(result.message);\n    },\n    error: function error(result) {\n      displayErrorMessage(result.responseJSON.message);\n    },\n    complete: function complete() {\n      $('#mc-email').val('');\n      loadingButton.button('reset');\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3dlYi9qcy9uZXdzX2xldHRlci9uZXdzX2xldHRlci5qcyIsIm1hcHBpbmdzIjoiQUFBYTs7QUFFYkEsQ0FBQyxDQUFDQyxRQUFRLENBQUMsQ0FBQ0MsRUFBRSxDQUFDLFFBQVEsRUFBRSxpQkFBaUIsRUFBRSxVQUFVQyxLQUFLLEVBQUU7RUFDekRBLEtBQUssQ0FBQ0MsY0FBYyxDQUFDLENBQUM7RUFDdEIsSUFBSUMsS0FBSyxHQUFHTCxDQUFDLENBQUMsV0FBVyxDQUFDLENBQUNNLEdBQUcsQ0FBQyxDQUFDO0VBQ2hDQyxPQUFPLENBQUNDLEdBQUcsQ0FBQ0gsS0FBSyxDQUFDO0VBQ2xCLElBQUlJLFFBQVEsR0FBRywrREFBK0Q7RUFDOUUsSUFBSUMsVUFBVSxHQUFJTCxLQUFLLElBQUksRUFBRSxHQUFHLElBQUksR0FBSUksUUFBUSxDQUFDRSxJQUFJLENBQ2pETixLQUFLLENBQUMsR0FBRyxJQUFJLEdBQUcsS0FBTztFQUMzQixJQUFJLENBQUNLLFVBQVUsRUFBRTtJQUNiRSxtQkFBbUIsQ0FBQyw0QkFBNEIsQ0FBQztJQUNqRCxPQUFPLEtBQUs7RUFDaEI7RUFDQSxJQUFJQyxhQUFhLEdBQUdDLE1BQU0sQ0FBQyxJQUFJLENBQUMsQ0FBQ0MsSUFBSSxDQUFDLGdCQUFnQixDQUFDO0VBQ3ZERixhQUFhLENBQUNHLE1BQU0sQ0FBQyxTQUFTLENBQUM7RUFDL0JoQixDQUFDLENBQUNpQixJQUFJLENBQUM7SUFDSEMsR0FBRyxFQUFFQyxrQkFBa0I7SUFDdkJDLElBQUksRUFBRSxNQUFNO0lBQ1pDLElBQUksRUFBRSxJQUFJQyxRQUFRLENBQUN0QixDQUFDLENBQUMsSUFBSSxDQUFDLENBQUMsQ0FBQyxDQUFDLENBQUM7SUFDOUJ1QixXQUFXLEVBQUUsS0FBSztJQUNsQkMsV0FBVyxFQUFFLEtBQUs7SUFDbEJDLE9BQU8sRUFBRSxTQUFUQSxPQUFPQSxDQUFZQyxNQUFNLEVBQUU7TUFDdkJDLHFCQUFxQixDQUFDRCxNQUFNLENBQUNFLE9BQU8sQ0FBQztJQUN6QyxDQUFDO0lBQ0RDLEtBQUssRUFBRSxTQUFQQSxLQUFLQSxDQUFZSCxNQUFNLEVBQUU7TUFDckJkLG1CQUFtQixDQUFDYyxNQUFNLENBQUNJLFlBQVksQ0FBQ0YsT0FBTyxDQUFDO0lBQ3BELENBQUM7SUFDREcsUUFBUSxFQUFFLFNBQVZBLFFBQVFBLENBQUEsRUFBYztNQUNsQi9CLENBQUMsQ0FBQyxXQUFXLENBQUMsQ0FBQ00sR0FBRyxDQUFDLEVBQUUsQ0FBQztNQUN0Qk8sYUFBYSxDQUFDRyxNQUFNLENBQUMsT0FBTyxDQUFDO0lBQ2pDO0VBQ0osQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy93ZWIvanMvbmV3c19sZXR0ZXIvbmV3c19sZXR0ZXIuanM/ODRkMSJdLCJzb3VyY2VzQ29udGVudCI6WyIndXNlIHN0cmljdCc7XG5cbiQoZG9jdW1lbnQpLm9uKCdzdWJtaXQnLCAnI25ld3NMZXR0ZXJGb3JtJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICBsZXQgZW1haWwgPSAkKCcjbWMtZW1haWwnKS52YWwoKTtcbiAgICBjb25zb2xlLmxvZyhlbWFpbCk7XG4gICAgbGV0IGVtYWlsRXhwID0gL14oW2EtekEtWjAtOV8uKy1dKStcXEAoKFthLXpBLVowLTktXSkrXFwuKSsoW2EtekEtWjAtOV17Miw0fSkrJC87XG4gICAgbGV0IGVtYWlsQ2hlY2sgPSAoZW1haWwgPT0gJycgPyB0cnVlIDogKGVtYWlsRXhwLnRlc3QoXG4gICAgICAgIGVtYWlsKSA/IHRydWUgOiBmYWxzZSkpO1xuICAgIGlmICghZW1haWxDaGVjaykge1xuICAgICAgICBkaXNwbGF5RXJyb3JNZXNzYWdlKCdQbGVhc2UgZW50ZXIgYSB2YWxpZCBFbWFpbCcpO1xuICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgfVxuICAgIGxldCBsb2FkaW5nQnV0dG9uID0galF1ZXJ5KHRoaXMpLmZpbmQoJyNidG5MZXR0ZXJTYXZlJyk7XG4gICAgbG9hZGluZ0J1dHRvbi5idXR0b24oJ2xvYWRpbmcnKTtcbiAgICAkLmFqYXgoe1xuICAgICAgICB1cmw6IGNyZWF0ZU5ld0xldHRlclVybCxcbiAgICAgICAgdHlwZTogJ3Bvc3QnLFxuICAgICAgICBkYXRhOiBuZXcgRm9ybURhdGEoJCh0aGlzKVswXSksXG4gICAgICAgIHByb2Nlc3NEYXRhOiBmYWxzZSxcbiAgICAgICAgY29udGVudFR5cGU6IGZhbHNlLFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzdWx0KSB7XG4gICAgICAgICAgICBkaXNwbGF5U3VjY2Vzc01lc3NhZ2UocmVzdWx0Lm1lc3NhZ2UpO1xuICAgICAgICB9LFxuICAgICAgICBlcnJvcjogZnVuY3Rpb24gKHJlc3VsdCkge1xuICAgICAgICAgICAgZGlzcGxheUVycm9yTWVzc2FnZShyZXN1bHQucmVzcG9uc2VKU09OLm1lc3NhZ2UpO1xuICAgICAgICB9LFxuICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgJCgnI21jLWVtYWlsJykudmFsKCcnKTtcbiAgICAgICAgICAgIGxvYWRpbmdCdXR0b24uYnV0dG9uKCdyZXNldCcpO1xuICAgICAgICB9LFxuICAgIH0pO1xufSk7XG4iXSwibmFtZXMiOlsiJCIsImRvY3VtZW50Iiwib24iLCJldmVudCIsInByZXZlbnREZWZhdWx0IiwiZW1haWwiLCJ2YWwiLCJjb25zb2xlIiwibG9nIiwiZW1haWxFeHAiLCJlbWFpbENoZWNrIiwidGVzdCIsImRpc3BsYXlFcnJvck1lc3NhZ2UiLCJsb2FkaW5nQnV0dG9uIiwialF1ZXJ5IiwiZmluZCIsImJ1dHRvbiIsImFqYXgiLCJ1cmwiLCJjcmVhdGVOZXdMZXR0ZXJVcmwiLCJ0eXBlIiwiZGF0YSIsIkZvcm1EYXRhIiwicHJvY2Vzc0RhdGEiLCJjb250ZW50VHlwZSIsInN1Y2Nlc3MiLCJyZXN1bHQiLCJkaXNwbGF5U3VjY2Vzc01lc3NhZ2UiLCJtZXNzYWdlIiwiZXJyb3IiLCJyZXNwb25zZUpTT04iLCJjb21wbGV0ZSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/assets/js/web/js/news_letter/news_letter.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/web/js/news_letter/news_letter.js"]();
/******/ 	
/******/ })()
;