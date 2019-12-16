<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
// 管理端

route::get('/download_enclosure','Common\DownloadController@download_enclosure');
// 登录
Route::group(['middleware' => ['auth', 'web', 'permission']], function () {
    Route::get('/',[ 'as' => '/', 'uses' =>'HomeController@index'])->name('home');
    Route::get('/home',[ 'as' => '/', 'uses' =>'HomeController@index'])->name('home');

    // 系统管理
    Route::group(['prefix'=>'system','namespace'=>'System'],function(){

        route::get('/company','CompanyController@index');
        route::get('/company/add','CompanyController@add');
        route::post('/company/add_save','CompanyController@add_save');
        route::get('/company/edit/{id}','CompanyController@edit');
        route::post('/company/edit_save/{id}','CompanyController@edit_save');
        route::any('/company/chageStatus','CompanyController@chageStatus');
        route::post('/company/ajax_check_no','CompanyController@ajax_check_no');
        route::post('/company/ajax_check_name','CompanyController@ajax_check_name');
        route::post('/company/del','CompanyController@del');

        route::get('/','MainController@index');
        route::get('/add','MainController@add');
        route::post('/doadd','MainController@doadd');
        route::post('/addcheck','MainController@addCheck');
        route::post('/chageUsesStatus','MainController@chageUsesStatus');
        route::get('/edit/{id}','MainController@edit');
        route::post('/doedit','MainController@doedit');
        route::get('/degradeMemberStar','MainController@degradeMemberStar');
        route::post('/check_kf_account','MainController@check_kf_account');

        route::post('/reset','MainController@reset');

        //父级栏目管理
        route::get('/menusList','MenusController@index');
        route::get('/menus/add_menus','MenusController@add_menus');
        route::any('/menus/add_menus_save','MenusController@add_menus_save');
        route::any('/menus/chageMenusStatus','MenusController@chageMenusStatus');
        route::any('/menus/del_menus','MenusController@del_menus');
        route::any('/menus/edit_menus/{id}','MenusController@edit_menus');
        route::any('/menus/edit_menus_save','MenusController@edit_menus_save');
        route::any('/menus/ajax_menus','MenusController@ajax_menus');

        //Url权限节点
        route::get('/privilege','PrivilegeController@index');
        route::get('/privilege/add','PrivilegeController@add');//增加视图
        route::post('/privilege/add_save','PrivilegeController@add_save');
        route::get('/privilege/edit/{id}','PrivilegeController@edit');
        route::post('/privilege/edit_save','PrivilegeController@edit_save');
        route::post('/privilege/chagePath','PrivilegeController@chagePath');
        route::post('/privilege/chageStatus','PrivilegeController@chageStatus');
        route::post('/privilege/findPrivilegeListByMenuId','PrivilegeController@findPrivilegeListByMenuId');
        route::post('/privilege/findMenuListByPid','PrivilegeController@findMenuListByPid');


        //日志记录
        route::get('/logs_index','LogsController@index');
        route::get('/logsList','LogsController@logsList');


        route::get('/modifyPassword','UsersController@modifyPassword');//修改密码
        route::post('/modifyPassword_save','UsersController@modifyPassword_save');//修改密码保存
        route::post('/ajax_check_pwd','UsersController@ajax_check_pwd');//检测原始密码是否正确



        //区域管理
        route::get('/area','AreaController@index');
        route::get('/area/add','AreaController@add');
        route::post('/area/add_save','AreaController@add_save');
        route::post('/area/chageStatus','AreaController@chageStatus');
        route::post('/area/del','AreaController@del');
        route::any('/area/edit/{id}','AreaController@edit');
        route::post('/area/edit_save/{id}','AreaController@edit_save');
        route::post('/area/ajaxArea','MenusController@ajaxArea');

    });
    //角色管理
    Route::group(['prefix'=>'roles','namespace'=>'System'],function(){
        route::get('/','RolesController@index');
        route::get('/add','RolesController@add');
        route::post('/addSave','RolesController@addSave');
        route::post('/chageRolesStatus','RolesController@chageRolesStatus');
        route::post('/deleteRole','RolesController@deleteRole');
        route::get('/roleAuthority/{id}','RolesController@roleAuthority');
        route::get('/privilegeRoles/{id}','RolesController@privilegeRoles');
        route::post('/deleteRoleAuthority','RolesController@deleteRoleAuthority');
        route::post('/checkRoleAuthority','RolesController@checkRoleAuthority');
        route::any('/findMenusListByPid','RolesController@findMenusListByPid');

        route::post('/saveRolePrivilege','RolesController@saveRolePrivilege');
    });

    // 短信管理
    Route::group(['middleware'=>'web','prefix'=>'message','namespace'=>'Message'],function(){
        route::get('/','MessageController@index');

        route::get('/add','MessageController@add');
        route::post('/addSave',['as' => 'message.addSave', 'uses' => 'MessageController@addSave']);

    });
    //新闻媒体管理
    Route::group(['prefix'=>'media','namespace'=>'Media'],function(){
        route::get('/','MediaController@index');
        route::get('/add','MediaController@add');
        route::post('/addSave',['as' => 'media.addSave', 'uses' => 'MediaController@addSave']);
        route::get('/edit/{id}','MediaController@edit');
        route::post('/editSave/{id}',['as' => 'media.editSave', 'uses' => 'MediaController@editSave']);
        route::post('/ajax_check_mediaName','MediaController@ajax_check_mediaName');
        route::any('/get_media_types','MediaController@get_media_types');
        route::post('/chageStatus', 'MediaController@chageStatus');
    });
    //新闻上稿
    Route::group(['prefix'=>'news','namespace'=>'News'],function(){
        route::post('/confirmAll','NewsController@confirmAll');
        Route::group(['prefix'=>'draft'],function(){
            route::get('/','NewsController@index');
            route::get('/add','NewsController@add');
            route::post('/addSave',['as' => 'news.draft.addSave', 'uses' => 'NewsController@addSave']);
            route::post('/chageStatus', 'NewsController@chageStatus');
            route::post('/getTypeByMedia', 'NewsController@getTypeByMedia');
            route::get('/look/{id}', 'NewsController@look');
            route::get('/edit/{id}','NewsController@edit');
            route::post('/editSave/{id}',['as' => 'news.draft.editSave', 'uses' => 'NewsController@editSave']);
            route::post('/ajax_check_title','NewsController@ajax_check_title');

            route::post('/getTypeByTitle','NewsController@getTypeByTitle');
            Route::group(['prefix'=>'confirm'],function(){
                route::get('/','NewsController@confirm');
                route::get('/edit/{id}','NewsController@edit_confirm');
                route::post('/editConfirmSave/{id}',['as' => 'news.draft.editConfirmSave', 'uses' => 'NewsController@editConfirmSave']);
            });
            Route::group(['prefix'=>'statistics'],function(){
                route::get('/','NewsController@statistics');
                route::get('/statistics1','NewsController@statistics1');
                route::post('/sub_prize','NewsController@sub_prize');
            });
        });
    });
    //新闻评阅
    Route::group(['prefix'=>'review','namespace'=>'News'],function(){
        Route::group(['prefix'=>'draft'],function(){
            route::get('/','ReviewController@index');
            route::get('/add','ReviewController@add');
            route::post('/addSave',['as' => 'review.draft.addSave', 'uses' => 'ReviewController@addSave']);
            route::post('/chageStatus', 'ReviewController@chageStatus');
            route::get('/look/{id}', 'ReviewController@look');
            route::get('/edit/{id}','ReviewController@edit');
            route::post('/editSave/{id}',['as' => 'review.draft.editSave', 'uses' => 'ReviewController@editSave']);
            route::post('/ajax_check_title','ReviewController@ajax_check_title');
            Route::group(['prefix'=>'confirm'],function(){
                route::get('/','ReviewController@confirm');
                route::get('/edit/{id}','ReviewController@edit_confirm');
                route::post('/editConfirmSave/{id}',['as' => 'review.draft.editConfirmSave', 'uses' => 'ReviewController@editConfirmSave']);
            });
            Route::group(['prefix'=>'statistics'],function(){
                route::get('/','ReviewController@statistics');
                route::post('/sub_prize','ReviewController@sub_prize');
            });
        });
    });
    //新闻线索
    Route::group(['prefix'=>'clue','namespace'=>'News'],function(){
        Route::group(['prefix'=>'draft'],function(){
            route::get('/','ClueController@index');
            route::get('/add','ClueController@add');
            route::post('/addSave',['as' => 'clue.draft.addSave', 'uses' => 'ClueController@addSave']);
            route::post('/editSave/{id}',['as' => 'clue.draft.editSave', 'uses' => 'ClueController@editSave']);
            route::post('/chageStatus', 'ClueController@chageStatus');
            Route::group(['prefix'=>'manage'],function(){
                route::get('/','ClueController@manage');
                route::get('/edit/{id}','ClueController@edit_confirm');
                route::post('/editConfirmSave/{id}',['as' => 'clue.draft.editConfirmSave', 'uses' => 'ClueController@editConfirmSave']);
            });
        });
    });
    //采访报告
    Route::group(['prefix'=>'presentation','namespace'=>'News'],function(){
        route::get('/','PresentationController@index');
        route::get('/add','PresentationController@add');
        route::post('/addSave',['as' => 'presentation.addSave', 'uses' => 'PresentationController@addSave']);
        route::post('/editSave/{id}',['as' => 'presentation.editSave', 'uses' => 'PresentationController@editSave']);
        route::post('/chageStatus', 'PresentationController@chageStatus');
    });
    //日常管理
    Route::group(['prefix'=>'work','namespace'=>'News'],function(){
        route::get('/','WorkController@index');
        route::get('/add','WorkController@add');
        route::post('/addSave',['as' => 'work.addSave', 'uses' => 'WorkController@addSave']);
        route::post('/editSave/{id}',['as' => 'work.editSave', 'uses' => 'WorkController@editSave']);
        route::post('/chageStatus', 'WorkController@chageStatus');
    });
    //典型宣传报告管理
    Route::group(['prefix'=>'propaganda','namespace'=>'Propaganda'],function(){
        route::get('/','PropagandaController@index');
        route::get('/add','PropagandaController@add');
        route::post('/addSave',['as' => 'propaganda.addSave', 'uses' => 'PropagandaController@addSave']);
        route::get('/edit/{id}','PropagandaController@edit');
        route::get('/look/{id}','PropagandaController@look');
        route::post('/editSave/{id}',['as' => 'propaganda.editSave', 'uses' => 'PropagandaController@editSave']);
        route::post('/chageStatus', 'PropagandaController@chageStatus');
        route::post('/getIdByList', 'PropagandaController@getIdByList');
    });
});