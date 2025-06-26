/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./resources/assets/js/dashboard/create-edit.js ***!
  \******************************************************/
$(document).ready(function () {
  'use strict';

  $('#extra_permission_ids').select2({
    width: 'calc(100% - 44px)',
    multiple: true
  });

  $('#createCandidatesForm,#editCandidatesForm').submit(function () {
    if ($('#error-msg').text() !== '') {
      $('#phoneNumber').focus();
      return false;
    }
  });
  $(document).on('submit', '#createCandidatesForm,#editCandidatesForm', function (e) {
    e.preventDefault();
    return true;
  });
});
/******/ })()
;
