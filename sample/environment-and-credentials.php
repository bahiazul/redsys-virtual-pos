<?php

/**
 * Default credentials for Development Environment
 *
 * Note: For Testing, Integration and Live environments
 * these credentials are private and should be provided by your bank
 */
$credentials['secret']       = 'Mk9m98IfEblmPfrpsawt7BmxObt98Jev';
$credentials['merchantCode'] = '999008881';
$credentials['terminal']     = '871';

// The Environment object holds connection details
$env = new nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment();
$env->setSecret($credentials['secret']);
