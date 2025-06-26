/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/privacy_policy/privacy_policy.js":
/*!**************************************************************!*\
  !*** ./resources/assets/js/privacy_policy/privacy_policy.js ***!
  \**************************************************************/
/***/ (() => {

eval("$(document).ready(function () {\n  $('#description').summernote({\n    minHeight: 200,\n    height: 200,\n    toolbar: [\n    // [groupName, [list of button]]\n    ['style', ['bold', 'italic', 'underline', 'clear']], ['font', ['strikethrough']], ['para', ['paragraph']]]\n  });\n  $('#privacyPolicy').submit(function (e) {\n    if (!checkSummerNoteEmpty('#description', 'Privacy Policy field is required.', 1)) {\n      e.preventDefault();\n      return true;\n    }\n  });\n  $('#termsConditions').submit(function (e) {\n    if (!checkSummerNoteEmpty('#description', 'Terms Conditions field is required.', 1)) {\n      e.preventDefault();\n      return true;\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsInN1bW1lcm5vdGUiLCJtaW5IZWlnaHQiLCJoZWlnaHQiLCJ0b29sYmFyIiwic3VibWl0IiwiZSIsImNoZWNrU3VtbWVyTm90ZUVtcHR5IiwicHJldmVudERlZmF1bHQiXSwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9wcml2YWN5X3BvbGljeS9wcml2YWN5X3BvbGljeS5qcz85NjFjIl0sInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uICgpIHtcbiAgICAkKCcjZGVzY3JpcHRpb24nKS5zdW1tZXJub3RlKHtcbiAgICAgICAgbWluSGVpZ2h0OiAyMDAsXG4gICAgICAgIGhlaWdodDogMjAwLFxuICAgICAgICB0b29sYmFyOiBbXG4gICAgICAgICAgICAvLyBbZ3JvdXBOYW1lLCBbbGlzdCBvZiBidXR0b25dXVxuICAgICAgICAgICAgWydzdHlsZScsIFsnYm9sZCcsICdpdGFsaWMnLCAndW5kZXJsaW5lJywgJ2NsZWFyJ11dLFxuICAgICAgICAgICAgWydmb250JywgWydzdHJpa2V0aHJvdWdoJ11dLFxuICAgICAgICAgICAgWydwYXJhJywgWydwYXJhZ3JhcGgnXV0sXG4gICAgICAgIF0sXG4gICAgfSk7XG5cbiAgICAkKCcjcHJpdmFjeVBvbGljeScpLnN1Ym1pdChmdW5jdGlvbiAoZSkge1xuICAgICAgICBpZiAoIWNoZWNrU3VtbWVyTm90ZUVtcHR5KCcjZGVzY3JpcHRpb24nLFxuICAgICAgICAgICAgJ1ByaXZhY3kgUG9saWN5IGZpZWxkIGlzIHJlcXVpcmVkLicsIDEpKSB7XG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgICAgIHJldHVybiB0cnVlO1xuICAgICAgICB9XG4gICAgfSk7XG5cbiAgICAkKCcjdGVybXNDb25kaXRpb25zJykuc3VibWl0KGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGlmICghY2hlY2tTdW1tZXJOb3RlRW1wdHkoJyNkZXNjcmlwdGlvbicsXG4gICAgICAgICAgICAnVGVybXMgQ29uZGl0aW9ucyBmaWVsZCBpcyByZXF1aXJlZC4nLCAxKSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7XG4iXSwibWFwcGluZ3MiOiJBQUFBQSxDQUFDLENBQUNDLFFBQVEsQ0FBQyxDQUFDQyxLQUFLLENBQUMsWUFBWTtFQUMxQkYsQ0FBQyxDQUFDLGNBQWMsQ0FBQyxDQUFDRyxVQUFVLENBQUM7SUFDekJDLFNBQVMsRUFBRSxHQUFHO0lBQ2RDLE1BQU0sRUFBRSxHQUFHO0lBQ1hDLE9BQU8sRUFBRTtJQUNMO0lBQ0EsQ0FBQyxPQUFPLEVBQUUsQ0FBQyxNQUFNLEVBQUUsUUFBUSxFQUFFLFdBQVcsRUFBRSxPQUFPLENBQUMsQ0FBQyxFQUNuRCxDQUFDLE1BQU0sRUFBRSxDQUFDLGVBQWUsQ0FBQyxDQUFDLEVBQzNCLENBQUMsTUFBTSxFQUFFLENBQUMsV0FBVyxDQUFDLENBQUM7RUFFL0IsQ0FBQyxDQUFDO0VBRUZOLENBQUMsQ0FBQyxnQkFBZ0IsQ0FBQyxDQUFDTyxNQUFNLENBQUMsVUFBVUMsQ0FBQyxFQUFFO0lBQ3BDLElBQUksQ0FBQ0Msb0JBQW9CLENBQUMsY0FBYyxFQUNwQyxtQ0FBbUMsRUFBRSxDQUFDLENBQUMsRUFBRTtNQUN6Q0QsQ0FBQyxDQUFDRSxjQUFjLENBQUMsQ0FBQztNQUVsQixPQUFPLElBQUk7SUFDZjtFQUNKLENBQUMsQ0FBQztFQUVGVixDQUFDLENBQUMsa0JBQWtCLENBQUMsQ0FBQ08sTUFBTSxDQUFDLFVBQVVDLENBQUMsRUFBRTtJQUN0QyxJQUFJLENBQUNDLG9CQUFvQixDQUFDLGNBQWMsRUFDcEMscUNBQXFDLEVBQUUsQ0FBQyxDQUFDLEVBQUU7TUFDM0NELENBQUMsQ0FBQ0UsY0FBYyxDQUFDLENBQUM7TUFFbEIsT0FBTyxJQUFJO0lBQ2Y7RUFDSixDQUFDLENBQUM7QUFDTixDQUFDLENBQUMiLCJpZ25vcmVMaXN0IjpbXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9wcml2YWN5X3BvbGljeS9wcml2YWN5X3BvbGljeS5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/js/privacy_policy/privacy_policy.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/privacy_policy/privacy_policy.js"]();
/******/ 	
/******/ })()
;