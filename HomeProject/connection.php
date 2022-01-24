<?php

const USERNAME = 'USERNAME';
const PASSWORD = 'PASSWORD';

function getConnection(): PDO
{
    $host = 'HOST';

    $address = sprintf('mysql:host=%s;port=PORT;dbname=%s',
        $host, USERNAME);

    return new PDO($address, USERNAME, PASSWORD);
}
