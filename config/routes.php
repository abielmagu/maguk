<?php

return [
    // Dashboard
    'example' => 'ExampleController:index',
    'dashboard' => 'DashboardController:index',
    
    // Redirect to default-route if the user-route is not found
    // It is necessary to assign the keyname of some route of this array;
    'default' => 'dashboard' 
];
