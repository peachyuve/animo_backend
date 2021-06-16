<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class userAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $unrestricted = [
            'login*', 'register*'
        ];
        $isUnrestricted = in_array( 1, array_map( function($a){return url_is($a);}, $unrestricted ) );

        if (session()->get('logged_in')) {
            if ($isUnrestricted) {
                return redirect()->to('/');
            }
        }else {
            if (!($isUnrestricted)) {
                return redirect()->to('/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}