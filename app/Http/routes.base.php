<?php

/*
|--------------------------------------------------------------------------
| BASE Routes
|--------------------------------------------------------------------------
|
| (do not modify here. if you have updates to base, update laravel-base repo instead)
|
*/

Route::auth();
Route::get('autogen', array('as'=>'autogen','uses'=>'AutogenController@index'));

Route::get('admin', array('as'=>'adminLogin','uses'=>'Admin\AuthController@login'));
Route::post('admin', array('as'=>'adminAuthenticate','uses'=>'Admin\AuthController@authenticate'));
Route::get('admin/logout', array('as'=>'adminLogout','uses'=>'Admin\AuthController@logout'));

Route::get('admin/dashboard', array('as'=>'adminDashboard','uses'=>'Admin\DashboardController@index'));

Route::get('admin/samples', array('as'=>'adminSamples','uses'=>'Admin\SampleController@index'));
Route::get('admin/samples/datatable', array('as'=>'adminSamplesDatatable','uses'=>'Admin\SampleController@datatable'));
Route::get('admin/samples/create', array('as'=>'adminSamplesCreate','uses'=>'Admin\SampleController@create'));
Route::post('admin/samples/', array('as'=>'adminSamplesStore','uses'=>'Admin\SampleController@store'));
Route::get('admin/samples/{id}/show', array('as'=>'adminSamplesShow','uses'=>'Admin\SampleController@show'));
Route::get('admin/samples/{id}/view', array('as'=>'adminSamplesView','uses'=>'Admin\SampleController@view'));
Route::get('admin/samples/{id}/edit', array('as'=>'adminSamplesEdit','uses'=>'Admin\SampleController@edit'));
Route::patch('admin/samples/{id}', array('as'=>'adminSamplesUpdate','uses'=>'Admin\SampleController@update'));
Route::post('admin/samples/seo', array('as'=>'adminSamplesSeo','uses'=>'Admin\SampleController@seo'));
Route::delete('admin/samples/destroy', array('as'=>'adminSamplesDestroy','uses'=>'Admin\SampleController@destroy'));
Route::get('admin/samples/crop/url', array('as'=>'adminSamplesCropUrl','uses'=>'Admin\SampleController@crop_url'));
Route::get('admin/samples/{id}/crop/{column}/{asset_id}', array('as'=>'adminSamplesCropForm','uses'=>'Admin\SampleController@crop_form'));
Route::patch('admin/samples/{id}/crop', array('as'=>'adminSamplesCrop','uses'=>'Admin\SampleController@crop'));

Route::get('admin/users', array('as'=>'adminUsers','uses'=>'Admin\UserController@index'));
Route::get('admin/users/create', array('as'=>'adminUsersCreate','uses'=>'Admin\UserController@create'));
Route::post('admin/users/', array('as'=>'adminUsersStore','uses'=>'Admin\UserController@store'));
Route::get('admin/users/{id}/show', array('as'=>'adminUsersShow','uses'=>'Admin\UserController@show'));
Route::get('admin/users/{id}/edit', array('as'=>'adminUsersEdit','uses'=>'Admin\UserController@edit'));
Route::patch('admin/users/{id}', array('as'=>'adminUsersUpdate','uses'=>'Admin\UserController@update'));
Route::delete('admin/users/destroy', array('as'=>'adminUsersDestroy','uses'=>'Admin\UserController@destroy'));

Route::get('admin/profile', array('as'=>'adminProfile','uses'=>'Admin\ProfileController@index'));
Route::get('admin/profile/edit', array('as'=>'adminProfileEdit','uses'=>'Admin\ProfileController@edit'));
Route::patch('admin/profile/edit', array('as'=>'adminProfileUpdate','uses'=>'Admin\ProfileController@update'));
Route::get('admin/profile/change_password', array('as'=>'adminProfilePasswordEdit','uses'=>'Admin\ProfileController@password_edit'));
Route::patch('admin/profile/change_password', array('as'=>'adminProfilePasswordUpdate','uses'=>'Admin\ProfileController@password_update'));

Route::get('admin/options', array('as'=>'adminOptions','uses'=>'Admin\OptionController@index'));
Route::get('admin/options/create', array('as'=>'adminOptionsCreate','uses'=>'Admin\OptionController@create'));
Route::post('admin/options/', array('as'=>'adminOptionsStore','uses'=>'Admin\OptionController@store'));
Route::get('admin/options/{id}/show', array('as'=>'adminOptionsShow','uses'=>'Admin\OptionController@show'));
Route::get('admin/options/{id}/view', array('as'=>'adminOptionsView','uses'=>'Admin\OptionController@view'));
Route::get('admin/options/{id}/edit', array('as'=>'adminOptionsEdit','uses'=>'Admin\OptionController@edit'));
Route::patch('admin/options/{id}', array('as'=>'adminOptionsUpdate','uses'=>'Admin\OptionController@update'));
Route::delete('admin/options/destroy', array('as'=>'adminOptionsDestroy','uses'=>'Admin\OptionController@destroy'));

Route::post('admin/assets/upload', array('as'=>'adminAssetsUpload','uses'=>'Admin\AssetController@upload'));
Route::post('admin/assets/redactor', array('as'=>'adminAssetsRedactor','uses'=>'Admin\AssetController@redactor'));
Route::get('admin/assets/all', array('as'=>'adminAssetsAll','uses'=>'Admin\AssetController@all'));
Route::get('admin/assets/get', array('as'=>'adminAssetsGet','uses'=>'Admin\AssetController@get'));
Route::get('admin/assets/download', array('as'=>'adminAssetsDownload','uses'=>'Admin\AssetController@download'));
Route::post('admin/assets/update', array('as'=>'adminAssetsUpdate','uses'=>'Admin\AssetController@update'));
Route::post('admin/assets/destroy', array('as'=>'adminAssetsDestroy','uses'=>'Admin\AssetController@destroy'));
Route::get('admin/assets/get_asset_tags', array('as'=>'adminGetAssetTags','uses'=>'Admin\AssetController@getAssetTags'));

Route::get('admin/tests', array('as'=>'adminTests','uses'=>'Admin\TestController@index'));
Route::get('admin/tests/create', array('as'=>'adminTestsCreate','uses'=>'Admin\TestController@create'));
Route::post('admin/tests/', array('as'=>'adminTestsStore','uses'=>'Admin\TestController@store'));
Route::get('admin/tests/{id}/show', array('as'=>'adminTestsShow','uses'=>'Admin\TestController@show'));
Route::get('admin/tests/{id}/view', array('as'=>'adminTestsView','uses'=>'Admin\TestController@view'));
Route::get('admin/tests/{id}/edit', array('as'=>'adminTestsEdit','uses'=>'Admin\TestController@edit'));
Route::patch('admin/tests/{id}', array('as'=>'adminTestsUpdate','uses'=>'Admin\TestController@update'));
Route::post('admin/tests/seo', array('as'=>'adminTestsSeo','uses'=>'Admin\TestController@seo'));
Route::delete('admin/tests/destroy', array('as'=>'adminTestsDestroy','uses'=>'Admin\TestController@destroy'));
Route::get('admin/tests/crop/url', array('as'=>'adminTestsCropUrl','uses'=>'Admin\TestController@crop_url'));
Route::get('admin/tests/{id}/crop/{column}/{asset_id}', array('as'=>'adminTestsCropForm','uses'=>'Admin\TestController@crop_form'));
Route::patch('admin/tests/{id}/crop', array('as'=>'adminTestsCrop','uses'=>'Admin\TestController@crop'));
Route::get('admin/tests/order', array('as'=>'adminTestsOrder','uses'=>'Admin\TestController@order'));

Route::get('admin/long_names', array('as'=>'adminLongNames','uses'=>'Admin\LongNameController@index'));
Route::get('admin/long_names/create', array('as'=>'adminLongNamesCreate','uses'=>'Admin\LongNameController@create'));
Route::post('admin/long_names/', array('as'=>'adminLongNamesStore','uses'=>'Admin\LongNameController@store'));
Route::get('admin/long_names/{id}/show', array('as'=>'adminLongNamesShow','uses'=>'Admin\LongNameController@show'));
Route::get('admin/long_names/{id}/edit', array('as'=>'adminLongNamesEdit','uses'=>'Admin\LongNameController@edit'));
Route::patch('admin/long_names/{id}', array('as'=>'adminLongNamesUpdate','uses'=>'Admin\LongNameController@update'));
Route::delete('admin/long_names/destroy', array('as'=>'adminLongNamesDestroy','uses'=>'Admin\LongNameController@destroy'));

Route::get('admin/page_categories', array('as'=>'adminPageCategories','uses'=>'Admin\PageCategoryController@index'));
Route::get('admin/page_categories/create', array('as'=>'adminPageCategoriesCreate','uses'=>'Admin\PageCategoryController@create'));
Route::post('admin/page_categories/', array('as'=>'adminPageCategoriesStore','uses'=>'Admin\PageCategoryController@store'));
Route::get('admin/page_categories/{id}/show', array('as'=>'adminPageCategoriesShow','uses'=>'Admin\PageCategoryController@show'));
Route::get('admin/page_categories/{id}/view', array('as'=>'adminPageCategoriesView','uses'=>'Admin\PageCategoryController@view'));
Route::get('admin/page_categories/{id}/edit', array('as'=>'adminPageCategoriesEdit','uses'=>'Admin\PageCategoryController@edit'));
Route::patch('admin/page_categories/{id}', array('as'=>'adminPageCategoriesUpdate','uses'=>'Admin\PageCategoryController@update'));
Route::post('admin/page_categories/seo', array('as'=>'adminPageCategoriesSeo','uses'=>'Admin\PageCategoryController@seo'));
Route::delete('admin/page_categories/destroy', array('as'=>'adminPageCategoriesDestroy','uses'=>'Admin\PageCategoryController@destroy'));

Route::get('admin/pages/{slug}', array('as'=>'adminPages','uses'=>'Admin\PageController@index'));
Route::get('admin/pages/create', array('as'=>'adminPagesCreate','uses'=>'Admin\PageController@create'));
Route::post('admin/pages/', array('as'=>'adminPagesStore','uses'=>'Admin\PageController@store'));
Route::get('admin/pages/{id}/show', array('as'=>'adminPagesShow','uses'=>'Admin\PageController@show'));
Route::get('admin/pages/{id}/view', array('as'=>'adminPagesView','uses'=>'Admin\PageController@view'));
Route::get('admin/pages/{slug}/edit/{section}', array('as'=>'adminPagesEdit','uses'=>'Admin\PageController@edit'));
Route::patch('admin/pages/{id}', array('as'=>'adminPagesUpdate','uses'=>'Admin\PageController@update'));
Route::post('admin/pages/seo', array('as'=>'adminPagesSeo','uses'=>'Admin\PageController@seo'));
Route::delete('admin/pages/destroy', array('as'=>'adminPagesDestroy','uses'=>'Admin\PageController@destroy'));

Route::post('admin/pages/item/store/{slug}', array('as'=>'adminPagesStoreItem','uses'=>'Admin\PageController@storeItem'));
Route::post('admin/pages/{section}/item/store/{slug}', array('as'=>'adminPagesStoreItemFromPage','uses'=>'Admin\PageController@storeItemFromPage'));
Route::delete('admin/pages/item/delete', array('as'=>'adminPagesDeleteItem','uses'=>'Admin\PageController@deleteItem'));
Route::patch('admin/pages/item/update', array('as'=>'adminPagesUpdateItem','uses'=>'Admin\PageController@updateItem'));
Route::patch('admin/pages/item/update/form/{id}', array('as'=>'adminPagesUpdateItemFromPage','uses'=>'Admin\PageController@updateItemFromPage'));
Route::get('admin/pages/{slug}/item/edit/{id}', array('as'=>'adminPagesEditItem','uses'=>'Admin\PageController@editItem'));
Route::get('admin/pages/{slug}/item/create/', array('as'=>'adminPagesCreateItem','uses'=>'Admin\PageController@createItem'));
Route::get('admin/pages/{slug}/item/sort', array('as'=>'adminPagesSortItem','uses'=>'Admin\PageController@sortItem'));


Route::get('admin/banners', array('as'=>'adminBanners','uses'=>'Admin\BannerController@index'));
Route::get('admin/banners/create', array('as'=>'adminBannersCreate','uses'=>'Admin\BannerController@create'));
Route::post('admin/banners/', array('as'=>'adminBannersStore','uses'=>'Admin\BannerController@store'));
Route::get('admin/banners/{id}/show', array('as'=>'adminBannersShow','uses'=>'Admin\BannerController@show'));
Route::get('admin/banners/{id}/view', array('as'=>'adminBannersView','uses'=>'Admin\BannerController@view'));
Route::get('admin/banners/{id}/edit', array('as'=>'adminBannersEdit','uses'=>'Admin\BannerController@edit'));
Route::patch('admin/banners/{id}', array('as'=>'adminBannersUpdate','uses'=>'Admin\BannerController@update'));
Route::get('admin/banners/order', array('as'=>'adminBannersOrder','uses'=>'Admin\BannerController@order'));
Route::post('admin/banners/seo', array('as'=>'adminBannersSeo','uses'=>'Admin\BannerController@seo'));
Route::delete('admin/banners/destroy', array('as'=>'adminBannersDestroy','uses'=>'Admin\BannerController@destroy'));
Route::get('admin/banners/crop/url', array('as'=>'adminBannersCropUrl','uses'=>'Admin\BannerController@crop_url'));
Route::get('admin/banners/{id}/crop/{column}/{asset_id}', array('as'=>'adminBannersCropForm','uses'=>'Admin\BannerController@crop_form'));
Route::patch('admin/banners/{id}/crop', array('as'=>'adminBannersCrop','uses'=>'Admin\BannerController@crop'));

Route::post('admin/user_permissions/', array('as'=>'adminUserPermissionsStore','uses'=>'Admin\UserPermissionController@store'));
Route::get('admin/user_permissions/{id}/show', array('as'=>'adminUserPermissionsShow','uses'=>'Admin\UserPermissionController@show'));
Route::get('admin/user_permissions/{id}/view', array('as'=>'adminUserPermissionsView','uses'=>'Admin\UserPermissionController@view'));
Route::get('admin/user_permissions/{id}/edit', array('as'=>'adminUserPermissionsEdit','uses'=>'Admin\UserPermissionController@edit'));
Route::patch('admin/user_permissions/{id}', array('as'=>'adminUserPermissionsUpdate','uses'=>'Admin\UserPermissionController@update'));
Route::post('admin/user_permissions/seo', array('as'=>'adminUserPermissionsSeo','uses'=>'Admin\UserPermissionController@seo'));
Route::delete('admin/user_permissions/destroy', array('as'=>'adminUserPermissionsDestroy','uses'=>'Admin\UserPermissionController@destroy'));
Route::get('admin/user_permissions/{id}/permissions', array('as'=>'adminUserPermissions','uses'=>'Admin\UserPermissionController@index'));
Route::get('admin/user_permissions/{id}/create', array('as'=>'adminUserPermissionsCreate','uses'=>'Admin\UserPermissionController@create'));
Route::get('admin/user_permissions/order', array('as'=>'adminUserPermissionsOrder','uses'=>'Admin\UserPermissionController@order'));

Route::get('admin/user_roles', array('as'=>'adminUserRoles','uses'=>'Admin\UserRoleController@index'));
Route::get('admin/user_roles/create', array('as'=>'adminUserRolesCreate','uses'=>'Admin\UserRoleController@create'));
Route::post('admin/user_roles/', array('as'=>'adminUserRolesStore','uses'=>'Admin\UserRoleController@store'));
Route::get('admin/user_roles/{id}/show', array('as'=>'adminUserRolesShow','uses'=>'Admin\UserRoleController@show'));
Route::get('admin/user_roles/{id}/view', array('as'=>'adminUserRolesView','uses'=>'Admin\UserRoleController@view'));
Route::get('admin/user_roles/{id}/edit', array('as'=>'adminUserRolesEdit','uses'=>'Admin\UserRoleController@edit'));
Route::patch('admin/user_roles/{id}', array('as'=>'adminUserRolesUpdate','uses'=>'Admin\UserRoleController@update'));
Route::post('admin/user_roles/seo', array('as'=>'adminUserRolesSeo','uses'=>'Admin\UserRoleController@seo'));
Route::delete('admin/user_roles/destroy', array('as'=>'adminUserRolesDestroy','uses'=>'Admin\UserRoleController@destroy'));

Route::get('admin/articles', array('as'=>'adminArticles','uses'=>'Admin\ArticleController@index'));
Route::get('admin/articles/create', array('as'=>'adminArticlesCreate','uses'=>'Admin\ArticleController@create'));
Route::post('admin/articles/', array('as'=>'adminArticlesStore','uses'=>'Admin\ArticleController@store'));
Route::get('admin/articles/{id}/show', array('as'=>'adminArticlesShow','uses'=>'Admin\ArticleController@show'));
Route::get('admin/articles/{id}/view', array('as'=>'adminArticlesView','uses'=>'Admin\ArticleController@view'));
Route::get('admin/articles/{id}/edit', array('as'=>'adminArticlesEdit','uses'=>'Admin\ArticleController@edit'));
Route::patch('admin/articles/{id}', array('as'=>'adminArticlesUpdate','uses'=>'Admin\ArticleController@update'));
Route::post('admin/articles/seo', array('as'=>'adminArticlesSeo','uses'=>'Admin\ArticleController@seo'));
Route::delete('admin/articles/destroy', array('as'=>'adminArticlesDestroy','uses'=>'Admin\ArticleController@destroy'));
Route::get('admin/articles/crop/url', array('as'=>'adminArticlesCropUrl','uses'=>'Admin\ArticleController@crop_url'));
Route::get('admin/articles/{id}/crop/{column}/{asset_id}', array('as'=>'adminArticlesCropForm','uses'=>'Admin\ArticleController@crop_form'));
Route::patch('admin/articles/{id}/crop', array('as'=>'adminArticlesCrop','uses'=>'Admin\ArticleController@crop'));

Route::get('admin/emails', array('as'=>'adminEmails','uses'=>'Admin\EmailController@index'));
Route::get('admin/emails/create', array('as'=>'adminEmailsCreate','uses'=>'Admin\EmailController@create'));
Route::post('admin/emails/', array('as'=>'adminEmailsStore','uses'=>'Admin\EmailController@store'));
Route::get('admin/emails/{id}/show', array('as'=>'adminEmailsShow','uses'=>'Admin\EmailController@show'));
Route::get('admin/emails/{id}/view', array('as'=>'adminEmailsView','uses'=>'Admin\EmailController@view'));
Route::get('admin/emails/{id}/edit', array('as'=>'adminEmailsEdit','uses'=>'Admin\EmailController@edit'));
Route::patch('admin/emails/{id}', array('as'=>'adminEmailsUpdate','uses'=>'Admin\EmailController@update'));
Route::post('admin/emails/seo', array('as'=>'adminEmailsSeo','uses'=>'Admin\EmailController@seo'));
Route::delete('admin/emails/destroy', array('as'=>'adminEmailsDestroy','uses'=>'Admin\EmailController@destroy'));

//BASE APIs
Route::post('api/auth', array('as'=>'apiAuth','uses'=>'Api\AuthController@authenticate', 'middleware'=>['api','cors']));
Route::get('api/auth/logout', array('as'=>'apiAuthLogout','uses'=>'Api\AuthController@logout', 'middleware'=>['api','cors']));

Route::post('api/auth/register', array('as'=>'apiRegister','uses'=>'Api\AuthController@register', 'middleware'=>['api','cors']));
Route::post('api/auth/login', array('as'=>'apiLogin','uses'=>'Api\AuthController@login', 'middleware'=>['api','cors']));
Route::post('api/auth/get_user_details', array('as'=>'apiGetUserDetails','uses'=>'Api\AuthController@get_user_details', 'middleware'=>['api','cors', 'jwt-auth']));

Route::get('api/samples/find', array('as'=>'apiSamplesFind','uses'=>'Api\SampleController@find', 'middleware'=>['api','cors']));
Route::get('api/samples/get', array('as'=>'apiSamplesGet','uses'=>'Api\SampleController@get', 'middleware'=>['api','cors']));
Route::post('api/samples/store', array('as'=>'apiSamplesStore','uses'=>'Api\SampleController@store', 'middleware'=>['api','cors']));
Route::post('api/samples/update', array('as'=>'apiSamplesUpdate','uses'=>'Api\SampleController@update', 'middleware'=>['api','cors']));
Route::post('api/samples/destroy', array('as'=>'apiSamplesDestroy','uses'=>'Api\SampleController@destroy', 'middleware'=>['api','cors']));

Route::get('api/pages/find', array('as'=>'apiPagesFind','uses'=>'PageController@find', 'middleware'=>'cors'));
Route::get('api/pages/get', array('as'=>'apiPagesGet','uses'=>'PageController@get', 'middleware'=>'cors'));
Route::post('api/pages/store', array('as'=>'apiPagesStore','uses'=>'PageController@store', 'middleware'=>'cors'));
Route::post('api/pages/update', array('as'=>'apiPagesUpdate','uses'=>'PageController@update', 'middleware'=>'cors'));
Route::post('api/pages/destroy', array('as'=>'apiPagesDestroy','uses'=>'PageController@destroy', 'middleware'=>'cors'));

Route::get('admin/activities', array('as'=>'adminActivities','uses'=>'Admin\ActivityController@index'));
Route::get('admin/activities/{id}/show', array('as'=>'adminActivitiesShow','uses'=>'Admin\ActivityController@show'));
Route::get('admin/activities/{id}/view', array('as'=>'adminActivitiesView','uses'=>'Admin\ActivityController@view'));
