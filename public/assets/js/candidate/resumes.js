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

/***/ "./resources/assets/js/candidate/resumes.js":
/*!**************************************************!*\
  !*** ./resources/assets/js/candidate/resumes.js ***!
  \**************************************************/
/***/ (() => {

eval("\n\n$(document).on('click', '.delete-btn', function (event) {\n  var resumeId = $(event.currentTarget).attr('data-id');\n  swal({\n    title: Lang.get('messages.common.delete'),\n    text: Lang.get('messages.common.are_you_sure_want_to_delete') + '\"' + Lang.get('messages.apply_job.resume') + '\" ?',\n    type: 'warning',\n    showCancelButton: true,\n    closeOnConfirm: false,\n    showLoaderOnConfirm: true,\n    confirmButtonColor: '#6777ef',\n    cancelButtonColor: '#d33',\n    cancelButtonText: Lang.get('messages.common.no'),\n    confirmButtonText: Lang.get('messages.common.yes')\n  }, function () {\n    window.livewire.emit('deleteCandidateResume', resumeId);\n  });\n});\ndocument.addEventListener('delete', function () {\n  swal({\n    title: Lang.get('messages.common.deleted'),\n    text: Lang.get('messages.common.has_been_deleted'),\n    type: 'success',\n    confirmButtonColor: '#6777ef',\n    timer: 2000\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL2NhbmRpZGF0ZS9yZXN1bWVzLmpzIiwibWFwcGluZ3MiOiJBQUFhOztBQUViQSxDQUFDLENBQUNDLFFBQVEsQ0FBQyxDQUFDQyxFQUFFLENBQUMsT0FBTyxFQUFFLGFBQWEsRUFBRSxVQUFVQyxLQUFLLEVBQUU7RUFDcEQsSUFBSUMsUUFBUSxHQUFHSixDQUFDLENBQUNHLEtBQUssQ0FBQ0UsYUFBYSxDQUFDLENBQUNDLElBQUksQ0FBQyxTQUFTLENBQUM7RUFDckRDLElBQUksQ0FBQztJQUNHQyxLQUFLLEVBQUVDLElBQUksQ0FBQ0MsR0FBRyxDQUFDLHdCQUF3QixDQUFDO0lBQ3pDQyxJQUFJLEVBQUVGLElBQUksQ0FBQ0MsR0FBRyxDQUFDLDZDQUE2QyxDQUFDLEdBQUcsR0FBRyxHQUFHRCxJQUFJLENBQUNDLEdBQUcsQ0FBQywyQkFBMkIsQ0FBQyxHQUFHLEtBQUs7SUFDbkhFLElBQUksRUFBRSxTQUFTO0lBQ2ZDLGdCQUFnQixFQUFFLElBQUk7SUFDdEJDLGNBQWMsRUFBRSxLQUFLO0lBQ3JCQyxtQkFBbUIsRUFBRSxJQUFJO0lBQ3pCQyxrQkFBa0IsRUFBRSxTQUFTO0lBQzdCQyxpQkFBaUIsRUFBRSxNQUFNO0lBQ3pCQyxnQkFBZ0IsRUFBRVQsSUFBSSxDQUFDQyxHQUFHLENBQUMsb0JBQW9CLENBQUM7SUFDaERTLGlCQUFpQixFQUFFVixJQUFJLENBQUNDLEdBQUcsQ0FBQyxxQkFBcUI7RUFDckQsQ0FBQyxFQUNELFlBQVk7SUFDUlUsTUFBTSxDQUFDQyxRQUFRLENBQUNDLElBQUksQ0FBQyx1QkFBdUIsRUFBRWxCLFFBQVEsQ0FBQztFQUMzRCxDQUFDLENBQUM7QUFDVixDQUFDLENBQUM7QUFFRkgsUUFBUSxDQUFDc0IsZ0JBQWdCLENBQUMsUUFBUSxFQUFFLFlBQVk7RUFDNUNoQixJQUFJLENBQUM7SUFDREMsS0FBSyxFQUFFQyxJQUFJLENBQUNDLEdBQUcsQ0FBQyx5QkFBeUIsQ0FBQztJQUMxQ0MsSUFBSSxFQUFFRixJQUFJLENBQUNDLEdBQUcsQ0FBQyxrQ0FBa0MsQ0FBQztJQUNsREUsSUFBSSxFQUFFLFNBQVM7SUFDZkksa0JBQWtCLEVBQUUsU0FBUztJQUM3QlEsS0FBSyxFQUFFO0VBQ1gsQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9jYW5kaWRhdGUvcmVzdW1lcy5qcz85MTBlIl0sInNvdXJjZXNDb250ZW50IjpbIid1c2Ugc3RyaWN0JztcblxuJChkb2N1bWVudCkub24oJ2NsaWNrJywgJy5kZWxldGUtYnRuJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgbGV0IHJlc3VtZUlkID0gJChldmVudC5jdXJyZW50VGFyZ2V0KS5hdHRyKCdkYXRhLWlkJyk7XG4gICAgc3dhbCh7XG4gICAgICAgICAgICB0aXRsZTogTGFuZy5nZXQoJ21lc3NhZ2VzLmNvbW1vbi5kZWxldGUnKSAsXG4gICAgICAgICAgICB0ZXh0OiBMYW5nLmdldCgnbWVzc2FnZXMuY29tbW9uLmFyZV95b3Vfc3VyZV93YW50X3RvX2RlbGV0ZScpICsgJ1wiJyArIExhbmcuZ2V0KCdtZXNzYWdlcy5hcHBseV9qb2IucmVzdW1lJykgKyAnXCIgPycsXG4gICAgICAgICAgICB0eXBlOiAnd2FybmluZycsXG4gICAgICAgICAgICBzaG93Q2FuY2VsQnV0dG9uOiB0cnVlLFxuICAgICAgICAgICAgY2xvc2VPbkNvbmZpcm06IGZhbHNlLFxuICAgICAgICAgICAgc2hvd0xvYWRlck9uQ29uZmlybTogdHJ1ZSxcbiAgICAgICAgICAgIGNvbmZpcm1CdXR0b25Db2xvcjogJyM2Nzc3ZWYnLFxuICAgICAgICAgICAgY2FuY2VsQnV0dG9uQ29sb3I6ICcjZDMzJyxcbiAgICAgICAgICAgIGNhbmNlbEJ1dHRvblRleHQ6IExhbmcuZ2V0KCdtZXNzYWdlcy5jb21tb24ubm8nKSxcbiAgICAgICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiBMYW5nLmdldCgnbWVzc2FnZXMuY29tbW9uLnllcycpLFxuICAgICAgICB9LFxuICAgICAgICBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB3aW5kb3cubGl2ZXdpcmUuZW1pdCgnZGVsZXRlQ2FuZGlkYXRlUmVzdW1lJywgcmVzdW1lSWQpO1xuICAgICAgICB9KTtcbn0pO1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdkZWxldGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgc3dhbCh7XG4gICAgICAgIHRpdGxlOiBMYW5nLmdldCgnbWVzc2FnZXMuY29tbW9uLmRlbGV0ZWQnKSAsXG4gICAgICAgIHRleHQ6IExhbmcuZ2V0KCdtZXNzYWdlcy5jb21tb24uaGFzX2JlZW5fZGVsZXRlZCcpLFxuICAgICAgICB0eXBlOiAnc3VjY2VzcycsXG4gICAgICAgIGNvbmZpcm1CdXR0b25Db2xvcjogJyM2Nzc3ZWYnLFxuICAgICAgICB0aW1lcjogMjAwMCxcbiAgICB9KTtcbn0pO1xuIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsIm9uIiwiZXZlbnQiLCJyZXN1bWVJZCIsImN1cnJlbnRUYXJnZXQiLCJhdHRyIiwic3dhbCIsInRpdGxlIiwiTGFuZyIsImdldCIsInRleHQiLCJ0eXBlIiwic2hvd0NhbmNlbEJ1dHRvbiIsImNsb3NlT25Db25maXJtIiwic2hvd0xvYWRlck9uQ29uZmlybSIsImNvbmZpcm1CdXR0b25Db2xvciIsImNhbmNlbEJ1dHRvbkNvbG9yIiwiY2FuY2VsQnV0dG9uVGV4dCIsImNvbmZpcm1CdXR0b25UZXh0Iiwid2luZG93IiwibGl2ZXdpcmUiLCJlbWl0IiwiYWRkRXZlbnRMaXN0ZW5lciIsInRpbWVyIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/js/candidate/resumes.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/js/candidate/resumes.js"]();
/******/ 	
/******/ })()
;