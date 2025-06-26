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

/***/ "./resources/assets/js/custom/custom-datatable.js":
/*!********************************************************!*\
  !*** ./resources/assets/js/custom/custom-datatable.js ***!
  \********************************************************/
/***/ (() => {

eval("\n\n$.extend($.fn.dataTable.defaults, {\n  'paging': true,\n  'info': true,\n  'ordering': true,\n  'autoWidth': false,\n  'pageLength': 10,\n  'language': {\n    'search': '',\n    'sSearch': 'Search'\n  },\n  \"preDrawCallback\": function preDrawCallback() {\n    customSearch();\n  },\n  dom: 'lBfrtip',\n  tableTools: {\n    \"sSwfPath\": \"media/swf/copy_csv_xls_pdf.swf\"\n  },\n  buttons: [{\n    extend: 'csv',\n    title: 'ProjectR Data Export',\n    className: 'btn btn-primary'\n  }]\n});\nfunction customSearch() {\n  $('.dataTables_filter input').addClass(\"form-control\");\n  $('.dataTables_filter input').attr(\"placeholder\", \"Search\");\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL2N1c3RvbS9jdXN0b20tZGF0YXRhYmxlLmpzIiwibWFwcGluZ3MiOiJBQUFhOztBQUViQSxDQUFDLENBQUNDLE1BQU0sQ0FBQ0QsQ0FBQyxDQUFDRSxFQUFFLENBQUNDLFNBQVMsQ0FBQ0MsUUFBUSxFQUFFO0VBQzlCLFFBQVEsRUFBRSxJQUFJO0VBQ2QsTUFBTSxFQUFFLElBQUk7RUFDWixVQUFVLEVBQUUsSUFBSTtFQUNoQixXQUFXLEVBQUUsS0FBSztFQUNsQixZQUFZLEVBQUUsRUFBRTtFQUNoQixVQUFVLEVBQUU7SUFDUixRQUFRLEVBQUUsRUFBRTtJQUNaLFNBQVMsRUFBRTtFQUNmLENBQUM7RUFDRCxpQkFBaUIsRUFBRSxTQUFuQkMsZUFBaUJBLENBQUEsRUFBYztJQUMzQkMsWUFBWSxDQUFDLENBQUM7RUFDbEIsQ0FBQztFQUNEQyxHQUFHLEVBQUUsU0FBUztFQUNkQyxVQUFVLEVBQUU7SUFDUixVQUFVLEVBQUU7RUFDaEIsQ0FBQztFQUNEQyxPQUFPLEVBQUUsQ0FDTDtJQUNJUixNQUFNLEVBQUUsS0FBSztJQUNiUyxLQUFLLEVBQUUsc0JBQXNCO0lBQzdCQyxTQUFTLEVBQUU7RUFDZixDQUFDO0FBRVQsQ0FBQyxDQUFDO0FBRUYsU0FBU0wsWUFBWUEsQ0FBQSxFQUFHO0VBQ3BCTixDQUFDLENBQUMsMEJBQTBCLENBQUMsQ0FBQ1ksUUFBUSxDQUFDLGNBQWMsQ0FBQztFQUN0RFosQ0FBQyxDQUFDLDBCQUEwQixDQUFDLENBQUNhLElBQUksQ0FBQyxhQUFhLEVBQUUsUUFBUSxDQUFDO0FBQy9EIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9jdXN0b20vY3VzdG9tLWRhdGF0YWJsZS5qcz85YzU4Il0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcblxuJC5leHRlbmQoJC5mbi5kYXRhVGFibGUuZGVmYXVsdHMsIHtcbiAgICAncGFnaW5nJzogdHJ1ZSxcbiAgICAnaW5mbyc6IHRydWUsXG4gICAgJ29yZGVyaW5nJzogdHJ1ZSxcbiAgICAnYXV0b1dpZHRoJzogZmFsc2UsXG4gICAgJ3BhZ2VMZW5ndGgnOiAxMCxcbiAgICAnbGFuZ3VhZ2UnOiB7XG4gICAgICAgICdzZWFyY2gnOiAnJyxcbiAgICAgICAgJ3NTZWFyY2gnOiAnU2VhcmNoJyxcbiAgICB9LFxuICAgIFwicHJlRHJhd0NhbGxiYWNrXCI6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgY3VzdG9tU2VhcmNoKClcbiAgICB9LFxuICAgIGRvbTogJ2xCZnJ0aXAnLFxuICAgIHRhYmxlVG9vbHM6IHtcbiAgICAgICAgXCJzU3dmUGF0aFwiOiBcIm1lZGlhL3N3Zi9jb3B5X2Nzdl94bHNfcGRmLnN3ZlwiXG4gICAgfSxcbiAgICBidXR0b25zOiBbXG4gICAgICAgIHtcbiAgICAgICAgICAgIGV4dGVuZDogJ2NzdicsXG4gICAgICAgICAgICB0aXRsZTogJ1Byb2plY3RSIERhdGEgRXhwb3J0JyxcbiAgICAgICAgICAgIGNsYXNzTmFtZTogJ2J0biBidG4tcHJpbWFyeSdcbiAgICAgICAgfSxcbiAgICBdLFxufSk7XG5cbmZ1bmN0aW9uIGN1c3RvbVNlYXJjaCgpIHtcbiAgICAkKCcuZGF0YVRhYmxlc19maWx0ZXIgaW5wdXQnKS5hZGRDbGFzcyhcImZvcm0tY29udHJvbFwiKTtcbiAgICAkKCcuZGF0YVRhYmxlc19maWx0ZXIgaW5wdXQnKS5hdHRyKFwicGxhY2Vob2xkZXJcIiwgXCJTZWFyY2hcIik7XG59XG4iXSwibmFtZXMiOlsiJCIsImV4dGVuZCIsImZuIiwiZGF0YVRhYmxlIiwiZGVmYXVsdHMiLCJwcmVEcmF3Q2FsbGJhY2siLCJjdXN0b21TZWFyY2giLCJkb20iLCJ0YWJsZVRvb2xzIiwiYnV0dG9ucyIsInRpdGxlIiwiY2xhc3NOYW1lIiwiYWRkQ2xhc3MiLCJhdHRyIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/js/custom/custom-datatable.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/custom/custom-datatable.js"]();
/******/ 	
/******/ })()
;