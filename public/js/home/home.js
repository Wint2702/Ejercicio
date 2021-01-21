dayjs.locale("es");

let tablaContactos = $('#tablaContactos').DataTable({
    "ajax": $('#tablaContactos').data('url'),
    "order": [[ 5, 'desc' ]],
    columns: [
        {data: "id" },
        {data: "nombre" , render : function (data,type,row,meta) {
            return `<button class="btn btn-link editContacto" data-id="${row.id}">${data}</button>`;
        }},
        { data: 'empresa',"defaultContent": "<span class='text-muted'>No completado</span>" },
        { data: 'telefono.telefono',"defaultContent": "<span class='text-muted'>No completado</span>" },
        { data: 'email',"defaultContent": "<span class='text-muted'>No completado</span>" },
        { data:'created_at',
            render: {
                _: data=>{return dayjs(data).format('DD/MMM/YYYY');},
                sort:data=>{return dayjs(data).format('YYYYMDHms');}
            }},
        { data: 'estatus'}
    ]
});

$('#createContacto').on('click',e=>{
    // console.log(e.currentTarget);
    contacto.mode = 1;
    $('#storeContacto, #saveContacto, #alert-telefonos').removeClass('d-none');
    $('#formContacto').data('url','/sire/comercial/prospectacion/cliente/guardar');
    $('#tituloModal').text("Crear contacto");
    $('#addPhone').show();
    // console.log($('form'));
    $('#modalForms').modal('show');
});