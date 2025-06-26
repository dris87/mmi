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

/***/ "./resources/assets/js/email_templates/email_templates.js":
/*!****************************************************************!*\
  !*** ./resources/assets/js/email_templates/email_templates.js ***!
  \****************************************************************/
/***/ (() => {

eval("\n\nvar tableName = '#emailTemplateTbl';\n$(tableName).DataTable({\n  processing: true,\n  serverSide: true,\n  'order': [[0, 'desc']],\n  ajax: {\n    url: emailTemplateUrl\n  },\n  columnDefs: [{\n    'targets': [0]\n  }, {\n    'targets': [1],\n    'className': 'text-center',\n    'orderable': false,\n    'width': '10%'\n  }, {\n    targets: '_all',\n    defaultContent: 'N/A'\n  }],\n  columns: [{\n    data: 'template_name',\n    name: 'template_name'\n  }, {\n    data: function data(row) {\n      var url = emailTemplateUrl + '/' + row.id;\n      var data = [{\n        'url': url + '/edit'\n      }];\n      return prepareTemplateRender('#emailTemplate', data);\n    },\n    name: 'id'\n  }]\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL2VtYWlsX3RlbXBsYXRlcy9lbWFpbF90ZW1wbGF0ZXMuanMiLCJtYXBwaW5ncyI6IkFBQWE7O0FBQ2IsSUFBSUEsU0FBUyxHQUFHLG1CQUFtQjtBQUNuQ0MsQ0FBQyxDQUFDRCxTQUFTLENBQUMsQ0FBQ0UsU0FBUyxDQUFDO0VBQ25CQyxVQUFVLEVBQUUsSUFBSTtFQUNoQkMsVUFBVSxFQUFFLElBQUk7RUFDaEIsT0FBTyxFQUFFLENBQUMsQ0FBQyxDQUFDLEVBQUUsTUFBTSxDQUFDLENBQUM7RUFDdEJDLElBQUksRUFBRTtJQUNGQyxHQUFHLEVBQUVDO0VBQ1QsQ0FBQztFQUNEQyxVQUFVLEVBQUUsQ0FDUjtJQUNJLFNBQVMsRUFBRSxDQUFDLENBQUM7RUFDakIsQ0FBQyxFQUNEO0lBQ0ksU0FBUyxFQUFFLENBQUMsQ0FBQyxDQUFDO0lBQ2QsV0FBVyxFQUFFLGFBQWE7SUFDMUIsV0FBVyxFQUFFLEtBQUs7SUFDbEIsT0FBTyxFQUFFO0VBQ2IsQ0FBQyxFQUNEO0lBQ0lDLE9BQU8sRUFBRSxNQUFNO0lBQ2ZDLGNBQWMsRUFBRTtFQUNwQixDQUFDLENBQ0o7RUFDREMsT0FBTyxFQUFFLENBQ0w7SUFDSUMsSUFBSSxFQUFFLGVBQWU7SUFDckJDLElBQUksRUFBRTtFQUNWLENBQUMsRUFDRDtJQUNJRCxJQUFJLEVBQUUsU0FBTkEsSUFBSUEsQ0FBWUUsR0FBRyxFQUFFO01BQ2pCLElBQUlSLEdBQUcsR0FBR0MsZ0JBQWdCLEdBQUcsR0FBRyxHQUFHTyxHQUFHLENBQUNDLEVBQUU7TUFDekMsSUFBSUgsSUFBSSxHQUFHLENBQUM7UUFBRSxLQUFLLEVBQUVOLEdBQUcsR0FBRztNQUFRLENBQUMsQ0FBQztNQUNyQyxPQUFPVSxxQkFBcUIsQ0FBQyxnQkFBZ0IsRUFDekNKLElBQUksQ0FBQztJQUNiLENBQUM7SUFBRUMsSUFBSSxFQUFFO0VBQ2IsQ0FBQztBQUVULENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvZW1haWxfdGVtcGxhdGVzL2VtYWlsX3RlbXBsYXRlcy5qcz85NjM3Il0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcbmxldCB0YWJsZU5hbWUgPSAnI2VtYWlsVGVtcGxhdGVUYmwnO1xuJCh0YWJsZU5hbWUpLkRhdGFUYWJsZSh7XG4gICAgcHJvY2Vzc2luZzogdHJ1ZSxcbiAgICBzZXJ2ZXJTaWRlOiB0cnVlLFxuICAgICdvcmRlcic6IFtbMCwgJ2Rlc2MnXV0sXG4gICAgYWpheDoge1xuICAgICAgICB1cmw6IGVtYWlsVGVtcGxhdGVVcmwsXG4gICAgfSxcbiAgICBjb2x1bW5EZWZzOiBbXG4gICAgICAgIHtcbiAgICAgICAgICAgICd0YXJnZXRzJzogWzBdLFxuICAgICAgICB9LFxuICAgICAgICB7XG4gICAgICAgICAgICAndGFyZ2V0cyc6IFsxXSxcbiAgICAgICAgICAgICdjbGFzc05hbWUnOiAndGV4dC1jZW50ZXInLFxuICAgICAgICAgICAgJ29yZGVyYWJsZSc6IGZhbHNlLFxuICAgICAgICAgICAgJ3dpZHRoJzogJzEwJScsXG4gICAgICAgIH0sXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRhcmdldHM6ICdfYWxsJyxcbiAgICAgICAgICAgIGRlZmF1bHRDb250ZW50OiAnTi9BJyxcbiAgICAgICAgfSxcbiAgICBdLFxuICAgIGNvbHVtbnM6IFtcbiAgICAgICAge1xuICAgICAgICAgICAgZGF0YTogJ3RlbXBsYXRlX25hbWUnLFxuICAgICAgICAgICAgbmFtZTogJ3RlbXBsYXRlX25hbWUnLFxuICAgICAgICB9LFxuICAgICAgICB7XG4gICAgICAgICAgICBkYXRhOiBmdW5jdGlvbiAocm93KSB7XG4gICAgICAgICAgICAgICAgbGV0IHVybCA9IGVtYWlsVGVtcGxhdGVVcmwgKyAnLycgKyByb3cuaWQ7XG4gICAgICAgICAgICAgICAgbGV0IGRhdGEgPSBbeyAndXJsJzogdXJsICsgJy9lZGl0JyB9XTtcbiAgICAgICAgICAgICAgICByZXR1cm4gcHJlcGFyZVRlbXBsYXRlUmVuZGVyKCcjZW1haWxUZW1wbGF0ZScsXG4gICAgICAgICAgICAgICAgICAgIGRhdGEpO1xuICAgICAgICAgICAgfSwgbmFtZTogJ2lkJyxcbiAgICAgICAgfSxcbiAgICBdLFxufSk7XG4iXSwibmFtZXMiOlsidGFibGVOYW1lIiwiJCIsIkRhdGFUYWJsZSIsInByb2Nlc3NpbmciLCJzZXJ2ZXJTaWRlIiwiYWpheCIsInVybCIsImVtYWlsVGVtcGxhdGVVcmwiLCJjb2x1bW5EZWZzIiwidGFyZ2V0cyIsImRlZmF1bHRDb250ZW50IiwiY29sdW1ucyIsImRhdGEiLCJuYW1lIiwicm93IiwiaWQiLCJwcmVwYXJlVGVtcGxhdGVSZW5kZXIiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/assets/js/email_templates/email_templates.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/email_templates/email_templates.js"]();
/******/ 	
/******/ })()
;