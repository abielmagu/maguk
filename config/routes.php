<?php

return [
    // Auth
    'sign' => 'AuthController:index',
    'signing' => 'AuthController:signing',
    'signout' => 'AuthController:signout',
    
    // Dashboard
    'dashboard' => 'DashboardController:index',
    // 'dashboard/show/' = 'DashboardController:show' // Route with args like url "dashboard/show/{?}"
    
    // Redirect to default-route if the user-route is not found
    // It is necessary to assign the keyname of some route of this array;
    'default' => 'dashboard' 
];
