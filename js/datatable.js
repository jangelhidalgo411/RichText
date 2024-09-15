var DT = new DataTable('#DataTable', {
	deferRender: true,
	ajax: {
		url: './db/getusers.php',
		type: 'POST'
	},
	order: [[0, 'asc']],
	columns: [
		{
			data: 'Id',
			orderable: true,
			width: '5%',
			searchable: false
		},
		{
			data: 'Name',
			orderable: true,
			width: '15%',
			searchable: false
		},
		{
			data: 'Email',
			orderable: true,
			width: '15%',
			searchable: false
		},
		{
			data: 'Password',
			orderable: false,
			visible: false,
			searchable: false
		},
		{
			data: 'ConfirmPassword',
			orderable: false,
			visible: false,
			searchable: false
		},
		{
			data: 'Role',
			orderable: true,
			width: '5%',
			searchable: false
		},
		{
			data: 'Active',
			orderable: true,
			width: '5%',
			searchable: false
		},
		{
			data: 'CreatedAt',
			orderable: true,
			width: '10%',
			searchable: false
		},
		{
			data: 'UpdatedAt',
			orderable: true,
			width: '10%',
			searchable: false
		},
		{
			data: null,
			orderable: false,
			width: '15%',
			render: function ( data, type, row ) {
				return '<button class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target="#EditModal" onclick="Edit(\''+row.Id+'\',\''+row.Name+'\',\''+row.Email+'\','+row.Role+','+row.Active+');">Editar</button>'+
						'<button class="btn btn-danger" onclick="Delete(' + row.Id + ');">Borrar</button>'
			},
			visible: true
		}
	],
	select: true,
	serverSide: true,
	processing: true,
	autoWidth: true,
	lengthMenu: [
		[ 10, 25, 50, 50000], 
		[ 10, 25, 50, 'ALL']
	],
	pageLength: 10,
});