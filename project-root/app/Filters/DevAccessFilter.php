<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class DevAccessFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (ENVIRONMENT === 'development') {
            $allowedIPs = ['127.0.0.1', '::1', '192.168.65.1'];

            $ip = $request->getIPAddress();

            if (!in_array($ip, $allowedIPs)) {
                return service('response')
                    ->setStatusCode(403)
                    ->setBody('Odmowa dostępu: środowisko deweloperskie');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}