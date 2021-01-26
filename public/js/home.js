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
        console.log('hemlo');
        prospecto = {
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

        $('form input[type=text], input[type=number], input[type=file]').prop('value', '');
        $('#descargaDocumentos, #btnBorrar').hide();
        $('#tituloModal').text("");
        $('#formProspecto').attr('action', '');


    });

    $(document).on('click', '.editProspecto', function (e) {
        e.preventDefault();
        prospecto.mode = 2;

        $.ajax({
            type: "GET",
            url: "/prospectos/listado/ver/" + $(this).data('id'),
            success: function (data) {
                console.log(data);

                prospecto = data;
                $('#nombre').val(prospecto.data.nombre);
                $('#primer_apellido').val(prospecto.data.primer_apellido);
                $('#segundo_apellido').val(prospecto.data.segundo_apellido ? prospecto.data.segundo_apellido : "");
                $('#telefono').val(prospecto.data.telefono);
                $('#rfc').val(prospecto.data.rfc);
                $('#calle').val(prospecto.data.calle);
                $('#numero').val(prospecto.data.numero);
                $('#colonia').val(prospecto.data.colonia);
                $('#codigo_postal').val(prospecto.data.codigo_postal);

                if (prospecto.data.documentosUrl) {
                    $('#descargaDocumentos').show();
                    $('#descargaDocumentos').attr('href', prospecto.data.documentosUrl);
                }

                $('#modalForms').modal('show');
                $('#storeProspecto, #guardarProspecto').removeClass('d-none');
                $('#tituloModal').text("Editar prospecto");
                $('#formProspecto').attr('action', prospecto.data.updateUrl);
                $('#btnBorrar').data('url', prospecto.data.deleteUrl).show();
            }
        });

    });

    $('#btnBorrar').on('click', function (e) {
        if (confirm('Seguro que deseas borrar este prospecto?')) {
            $.ajax({
                type: "GET",
                url: $(this).data('url'),
                success: function (data) {
                    $('#modalForms').modal('hide');
                    location.reload();
                }
            });
        }
    });

    $('#filtroProspectos').on('change', function (e) {
        if ($(e.currentTarget).val() == '*') {
            $("#tbodyProspectos tr").css('display', '');
        } else {
            $("#tbodyProspectos tr").filter(function () {
                var value = $(e.currentTarget).val();
                $(this).toggle($(this).text().indexOf(value) > -1)
            });
        }
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

                $('#modalForms').modal('show');
                $('#storeProspecto, #guardarProspecto').removeClass('d-none');
                $('#tituloModal').text("Evaluar prospecto");
                $('#formProspecto').attr('action', prospecto.data.updateUrl);
            }
        });

    });
    
});





$(document).on('click', '#createProspecto', function (e) {
    // console.log(e.currentTarget);
    prospecto.mode = 1;
    $('#modalForms').modal('show');
    $('#storeProspecto, #guardarProspecto').removeClass('d-none');
    $('#tituloModal').text("Nuevo prospecto");
    $('#formProspecto').data('url', '/prospectos/listado/crear');
    $('#formProspecto').attr('action', '/prospectos/listado/crear');

});


$('#formProspecto').submit(function (e) {
    let formData = new FormData($(e.currentTarget)[0]);
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).data('url'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            alert(data.message);
        }
    });
});


console.log('a');