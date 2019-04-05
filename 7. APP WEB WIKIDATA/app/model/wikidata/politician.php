<?php

namespace model\wikidata;

class politician {

    public static function getPersonal($filter) {

        $Query = 'SELECT DISTINCT ?item ?itemLabel ?fec_nac ?imagen ?sexo_o_g_nero ?sexo_o_g_neroLabel ?pa_s_de_nacionalidad                                    
                    ?pa_s_de_nacionalidadLabel ?nombre_de_pila ?nombre_de_pilaLabel ?lugar_de_nacimiento 
                    ?lugar_de_nacimientoLabel ?miembro_del_partido_pol_tico ?miembro_del_partido_pol_ticoLabel
                    WHERE {
                      VALUES ?item {
                        ' . $filter . '
                      }
                      SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],es". }
                      OPTIONAL { ?item wdt:P18 ?imagen. }
                      OPTIONAL { ?item wdt:P21 ?sexo_o_g_nero. }
                      OPTIONAL { ?item wdt:P27 ?pa_s_de_nacionalidad. }
                      OPTIONAL { ?item wdt:P735 ?nombre_de_pila. }
                      OPTIONAL { ?item wdt:P19 ?lugar_de_nacimiento. }
                      OPTIONAL { ?item wdt:P102 ?miembro_del_partido_pol_tico. }
                      OPTIONAL { ?item wdt:P569 ?fec_nac. }
                    }';

        $sparqlQueryString = $Query;

        $queryDispatcher = new \model\SPARQLQuery(\F3::get('URL_SPARQL'));
        $queryResult = $queryDispatcher->query($sparqlQueryString);

        return ($queryResult);
    }

    public static function getLanguage($filter) {

        $Query = 'SELECT DISTINCT ?item ?lenguas_habladas__escritas_o_signadas ?lenguas_habladas__escritas_o_signadasLabel WHERE {
                    VALUES ?item {
                       ' . $filter . '
                    }
                    SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],es". }
                    OPTIONAL { ?item wdt:P1412 ?lenguas_habladas__escritas_o_signadas. }
                  }';

        $sparqlQueryString = $Query;

        $queryDispatcher = new \model\SPARQLQuery(\F3::get('URL_SPARQL'));
        $queryResult = $queryDispatcher->query($sparqlQueryString);

        return ($queryResult);
    }

    public static function getOccupation($filter) {

        $Query = 'SELECT DISTINCT ?item ?ocupaci_n ?ocupaci_nLabel WHERE {
                    VALUES ?item {
                        ' . $filter . '
                    }
                    SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],es". }
                    OPTIONAL { ?item wdt:P106 ?ocupaci_n. }
                  }';

        $sparqlQueryString = $Query;

        $queryDispatcher = new \model\SPARQLQuery(\F3::get('URL_SPARQL'));
        $queryResult = $queryDispatcher->query($sparqlQueryString);

        return ($queryResult);
    }

    public static function getEducation($filter) {

        $Query = 'SELECT DISTINCT ?item ?educado_en ?educado_enLabel WHERE {
                    VALUES ?item {
                       ' . $filter . '
                    }
                    SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],es". }
                    OPTIONAL { ?item wdt:P69 ?educado_en. }
                  }';

        $sparqlQueryString = $Query;

        $queryDispatcher = new \model\SPARQLQuery(\F3::get('URL_SPARQL'));
        $queryResult = $queryDispatcher->query($sparqlQueryString);

        return ($queryResult);
    }

    public static function getPosition_held($filter) {

        $Query = 'SELECT DISTINCT ?item ?cargo_ocupado ?cargo_ocupadoLabel WHERE {
                    VALUES ?item {
                       ' . $filter . '
                    }
                    SERVICE wikibase:label { bd:serviceParam wikibase:language "[AUTO_LANGUAGE],es". }
                    OPTIONAL { ?item wdt:P39 ?cargo_ocupado. }
                  }';

        $sparqlQueryString = $Query;

        $queryDispatcher = new \model\SPARQLQuery(\F3::get('URL_SPARQL'));
        $queryResult = $queryDispatcher->query($sparqlQueryString);

        return ($queryResult);
    }

}
