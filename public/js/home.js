dayjs.locale("es");

let captions = {
    button: "seleccionar",
    feedback: "seleccione los archivos",
    feedback2: "Archivos fueron seleccionados",
    removeConfirmation: "¿Estas seguro que quieres quitar este archivo?",
    errors: {
        filesLimit: "Solo es permitido seleccionar {{fi-limit}} archivos para subir.",
        filesType: "Solo se permiten documentos de word o pdf.",
        filesSize: "¡{{fi-name}} es demasiado grande! El tamaño maximo para los archivos es de {{fi-fileMaxSize}} MB.",
        filesSizeAll: "¡El tamaño total de todos los archivos que intentas subir es muy grande! El espacio maximo de subida es de {{fi-maxSize}} MB.",
        folderUpload: "No se permite subir carpetas."
    }
};

let rulesMultiAll ={
    fileMaxSize: 50,
    maxSize:300,
    extensions: ["pdf", "docx", "doc","zip","xls","xlsx"],
    showThumbs: true,
    addMore: true,
    captions: captions    
};


$(document).ready(function () {
    console.log("hola");
    // $('#documentos').filer(rulesMultiAll);
});
let tablaProspectos = $('#tablaProspectos').DataTable({
    "ajax": $('#tablaProspectos').data('url'),
    "order": [[ 5, 'desc' ]],
    columns: [
        {data: "id" },
        {data: "nombre" , render : function (data,type,row,meta) {
            return `<button class="btn btn-link editProspecto" data-id="${row.id}">${data}</button>`;
        }},
        { data: 'primer_apellido'},
        { data: 'segundo_apellido'},
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

let prospecto = {
    mode:0,//create = 1, edit 2, read = 3
    id:null,
    nombre:null,
    primer_apellido:null,
    segundo_apellido:null,
    calle:null,
    numero:null,
    colonia:null,
    codigo_postal:null,
    telefono:null,
    rfc:null,
    deleteUrl:null,
    updateUrl:null,
    getUrl:null
};

$(document).on('click','#createProspecto',function(e) {
    // console.log(e.currentTarget);
    prospecto.mode = 1;
    $('#modalForms').modal('show');
    $('#storeProspecto, #guardarProspecto').removeClass('d-none');
    $('#tituloModal').text("Nuevo prospecto");
    $('#formProspecto').attr('action','/prospectos/listado/crear');
});

$('#formProspecto').on('submit', function (e) {
    let formData = new FormData($(e.currentTarget)[0]);
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            alert(data.message);
        }
    });  
});
