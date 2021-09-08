<?php
    return [
        \App\Core\Route::get('|^login/?$|',                                          'Login',                             'getLogin'),
        \App\Core\Route::post('|^login/?$|',                                         'Login',                             'postLogin'),
        \App\Core\Route::get('|^logout/?$|',                                         'Main',                              'getLogout'),

        \App\Core\Route::get('|^program-poslovanja/?$|',                             'ProgramPoslovanja',                 'getProgram'),
        \App\Core\Route::get('|^plan-javnih-nabavki/?$|',                            'PlanJavnihNabavki',                 'getPlan'),
        \App\Core\Route::get('|^plan-javnih-nabavki/download/?$|',                   'PlanJavnihNabavki',                 'makeExcel'),
        \App\Core\Route::get('|^realizacija-sprovodjenja-nabavke/?$|',               'RealizacijaSprovodjenjaNabavke',    'getRealizacija'),
        \App\Core\Route::get('|^realizacija-ugovora/?$|',                            'RealizacijaUgovora',                'getUgovor'),

        //ADD 
        \App\Core\Route::get('|^program-poslovanja/add/?$|',                         'ProgramPoslovanjaMenagement',       'getAdd'),
        \App\Core\Route::post('|^program-poslovanja/add/?$|',                        'ProgramPoslovanjaMenagement',       'postAdd'),
        \App\Core\Route::get('|^plan-javnih-nabavki/add/?$|',                        'PlanJavnihNabavki',                 'getAdd'),
        \App\Core\Route::post('|^plan-javnih-nabavki/add/?$|',                       'PlanJavnihNabavki',                 'postAdd'),
        \App\Core\Route::get('|^realizacija-sprovodjenja-nabavke/add/?$|',           'RealizacijaSprovodjenjaNabavke',    'getAdd'),
        \App\Core\Route::post('|^realizacija-sprovodjenja-nabavke/add/?$|',          'RealizacijaSprovodjenjaNabavke',    'postAdd'),
        \App\Core\Route::get('|^realizacija-ugovora/add/?$|',                        'RealizacijaUgovora',                'getAdd'),
        \App\Core\Route::post('|^realizacija-ugovora/add/?$|',                       'RealizacijaUgovora',                'postAdd'),

        //EDIT
        \App\Core\Route::get('|^program-poslovanja/edit/([0-9]+)?$|',                'ProgramPoslovanjaMenagement',       'getEdit'),
        \App\Core\Route::post('|^program-poslovanja/edit/([0-9]+)?$|',               'ProgramPoslovanjaMenagement',       'postEdit'),
        \App\Core\Route::get('|^plan-javnih-nabavki/edit/([0-9]+)?$|',               'PlanJavnihNabavki',                 'getEdit'),
        \App\Core\Route::post('|^plan-javnih-nabavki/edit/([0-9]+)?$|',              'PlanJavnihNabavki',                 'postEdit'),
        \App\Core\Route::get('|^realizacija-sprovodjenja-nabavke/edit/([0-9]+)?$|',  'RealizacijaSprovodjenjaNabavke',    'getEdit'),
        \App\Core\Route::post('|^realizacija-sprovodjenja-nabavke/edit/([0-9]+)?$|', 'RealizacijaSprovodjenjaNabavke',    'postEdit'),
        \App\Core\Route::get('|^realizacija-ugovora/edit/([0-9]+)?$|',               'RealizacijaUgovora',                'getEdit'),
        \App\Core\Route::post('|^realizacija-ugovora/edit/([0-9]+)?$|',              'RealizacijaUgovora',                'postEdit'),

        
        \App\Core\Route::any('|^.*$|',                                               'Main',                              'home')
    ];