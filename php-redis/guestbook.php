<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'Predis/Autoloader.php';

Predis\Autoloader::register();

if (isset($_GET['cmd']) === true) {
  $host = 'redis-master';
  if (getenv('GET_HOSTS_FROM') == 'env') {
    $host = getenv('REDIS_MASTER_SERVICE_HOST');
  }
  $now = time();
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'add') {
        $client = new Predis\Client([
          'scheme' => 'tcp',
          'host'   => $host,
          'port'   => 6379,
        ]);
        $hostname = getenv('HOSTNAME');;
        $value = $hostname . ' saved: '.$_GET['value'];
        $client->set('ts/' . $now, $value);
        print('{"message": "Added"}');
  } elseif ($_GET['cmd'] == 'getkeys') {
        $host = 'redis-slave';
        if (getenv('GET_HOSTS_FROM') == 'env') {
          $host = getenv('REDIS_SLAVE_SERVICE_HOST');
        }
        $client = new Predis\Client([
          'scheme' => 'tcp',
          'host'   => $host,
          'port'   => 6379,
        ]);
        $keys = new stdClass();
        $keys->keys = $client->keys('ts/*');
        print("The keys variable :\n");
        print_r($keys);
        print(json_encode($keys));
  } elseif ($_GET['cmd'] == 'getall') {
        $host = 'redis-slave';
        if (getenv('GET_HOSTS_FROM') == 'env') {
          $host = getenv('REDIS_SLAVE_SERVICE_HOST');
        }
        $client = new Predis\Client([
          'scheme' => 'tcp',
          'host'   => $host,
          'port'   => 6379,
        ]);
        $keys = $client->keys('ts/*');
        arsort($keys);
        $messages = new stdClass();
        $messages->messages = array();
        $messages->host = getenv('HOSTNAME');
        foreach ($keys as $id => $key) {
            $value = $client->get($key);
            $messages->messages[] =$value;
        }
        print(json_encode($messages));
  } else {
        $host = 'redis-slave';
        if (getenv('GET_HOSTS_FROM') == 'env') {
          $host = getenv('REDIS_SLAVE_SERVICE_HOST');
        }
        $client = new Predis\Client([
          'scheme' => 'tcp',
          'host'   => $host,
          'port'   => 6379,
        ]);

        $value = $client->get($_GET['key']);
        print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>
