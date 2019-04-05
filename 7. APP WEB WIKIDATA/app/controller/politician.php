<?php

namespace controller;

/**
 * Controlador de la portada
 */
class politician {

    /**
     * Ruta principal
     * /
     * @param \Base $fat
     */
    public function index(\Base $fat) {

        echo \Template::instance()->render('index.html');
    }

    public function details(\Base $fat) {

        $code = $fat->get('POST.wdCode');

        $personal = \model\wikidata\politician::getPersonal($code);
        $education = \model\wikidata\politician::getEducation($code);
        $language = \model\wikidata\politician::getLanguage($code);
        $occupation = \model\wikidata\politician::getOccupation($code);
        $position_held = \model\wikidata\politician::getPosition_held($code);

        $fat->mset([
            'personal' => $personal["results"]["bindings"][0],
            'education' => $education["results"]["bindings"],
            'language' => $language["results"]["bindings"],
            'occupation' => $occupation["results"]["bindings"],
            'position_held' => $position_held["results"]["bindings"]
        ]);

        echo \Template::instance()->render('details.html');
    }

}
