<?php
function get_lat_long($ville,$zip){


    $json = file_get_contents("https://api-adresse.data.gouv.fr/search/?q=$ville&postcode=$zip&limit=1");
    $json = json_decode($json);


    $lat = $json->{'features'}[0]->{'geometry'}->{'coordinates'}[1];
    $long = $json->{'features'}[0]->{'geometry'}->{'coordinates'}[0];
    return [$lat,$long];
}