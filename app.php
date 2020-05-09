<?php

require_once 'vendor/autoload.php';

$command = $argv[1] ?? 'graduate_work';

switch ($command) {
    case 'graduate_work':
        $main = new GraduateWork\Main();
        $main->main();
        break;
    case 'generate_sample_data':
        $main = new SampleDataGenerator\Main();
        $main->main();
        break;
    case 'distance':
        $main = new Distance\Main();
        $main->main();
        break;
    default:
        throw new \Exception('Command "' . $command . '" not fount!');
}
