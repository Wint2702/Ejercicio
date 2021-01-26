
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




