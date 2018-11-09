<?php

return [
    // Auth
    'sign' => 'AuthController:index',
    'signing' => 'AuthController:signing',
    'signout' => 'AuthController:signout',
    
    // Dashboard
    'dashboard/' => 'DashboardController:index', // Set slash(/) for set arguments on the route
    
    // Redirect to default-route if the user-route is not found
    // It is necessary to assign the keyname of some route of this array;
    'default' => 'dashboard/' 
];
