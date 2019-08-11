<?php
    return [
        //ps rute
        \App\Core\Route::get('|^login/?$|',                                 'Main',                              'getLogin'),
        \App\Core\Route::post('|^login/?$|',                                'Main',                              'postLogin'),
        \App\Core\Route::get('|^logout/?$|',                                'Main',                              'getLogout'),

        \App\Core\Route::get('|^program-poslovanja/?$|',                    'ProgramPoslovanja',                 'getProgram'),
        \App\Core\Route::get('|^plan-javnih-nabavki/?$|',                   'PlanJavnihNabavki',                 'getPlan'),
        \App\Core\Route::get('|^realizacija-sprovodjenja-nabavke/?$|',      'RealizacijaSprovodjenjaNabavke',    'getRealizacija'),
        \App\Core\Route::get('|^realizacija-ugovora/?$|',                   'RealizacijaUgovora',                'getUgovor'),
        \App\Core\Route::get('|^program-poslovanja/add/?$|',                'ProgramPoslovanja',                 'getAdd'),
        \App\Core\Route::post('|^program-poslovanja/add/?$|',               'ProgramPoslovanja',                 'postAdd'),
        \App\Core\Route::get('|^plan-javnih-nabavki/add/?$|',               'PlanJavnihNabavki',                 'getAdd'),
        \App\Core\Route::post('|^plan-javnih-nabavki/add/?$|',              'PlanJavnihNabavki',                 'postAdd'),
        \App\Core\Route::get('|^realizacija-sprovodjenja-nabavke/add/?$|',  'RealizacijaSprovodjenjaNabavke',    'getAdd'),
        \App\Core\Route::post('|^realizacija-sprovodjenja-nabavke/add/?$|', 'RealizacijaSprovodjenjaNabavke',    'postAdd'),
        \App\Core\Route::get('|^realizacija-ugovora/add/?$|',               'RealizacijaUgovora',                'getAdd'),
        \App\Core\Route::post('|^realizacija-ugovora/add/?$|',              'RealizacijaUgovora',                'postAdd'),

        #Admin role routes:
        // \App\Core\Route::get('|^admin/login/?$|',                  'Main',                   'getLogin'),
        // \App\Core\Route::post('|^admin/login/?$|',                 'Main',                   'postLogin'),
        \App\Core\Route::get('|^admin-panel/?$|',                  'AdminPanel',             'index'),
        // \App\Core\Route::get('|^admin/logout/?$|',                      'Main',              'getLogout'),
        \App\Core\Route::get('|^admin/products/?$|',               'AdminProductMenagement', 'products'),
        \App\Core\Route::get('|^admin/products/edit/([0-9]+)?$|',  'AdminProductMenagement', 'getEdit'),
        \App\Core\Route::post('|^admin/products/edit/([0-9]+)?$|', 'AdminProductMenagement', 'postEdit'),
        \App\Core\Route::get('|^admin/products/add/?$|',           'AdminProductMenagement', 'getAdd'),
        \App\Core\Route::post('|^admin/products/add/?$|',          'AdminProductMenagement', 'postAdd'),

        \App\Core\Route::any('|^.*$|',                             'Main',                   'postLogin')
    ];