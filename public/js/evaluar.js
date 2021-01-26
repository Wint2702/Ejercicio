let prospecto = {
    mode: 0, //create = 1, edit 2, read = 3
    id: null,
    nombre: null,
    primer_apellido: null,
    segundo_apellido: null,
    calle: null,
    numero: null,
    colonia: null,
    codigo_postal: null,
    telefono: null,
    rfc: null,
    deleteUrl: null,
    updateUrl: null,
    getUrl: null
};

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

let rulesMultiAll = {
    fileMaxSize: 50,
    maxSize: 300,
    extensions: ["pdf", "docx", "doc", "zip", "xls", "xlsx"],
    showThumbs: true,
    addMore: true,
    captions: captions
};


$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function (e) {

        $('#nombre, #folio, #telefono, #rfc, #calle, #numero, #colonia, #codigo_postal').text('');
        $('#descargaDocumentos').hide();
        $('#tituloModal').text("");
        $('#btnAprobarProspecto').data('url', "");
        $('#btnRechazarProspecto').data('url', "");
    });


    $('.evaluarProspecto').on('click', function (e) {
        e.preventDefault();
        prospecto.mode = 3;

        $.ajax({
            type: "GET",
            url: "/prospectos/listado/ver/" + $(this).data('id'),
            success: function (data) {
                console.log(data);

                prospecto = data;
                $('#nombre').text(prospecto.data.nombre + " " + prospecto.data.primer_apellido + (prospecto.data.segundo_apellido? " " + prospecto.data.segundo_apellido : ""));
                $('#folio').text(prospecto.data.id);
                $('#telefono').text(prospecto.data.telefono);
                $('#rfc').text(prospecto.data.rfc);
                $('#calle').text(prospecto.data.calle);
                $('#numero').text(prospecto.data.numero);
                $('#colonia').text(prospecto.data.colonia);
                $('#codigo_postal').text(prospecto.data.codigo_postal);

                if (prospecto.data.documentosUrl) {
                    $('#descargaDocumentos').show();
                    $('#descargaDocumentos').attr('href', prospecto.data.documentosUrl);
                }

                $('#btnAprobarProspecto').data('url', prospecto.data.aprobarUrl);
                $('#btnRechazarProspecto').data('url', prospecto.data.rechazarUrl);

            }
        });
        $('#modalForms').modal('show');
        $('#tituloModal').text("Evaluar prospecto");

    });


    $('#btnAprobarProspecto').on('click', function (e) {
        if(confirm("¿Está seguro de que desea aprobar este prospecto?")){
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function (data) {
                    $('#modalForms').modal('hide');
                    location.reload();
                }
            });
        }
    });

    $('#btnRechazarProspecto').on('click', function (e) {
        if(confirm("¿Está seguro de que desea rechazar este prospecto?")){
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                dataType: "json",
                success: function (data) {
                    $('#modalForms').modal('hide');
                    location.reload();
                }
            });
        }
    });
    
});




