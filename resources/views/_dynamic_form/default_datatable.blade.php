<table id="{{ $table['id']}}" class="table table-responsive-sm table-striped table-bordered">
    <thead>
    <tr>
        @foreach($table['columns'] as $column)
            <th scope="col">{{ __($column['title']) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    const config = {
        processing: true,
        serverSide: true,
        'order': [[0, 'asc']],
        ajax: {
            url: dataTableUrl,
            data: function (data) {
                data.filter1 = 'teszt';
                console.log(data);
                console.log('asd');
            },
            dataSrc: function(json){
                if(json.data)
                    return json.data;
                else
                    return [];
            },

        },
        columnDefs: [
            {
                'targets': [0]
            },
            {
                'targets': [1],
                'className': 'text-center',
                'orderable': true,
                'width': '10%'
            },
            {
                'targets': [5],
                'type': 'date'
            },
            {
                targets: '_all',
                defaultContent: '-'
            }
        ],
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: function (row) {
                    if (row.name && row.branch_office) {
                        return prepareTemplateRender('#backoffice-name', [{
                            name: row.name,
                            branchOffice: row.branch_office
                        }]);
                    }
                },
                name: 'name'
            },
            {
                data: 'position',
                name: 'position',
                className: 'text-center'
            },
            {
                data: function (row) {
                    if (row.email && row.phone) {
                        return prepareTemplateRender('#backoffice-contact', [{
                            email: row.email,
                            phone: row.phone
                        }]);
                    }
                },
                name: 'contact',
                className: 'text-center'
            },
            {
                data: function (row) {
                    if (row.main_permission || row.extra_permissions) {
                        var permissions = [];
                        if (row.extra_permissions) {
                            permissions = row.extra_permissions.split(',');
                        }
                        return prepareTemplateRender('#backoffice-permissions', [{
                            mainPermission: row.main_permission,
                            permissions: permissions
                        }]);
                    }
                },
                name: 'superior',
                className: 'text-center'
            },
            {
                data: function (row) {
                    if (row.superior_name && row.superior_position) {
                        return prepareTemplateRender('#backoffice-superior', [{
                            superiorName: row.superior_name,
                            superiorPosition: row.superior_position
                        }]);
                    }
                },
                name: 'superior',
                className: 'text-center'
            },
            {
                data: function (row) {
                    return row.is_active
                        ? Lang.get('messages.backoffice.user.active')
                        : Lang.get('messages.backoffice.user.inactive');
                },
                name: 'is_active',
                className: 'text-center'
            },
            {
                data: function data(row) {
                    return prepareTemplateRender('#backoffice-options', {
                        onClick: `passwordChange2(${row.id}, '${row.email}')`
                    });
                },
                name: 'id'
            }]
    };

    initialiseDatatable(
        $(tableName),
        dataTableUrl,
        config,
        Lang.get('messages.candidates_table.filename')
    );

</script>
