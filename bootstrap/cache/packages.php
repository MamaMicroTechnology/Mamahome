<?php return array (
  'barryvdh/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Cors\\ServiceProvider',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nexmo/laravel' => 
  array (
    'providers' => 
    array (
      0 => 'Nexmo\\Laravel\\NexmoServiceProvider',
    ),
    'aliases' => 
    array (
      'Nexmo' => 'Nexmo\\Laravel\\Facade\\Nexmo',
    ),
  ),
);