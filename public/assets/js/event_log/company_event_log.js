/******/
(() => { // webpackBootstrap
    /******/
    "use strict";
    var __webpack_exports__ = {};
    /*!****************************************************************!*\
      !*** ./resources/assets/js/email_templates/email_templates.js ***!
      \****************************************************************/


    var tableName = '#eventCompanyLogTbl';
    $(tableName).DataTable({

        processing: true,
        serverSide: true,
        'order': [[0, 'desc']],
        ajax: {
            url: eventLogUrl
        },
        columnDefs: [
            {
                'targets': [0]
            },
            {
                'targets': [1],
                'className': 'text-left',
                'orderable': true,
                'width': '40%'
            },

            {
                targets: '_all',
                defaultContent: '-'
            }],
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'description',
                name: 'description'
            },

            {
                data: 'causer_user',
                name: 'causer_user'
            },
            // {
            //     data: function data(row) {
            //         let data = row.properties
            //         data = data.replace('[', '');
            //         data = data.replace('}', '');
            //         data = data.replace('{', '');
            //         data = data.replace(']', '');
            //         if(data!==""){
            //             return "ID : " + data;
            //         }
            //         return "";
            //
            //     },
            //     name: 'properties',
            // },
            {
                data: '_created_at',
                name: '_created_at'
            },
            // {
            //     data: function data(row) {
            //         var url = emailTemplateUrl + '/' + row.id;
            //         var data = [{
            //             'url': url + '/edit'
            //         }];
            //         return prepareTemplateRender('#eventLog', data);
            //     },
            //     name: 'id'
            // }
        ]
    });
    /******/
})()
;

