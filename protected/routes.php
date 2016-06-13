<?php

return [
    '/login'                => '//User/Login',
    '/logout'               => '//User/Logout',
    '/Signup'               => '//User/Signup',

    '/cards'                => '//Card/Default',
    '/card/edit/<1>'        => '//Card/Edit(id=<1>)',

    '/categories'           => '//Category/Default',

    '/actions'              => '//Action/Default',
    '/action/edit/<1>'      => '//Action/Edit(id=<1>)',
        
    '/objects'              => '//Object/Default',
    '/object/edit/<1>'      => '//Object/Edit(id=<1>)',
    
    '/works'                => '//Work/Default',
    '/work/edit/<1>/<2>'    => '//Work/Edit(order_id=<1>,id=<2>)',
    '/work/edit/<1>'        => '//Work/Edit(order_id=<1>)',
    '/works/<1>'            => '//Work/Default(id=<1>)',
    
    '/orders'               => '//Order/Default',
    '/order/edit/<1>'       => '//Order/Edit(id=<1>)',

    '/customs'              => '//Custom/Default',
    '/custom/edit/<1>'      => '//Custom/Edit(id=<1>)',

];