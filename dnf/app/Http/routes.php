<?php

/*
|--------------------------------------------------------------------------
| 备注
|--------------------------------------------------------------------------
| 路由的命名关系到权限控制，请按照下例格式来命名
| 'as' => 'backend|frontend_[模块名_]类名_方法名'
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


# 后台路由组
Route::group(['prefix' => 'backend'], function() {

    # 页面：管理员登陆
    Route::get('/login', [
        'as' => 'backend_auth_auth_index',
        'uses' => 'Backend\Auth\AuthController@index'
    ]);
    # Post: 管理员登陆
    Route::post('/login',[
        'as' => 'backend_auth_auth_login',
        'uses' => 'Backend\Auth\AuthController@login'
    ]);
    # Get: 管理员退出
    Route::get('/logout', [
        'as' => 'backend_auth_auth_logout',
        'uses' => 'Backend\Auth\AuthController@logout'
    ]);

    # 登陆验证
    Route::group(['middleware' => 'admin.auth'], function () {

        # 后台首页
        Route::get('/', [
            'as' => 'backend_dashboard_index',
            'uses' => 'Backend\DashboardController@index'
        ]);

        # 页面: 修改当前用户信息
        Route::get('/account', [
            'as' => 'backend_dashboard_user_account',
            'uses' => 'Backend\DashboardController@account',
        ]);

        # 动作: 修改当前用户信息
        Route::post('/account', [
            'as' => 'backend_dashboard_user_account',
            'uses' => 'Backend\DashboardController@_account',
        ]);

        # 站内信
        Route::group(['prefix' => 'inbox'], function () {

            Route::get('/', [
                'as' => 'backend_inbox_index',
                'uses' => 'Backend\Inbox\InboxController@index',
            ]);

            Route::post('/unread', [
                'as' => 'backend_inbox_unread',
                'uses' => 'Backend\Inbox\InboxController@unread',
            ]);

            Route::post('/read', [
                'as' => 'backend_inbox_read',
                'uses' => 'Backend\Inbox\InboxController@read',
            ]);

            Route::post('/sended', [
                'as' => 'backend_inbox_sended',
                'uses' => 'Backend\Inbox\InboxController@sended',
            ]);

            Route::post('/send', [
                'as' => 'backend_inbox_send',
                'uses' => 'Backend\Inbox\InboxController@_send',
            ]);

            Route::post('/flag', [
                'as' => 'backend_inbox_flag',
                'uses' => 'Backend\Inbox\InboxController@_flag',
            ]);
        });


        # 权限验证
        Route::group(['middleware' => 'acl.auth'], function () {

            # 系统管理
            Route::group(['prefix' => 'system'], function() {

                # 菜单功能管理
                Route::group(['prefix' => 'acl'], function() {

                    # 页面：菜单功能首页
                    Route::get('/index', [
                        'as' => 'backend_system_acl_index',
                        'uses' => 'Backend\System\AclController@index'
                    ]);

                    # 页面：菜单功能添加
                    Route::get('/add', [
                        'as' => 'backend_system_acl_add',
                        'uses' => 'Backend\System\AclController@add'
                    ]);
                    # 动作：菜单功能添加
                    Route::post('/add', [
                        'as' => 'backend_system_acl_add',
                        'uses' => 'Backend\System\AclController@_add'
                    ]);

                    # 动作：菜单功能编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_acl_edit',
                        'uses' => 'Backend\System\AclController@edit'
                    ]);
                    # 动作：菜单功能编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_acl_edit',
                        'uses' => 'Backend\System\AclController@_edit'
                    ]);

                    # 动作：菜单功能删除
                    Route::post('/delete', [
                        'as' => 'backend_system_acl_delete',
                        'uses' => 'Backend\System\AclController@_delete'
                    ]);
                });

                # 用户组管理
                Route::group(['prefix' => 'group'], function() {

                    # 页面：用户组首页
                    Route::get('/index', [
                        'as' => 'backend_system_group_index',
                        'uses' => 'Backend\System\GroupController@index'
                    ]);

                    # 页面: 用户组添加
                    Route::get('/add', [
                        'as' => 'backend_system_group_add',
                        'uses' => 'Backend\System\GroupController@add'
                    ]);
                    # 动作：用户组添加
                    Route::post('/add', [
                        'as' => 'backend_system_group_add',
                        'uses' => 'Backend\System\GroupController@_add'
                    ]);

                    # 页面：用户组编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_group_edit',
                        'uses' => 'Backend\System\GroupController@edit'
                    ]);
                    # 动作：用户组编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_group_edit',
                        'uses' => 'Backend\System\GroupController@_edit'
                    ]);

                    # 动作：用户组删除
                    Route::post('/delete', [
                        'as' => 'backend_system_group_delete',
                        'uses' => 'Backend\System\GroupController@_delete'
                    ]);

                    # 动作：改变用户组状态
                    Route::post('/change-status', [
                        'as' => 'backend_system_group_change-status',
                        'uses' => 'Backend\System\GroupController@_changeStatus'
                    ]);

                    # 页面：用户组权限
                    Route::get('/acl', [
                        'as' => 'backend_system_group_acl',
                        'uses' => 'Backend\System\GroupController@acl'
                    ]);
                    # 动作J：用户组权限保存
                    Route::post('/acl', [
                        'as' => 'backend_system_group_acl',
                        'uses' => 'Backend\System\GroupController@_acl'
                    ]);

                });

                # 用户管理
                Route::group(['prefix' => 'user'], function() {

                    # 页面：用户首页
                    Route::get('/index', [
                        'as' => 'backend_system_user_index',
                        'uses' => 'Backend\System\UserController@index'
                    ]);

                    # 页面: 用户添加
                    Route::get('/add', [
                        'as' => 'backend_system_user_add',
                        'uses' => 'Backend\System\UserController@add'
                    ]);
                    # 动作：用户添加
                    Route::post('/add', [
                        'as' => 'backend_system_user_add',
                        'uses' => 'Backend\System\UserController@_add'
                    ]);

                    # 页面：用户编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_user_edit',
                        'uses' => 'Backend\System\UserController@edit'
                    ]);
                    # 动作：用户编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_user_edit',
                        'uses' => 'Backend\System\UserController@_edit'
                    ]);

                    # 动作：用户删除
                    Route::post('/delete', [
                        'as' => 'backend_system_user_delete',
                        'uses' => 'Backend\System\UserController@_delete'
                    ]);

                    # 动作：改变用户组状态
                    Route::post('/change-status', [
                        'as' => 'backend_system_user_change-status',
                        'uses' => 'Backend\System\UserController@_changeStatus'
                    ]);

                    # 页面：用户权限
                    Route::get('/acl', [
                        'as' => 'backend_system_user_acl',
                        'uses' => 'Backend\System\UserController@acl'
                    ]);
                    # 动作：用户权限保存
                    Route::post('/acl', [
                        'as' => 'backend_system_user_acl',
                        'uses' => 'Backend\System\UserController@_acl'
                    ]);

                });
            });
        });
    });

});
