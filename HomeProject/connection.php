<?php

const USERNAME = 'arljub';
const PASSWORD = '911735';

function getConnection(): PDO
{
    $host = 'db.mkalmo.xyz';

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $host, USERNAME);

    return new PDO($address, USERNAME, PASSWORD);
}
