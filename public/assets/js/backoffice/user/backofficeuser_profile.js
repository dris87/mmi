/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************************************!*\
  !*** ./resources/assets/js/backoffice/user/backofficeuser_profile.js ***!
  \***********************************************************************/
$(document).ready(function () {
  $('#positionId').select2({
    width: '100%',
    ajax: {
      url: select2BackofficePositionsUrl,
      dataType: 'json',
      processResults: function processResults(data) {
        return {
          results: $.map(data, function (obj) {
            return {
              text: obj.text,
              id: obj.id
            };
          })
        };
      }
    }
  });
  $('#branchOfficeId').select2({
    width: '100%',
    ajax: {
      url: select2BackofficeBranchOfficesUrl,
      dataType: 'json',
      processResults: function processResults(data) {
        return {
          results: $.map(data, function (obj) {
            return {
              text: obj.text,
              id: obj.id
            };
          })
        };
      }
    }
  });
  $('#superiorId').select2({
    width: '100%',
    ajax: {
      url: select2BackofficeSuperiorsUrl,
      dataType: 'json',
      processResults: function processResults(data) {
        return {
          results: $.map(data, function (obj) {
            return {
              text: obj.text,
              id: obj.id
            };
          })
        };
      }
    }
  });

  window.renderProfileData = function () {

      console.log("backofficeProfileUrl fill");
    $.ajax({
      url: backofficeProfileUrl,
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          var user = result.data;
          $('#editUserId').val(user.user_id);
          $('#firstName').val(user.first_name);
          $('#lastName').val(user.last_name);
          $('#userEmail').val(user.email);
          $('#profilePhone').val(user.phone);
          $('#notifiedName').val(user.notified_name);
          $('#notifiedPhone').val(user.notified_phone);
          $('#dateOfBirth').val(user.dob);

          if (user.position) {
            var option = new Option(user.position.name, user.position.id, true, true);
            $('#positionId').append(option).trigger('change');
          }

          if (user.branch_office) {
            var option = new Option(user.branch_office.name, user.branch_office.id, true, true);
            $('#branchOfficeId').append(option).trigger('change');
          }

          if (user.superior) {
            var superiorName = user.superior.first_name + " " + user.superior.last_name;
            var option = new Option(superiorName, user.superior.id, true, true);
            $('#superiorId').append(option).trigger('change');
          }

          $('#editProfileModal').appendTo('body').modal('show');
        }
      }
    });
  };
});
/******/ })()
;
