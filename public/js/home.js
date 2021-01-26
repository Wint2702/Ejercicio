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


// funcion estandar al enviar un form
$('form').not('#formFiltrarTareas, #formGenerarReporte, #formListaMetas, #filtroInforme, #formListaTareasDepto').on('submit', function(e) {
    e.preventDefault();    
    setSubmit(e);
});

function setSubmit(e) {
    audioAlert.init();
    // //pone en read only los campos
    // $(e.currentTarget).find('input,textarea').not('input[type=submit], input[type=reset], input[type=button]').each((k,v)=>{
    //     $(v).prop('readonly', true);
    // });
    // //desabilita los botones
    // $(e.currentTarget).find('input[type=submit], input[type=reset], input[type=button]').each((k,v)=>{
    //     $(v).prop('disabled', true);
    // });

    if(typeof moneyInputs !== 'undefined') moneyInputs.forEach(element => { element.unformat(); });
    // ejecuta alguna funcion especificada para antes del formulario
    if (typeof prevActions == 'function') prevActions(e.currentTarget);
    let formData = new FormData($(e.currentTarget)[0]);
    let url = $(e.currentTarget).data('url');
    saveData(formData, url, e.currentTarget);
}


function saveData(formData ,url, target) {
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: (data)=> {
            if(data.message !== undefined) {
                if(data.button !== undefined && data.link !== undefined) {
                    notify.success({msj:data.message, button:data.button, link:data.link});
                } else {
                    notify.success({msj:data.message});
                }
            }
            if (typeof successActions == 'function') successActions(target,data);
            audioAlert.success();
        },
        error: (error)=> {
            // notify.danger({msj:error.responseJSON.message,list:error.responseJSON.errors});
            // audioAlert.error();
        },
        statusCode: {
            401: (error) => {
                notify.warning({msj:error.responseJSON.message,list:error.responseJSON.errors});
                audioAlert.info();
            },
            409: (error) => {
                notify.warning({msj:error.responseJSON.message,list:error.responseJSON.errors});
                audioAlert.info();
            },
            409: (error) => {
                notify.warning({msj:'Ocurrio un error inesperado, por favor recarga la pagina y vuevle a intentarlo, si el error persiste ponte en contacto con el area de sistemas y muestrale la siguiente info: '+error.responseJSON.message,list:error.responseJSON.errors});
                audioAlert.info();
            },
            500: (error) => {
                notify.danger({msj:error.responseJSON.message,list:error.responseJSON.errors});
                audioAlert.error();
            },
            422: (error) => {
                notify.danger({msj:error.responseJSON.message,list:error.responseJSON.errors});
                audioAlert.error();
            }
        },
        complete: ()=> {
            $(target).find('input,textarea').not('input[type=submit], input[type=reset], input[type=button], input[name="urlDocumento"]').each((k,v)=>{
                $(v).removeAttr('readonly');
            });
            $(target).find('input[type=submit], input[type=reset], input[type=button]').each((k,v)=>{
                $(v).removeAttr('disabled');
            });

            if(typeof moneyInputs !== 'undefined') moneyInputs.forEach(element => {element.reformat();});
            if( $(target).prop('id') == 'formEditarTarea' )$('#fecha').prop('readonly','true');
        }
    });
}

let tablaProspectos = $('#tablaProspectos').DataTable(
    {
        serverSide: true,
        "ajax": {
            url:$('#tablaProspectos').data('url'),
            type: 'GET',
        },
        "order": [[ 0, 'desc' ]],
        columns: [
            {data: "id" },
            {data: "nombre" , render : function (data,type,row,meta) {
                return `<button class="btn btn-link editProspecto" data-id="${row.id}">${data}</button>`;
            }},
            { data: 'primer_apellido'},
            { data: 'segundo_apellido',"defaultContent": "<span class='text-muted'>No completado</span>" },
            { data:'created_at'},
            { data: 'estatus'}
        ]
    }
);
// $('#documentos').filer(rulesMultiAll);
$(document).ready(function () {

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
    $('#formProspecto').data('url','prospectos/listado/crear');
});

// $('#guardarProspecto').on('click', function (e) {
//     e.preventDefault();
// });


// $('#formProspecto').submit(function (e) {
//     let formData = new FormData($(e.currentTarget)[0]);
//     e.preventDefault();
//     $.ajax({
//         type: "POST",
//         url: $(this).data('url'),
//         data: formData,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (data) {
//             alert(data.message);
//         }
//     });  
// });

// function preventDefaultfn(e) {
//     e.preventDefault(); 
// }