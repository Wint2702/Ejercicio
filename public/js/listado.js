
$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function (e) {

        $('#nombre, #folio, #telefono, #rfc, #calle, #numero, #colonia, #codigo_postal').text('');
        $('#descargaDocumentos').hide();
        $('#tituloModal').text("");
    });


    $('.verProspecto').on('click', function (e) {
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
            }
        });
        $('#modalForms').modal('show');
        $('#tituloModal').text("Ver prospecto");

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


    
});




