$(document).ready(function () {
    $('#alerta').hide();
    $('#tabla_resultados').hide();
    $('#loader').hide();

    $("form").keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });

    function makeSPARQLQuery(endpointUrl, sparqlQuery, doneCallback) {
        var settings = {
            headers: {Accept: 'application/sparql-results+json'},
            data: {query: sparqlQuery}
        };
        return $.ajax(endpointUrl, settings).then(doneCallback);
    }

    $(document).on('click', '.btn_buscar', function () {

        if ($('#buscador').val() !== '') {
            $('#alerta').hide();
            $('#tabla_resultados').hide();
            $('#loader').show();
            var filtro = $('input[name=txt_buscador]').val().toLowerCase().replace(/\b[a-z]/g, function (letra) {
                return letra.toUpperCase();
            });

            $('#table-servicios').dataTable().fnDestroy();

            var endpointUrl = 'https://query.wikidata.org/sparql',
                    sparqlQuery = "SELECT DISTINCT ?item ?itemLabel ?itemDescription ?fec_nac ?miembro_del_partido_pol_ticoLabel WHERE {\n" +
                    "  ?item wdt:P106 wd:Q82955.\n" +
                    "  ?item (wdt:P19|wdt:P27) wd:Q298.\n" +
                    "  ?item wdt:P569 ?fec_nac.\n" +
                    "  ?item rdfs:label ?label.\n" +
                    "  OPTIONAL { ?item wdt:P69 ?edu. }\n" +
                    "  SERVICE wikibase:label { bd:serviceParam wikibase:language \"[AUTO_LANGUAGE],es\". }\n" +
                    "  FILTER(CONTAINS(?label, \"" + filtro + "\"))\n" +
                    "  OPTIONAL { ?item wdt:P102 ?miembro_del_partido_pol_tico. }\n" +
                    "}";

            makeSPARQLQuery(endpointUrl, sparqlQuery, function (data) {
                $('#loader').hide();
                $("#details").hide();
                $('#tabla_resultados').show();
                var cols = [];
                var ocupacion, fecha_nacimiento, partido_politico, vl_id = '';
                $.each(JSON.parse(JSON.stringify(data.results.bindings)), function (i, post) {
                    if (post.hasOwnProperty("item")) {
                        vl_id = post.item.value;
                        var n = vl_id.lastIndexOf("/");
                        vl_id = vl_id.substring(n + 1);
                        vl_id = '<center><a href="javascript:void(0)" class="btn btn-large btn-theme" data-id="' + vl_id + '" id="detalle">Ver Detalle</a></center>';
                    }
                    if (post.hasOwnProperty("itemDescription")) {
                        ocupacion = post.itemDescription.value;
                    } else {
                        ocupacion = '-';
                    }
                    if (post.hasOwnProperty("fec_nac")) {
                        var dateTime = moment(post.fec_nac.value);
                        fecha_nacimiento = dateTime.format('MM-DD-YYYY');
                    } else {
                        fecha_nacimiento = '-';
                    }

                    if (post.hasOwnProperty("miembro_del_partido_pol_ticoLabel")) {
                        partido_politico = post.miembro_del_partido_pol_ticoLabel.value;
                    } else {
                        partido_politico = '-';
                    }

                    cols.push({
                        nombre: post.itemLabel.value,
                        ocupacion: ocupacion,
                        fecha_nacimiento: fecha_nacimiento,
                        partido_politico: partido_politico,
                        id: vl_id
                    });
                });
                $('#table-servicios').dataTable({
                    "pageLength": 15,
                    "responsive": true,
                    "ordering": true,
                    "autoWidth": false,
                    "paging": true,
                    "searching": true,
                    "info": false,
                    "bLengthChange": false,
                    "data": cols,
                    "columns": [
                        {"data": "nombre"},
                        {"data": "ocupacion"},
                        {"data": "fecha_nacimiento"},
                        {"data": "partido_politico"},
                        {"data": "id"}
                    ]
                });
            }
            );
        } else {
            $('#tabla_resultados').hide();
            $('#alerta').show();
        }

    });
    $(document).on('click', '#detalle', function () {
        var id = $(this).attr("data-id");
        id = 'wd:' + id;
        $.ajax({
            beforeSend: function () {
                $("#tabla_resultados").hide();
                $('#loader').show();
            },
            type: 'POST',
            url: '/details',
            data: {wdCode: id}
        }).done(function (data) {
            $('#loader').hide();
            $("#details").empty().show().append(data);
        });
    });
});
