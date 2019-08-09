<?php

require __DIR__ . '/vendor/autoload.php';

// load environment variables
$dotenv = Dotenv\Dotenv::create(__DIR__);

$dotenv->load();
$dotenv->required('DATABASE_HOST')->notEmpty();
$dotenv->required('DATABASE_NAME')->notEmpty();
$dotenv->required('DATABASE_PORT')->notEmpty();
$dotenv->required('DATABASE_USER')->notEmpty();
$dotenv->required('DATABASE_PASSWORD')->notEmpty();

$dsn = 'mysql:host=' . getenv('DATABASE_HOST')
     . ';dbname=' . getenv('DATABASE_NAME')
     . ';port=' . getenv('DATABASE_PORT');

$database = new PDO($dsn, getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));

$rawSensuOutput = fgets(STDIN);

$sensuOutput = json_decode($rawSensuOutput);

$query = 'INSERT INTO sensor_log (sensor_name, `timestamp`, `status`, duration, output, client) 
               VALUES (:sensor_name, :timestamp, :status, :duration, :output, :client)';

$values = [
    'sensor_name' => $sensuOutput->check->name,
    'timestamp' => date('Y-m-d H:i:s'),
    'status' => $sensuOutput->check->status,
    'duration' => $sensuOutput->check->duration,
    'output' => $sensuOutput->check->output,
    'client' => $sensuOutput->client,
];

$insert = $database->prepare($query);
$insert->execute($values);
