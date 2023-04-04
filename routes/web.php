<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//************************* Auth API *************************************************

$router->post('/login', [
    'as' => 'login_api', 'uses' => 'LoginApiController@login'
]);

$router->post('/login-web', [
    'as' => 'login_web_api', 'uses' => 'LoginApiController@login_web'
]);

$router->post('/register', [
    'as' => 'register_api', 'uses' => 'LoginApiController@register'
]);

$router->post('/get-profile', [
    'as' => 'get_profile', 'uses' => 'LoginApiController@getProfile'
]);

$router->post('/update-profile', [
    'as' => 'update_profile', 'uses' => 'LoginApiController@updateProfile'
]);

$router->post('/forgot-password', [
    'as' => 'forgot_password', 'uses' => 'LoginApiController@forgotPassword'
]);

$router->post('/license-add', [
    'as' => 'license_add', 'uses' => 'LoginApiController@licenseAdd'
]);

$router->post('/check-existing-client', [
    'as' => 'check_existing_client', 'uses' => 'LoginApiController@checkExistingClient'
]);

$router->post('/client-license-surrender', [
    'as' => 'client_license_surrender', 'uses' => 'LoginApiController@clientLicenseSurrender'
]);

$router->post('/client-product-payment', [
    'as' => 'client_product_payment', 'uses' => 'LoginApiController@clientProductPayment'
]);

$router->post('/test-api', [
    'as' => 'test_api', 'uses' => 'LoginApiController@testAPI'
]);

$router->group(['prefix' => '/payment'], function () use ($router) {
	
	$router->post('/', [
	    'as' => 'payment', 'uses' => 'PaymentController@payment'
	]);

	$router->post('/get-sales', [
	    'as' => 'get_sales', 'uses' => 'PaymentController@getSales'
	]);

	$router->post('/save-sales', [
	    'as' => 'save_sales', 'uses' => 'PaymentController@saveSales'
	]);

	$router->post('/delete-sales', [
	    'as' => 'delete_sales', 'uses' => 'PaymentController@deleteSales'
	]);

	$router->post('/get-renewal', [
	    'as' => 'get_renewal', 'uses' => 'PaymentController@getRenewal'
	]);

	$router->post('/save-renewal', [
	    'as' => 'save_renewal', 'uses' => 'PaymentController@saveRenewal'
	]);

	$router->post('/delete-renewal', [
	    'as' => 'delete_renewal', 'uses' => 'PaymentController@deleteRenewal'
	]);
});


//************************* Calculation API *************************************************

$router->group(['prefix' => '/calculation'], function () use ($router) {
	
	$router->post('/get-plans', [
	    'as' => 'get_plan', 'uses' => 'CalculationApiController@getPlans'
	]);

	$router->post('/get-plans-lifecell', [
	    'as' => 'get_plan_lifecell', 'uses' => 'CalculationApiController@getPlansLifeCell'
	]);

	$router->post('/get-age', [
	    'as' => 'get_age', 'uses' => 'CalculationApiController@getAge'
	]);

	$router->post('/get-mterm', [
	    'as' => 'get_mterm', 'uses' => 'CalculationApiController@getMTerm'
	]);

	$router->post('/get-pterm', [
	    'as' => 'get_pterm', 'uses' => 'CalculationApiController@getPTerm'
	]);

	$router->post('/get-mode', [
	    'as' => 'get_mode', 'uses' => 'CalculationApiController@getMode'
	]);

	$router->post('/get-sa-min-max', ['as' => 'get_sa_min_max', 'uses' => 'CalculationApiController@getSAMinMax'
	]);

	$router->post('/get-bonus', [
	    'as' => 'get_bonus', 'uses' => 'CalculationApiController@getBonus'
	]);

	$router->post('/premium-service', [
	    'as' => 'premium_service', 'uses' => 'CalculationApiController@getPremiumPrentation'
	]);

	$router->post('/get-sa-option', [
		'as' => 'sa_option', 'uses' => 'CalculationApiController@getSaOption'
	]);

});


//************************* LifePlus API *************************************************

$router->group(['prefix' => '/lifeplus'], function () use ($router) {
	
	$router->post('/get-masters', [
	    'as' => 'get_masters', 'uses' => 'LifePlusApiController@getMasters'
	]);

	$router->post('/save-masters', [
	    'as' => 'save_masters', 'uses' => 'LifePlusApiController@saveMasters'
	]);

	$router->post('/delete-masters', [
	    'as' => 'delete_masters', 'uses' => 'LifePlusApiController@deleteMasters'
	]);
	$router->post('/delete-masterss', [
	    'as' => 'delete_masterss', 'uses' => 'LifePlusApiController@deletemasterss'
	]);

});

//************************* Reports API *************************************************

$router->group(['prefix' => '/reports'], function () use ($router) {
	
	$router->post('/get-servicing-reports', [
	    'as' => 'get_servicing_reports', 'uses' => 'ReportsApiController@getServicingReports'
	]);

	$router->post('/save-servicing-reports', [
	    'as' => 'save_servicing_reports', 'uses' => 'ReportsApiController@saveServicingReports'
	]);

	$router->post('/delete-servicing-reports', [
	    'as' => 'delete_servicing_reports', 'uses' => 'ReportsApiController@deleteServicingReports'
	]);

	$router->post('/get-marketing-reports-setup', [
	    'as' => 'get_marketing_reports_setup', 'uses' => 'ReportsApiController@getMarketingSetupReports'
	]);

	$router->post('/save-marketing-reports-setup', [
	    'as' => 'save_marketing_reports_setup', 'uses' => 'ReportsApiController@saveMarketingSetupReports'
	]);

	$router->post('/get-servicing-reports-setup', [
	    'as' => 'get_servicing_reports_setup', 'uses' => 'ReportsApiController@getServicingSetupReports'
	]);

	$router->post('/save-servicing-reports-setup', [
	    'as' => 'save_servicing_reports_setup', 'uses' => 'ReportsApiController@saveServicingSetupReports'
	]);

	$router->post('/get-plan-setup', [
	    'as' => 'get_plan_setup', 'uses' => 'ReportsApiController@getPlanSetup'
	]);

	$router->post('/save-plan-setup', [
	    'as' => 'save_plan_setup', 'uses' => 'ReportsApiController@savePlanSetup'
	]);

	$router->post('/get-reminder-setup', [
	    'as' => 'get_reminder_setup', 'uses' => 'ReportsApiController@getReminderSetup'
	]);

	$router->post('/save-reminder-setup', [
	    'as' => 'save_reminder_setup', 'uses' => 'ReportsApiController@saveReminderSetup'
	]);

	$router->post('/get-gst-rate-setup', [
	    'as' => 'get_gst-rate_setup', 'uses' => 'ReportsApiController@getGSTRateSetup'
	]);

	$router->post('/save-gst-rate-setup', [
	    'as' => 'save_gst-rate_setup', 'uses' => 'ReportsApiController@saveGSTRateSetup'
	]);

	$router->post('/delete-gst-rate-setup', [
	    'as' => 'delete_gst_rate_setup', 'uses' => 'ReportsApiController@deleteGSTRateSetup'
	]);

	$router->post('/get-print-reports-data', [
	    'as' => 'get_print_reports_data', 'uses' => 'ReportsApiController@getReportsData'
	]);

	$router->post('/get-print-reports-datas', [
	    'as' => 'get_print_reports_datas', 'uses' => 'ReportsApiController@getReportsDatas'
	]);

	$router->post('/get-all-reminder-setup-data', [
	    'as' => 'get_all_reminder_setup_data', 'uses' => 'ReportsApiController@getAllReminderSetupData'
	]);

});

//************************* LifePlus API *************************************************

$router->group(['prefix' => '/lifecell'], function () use ($router) {
	
	$router->post('/get-bonus', [
	    'as' => 'get_bonus', 'uses' => 'BonusApiController@getBonus'
	]);

	$router->post('/save-bonus', [
	    'as' => 'save_bonus', 'uses' => 'BonusApiController@saveBonus'
	]);

	$router->post('/delete-bonus', [
	    'as' => 'delete_bonus', 'uses' => 'BonusApiController@deleteBonus'
	]);

});

//************************* Client API *************************************************

$router->group(['prefix' => '/client'], function () use ($router) {
	
	$router->post('/get-permissions', [
	    'as' => 'get_permissions', 'uses' => 'ClientApiController@getPermissions'
	]);

	$router->post('/save-permissions', [
	    'as' => 'save_permissions', 'uses' => 'ClientApiController@savePermissions'
	]);

	$router->post('/delete-permissions', [
	    'as' => 'delete_permissions', 'uses' => 'ClientApiController@deletePermissions'
	]);

	$router->post('/get-client-menu', [
	    'as' => 'get_client_menu', 'uses' => 'ClientApiController@getClientMenu'
	]);

	$router->post('/save-client-menu', [
	    'as' => 'save_client_menu', 'uses' => 'ClientApiController@saveClientMenu'
	]);

	$router->post('/delete-client-menu', [
	    'as' => 'delete_client_menu', 'uses' => 'ClientApiController@deleteClientMenu'
	]);

	$router->post('/get-roles', [
	    'as' => 'get_roles', 'uses' => 'ClientApiController@getRoles'
	]);

	$router->post('/save-roles', [
	    'as' => 'save_roles', 'uses' => 'ClientApiController@saveRoles'
	]);

	$router->post('/delete-roles', [
	    'as' => 'delete_roles', 'uses' => 'ClientApiController@deleteRoles'
	]);

	$router->post('/get-users', [
	    'as' => 'get_users', 'uses' => 'ClientApiController@getUsers'
	]);

	$router->post('/save-users', [
	    'as' => 'save_users', 'uses' => 'ClientApiController@saveUsers'
	]);

	$router->post('/delete-users', [
	    'as' => 'delete_users', 'uses' => 'ClientApiController@deleteUsers'
	]);

	$router->post('/get-demo-client', [
	    'as' => 'get_demo_client', 'uses' => 'ClientApiController@getDemoClient'
	]);

	$router->post('/save-demo-client', [
	    'as' => 'save_demo_client', 'uses' => 'ClientApiController@saveDemoClient'
	]);

});

//************************* Policy API *************************************************

$router->group(['prefix' => '/transaction'], function () use ($router) {
	
	$router->post('/get-policy', [
	    'as' => 'get_policy', 'uses' => 'PolicyController@getPolicy'
	]);

	$router->post('/save-policy', [
	    'as' => 'save_policy', 'uses' => 'PolicyController@savePolicy'
	]);

	$router->post('/save-policy-insurance', [
	    'as' => 'save_policy_insurance', 'uses' => 'PolicyController@savePolicyInsurance'
	]);

	$router->post('/delete-policy', [
	    'as' => 'delete_policy', 'uses' => 'PolicyController@deletePolicy'
	]);

	$router->post('/get-multi-policy', [
	    'as' => 'get_multi_policy', 'uses' => 'PolicyController@getMultiPolicy'
	]);

	$router->post('/save-multi-policy', [
	    'as' => 'save_multi_policy', 'uses' => 'PolicyController@saveMultiPolicy'
	]);

	$router->post('/delete-multi-policy', [
	    'as' => 'delete_multi_policy', 'uses' => 'PolicyController@deleteMultiPolicy'
	]);

	$router->post('/save-mode-change-action', [
	    'as' => 'save_mode_change_action', 'uses' => 'TransactionController@saveModeChangeAction'
	]);

	$router->post('/save-single-premium-posting', [
	    'as' => 'save_single_premium_posting', 'uses' => 'TransactionController@saveSinglePremiumPosting'
	]);

	$router->post('/save-multi-premium-posting', [
	    'as' => 'save_multi_premium_posting', 'uses' => 'TransactionController@saveMultiPremiumPosting'
	]);

	$router->post('/save-loan-entry', [
	    'as' => 'save_loan_entry', 'uses' => 'TransactionController@saveLoan'
	]);

});

//************************* Comm. Posting API *************************************************

$router->group(['prefix' => '/commission'], function () use ($router) {
	
	$router->post('/get-upload-pdf', [
	    'as' => 'upload_pdf', 'uses' => 'CommissionPostApiController@getuploadPdf'
	]);
	
	$router->post('/upload-pdf', [
	    'as' => 'upload_pdf', 'uses' => 'CommissionPostApiController@uploadPdf'
	]);

	$router->post('/delete-upload-pdf', [
	    'as' => 'upload_pdf', 'uses' => 'CommissionPostApiController@deleteuploadPdf'
	]);

	$router->post('/auto-commission', [
	    'as' => 'auto_commission', 'uses' => 'CommissionPostApiController@autoCommission'
	]);

});

$router->post('/upload-zipfile', [
    'as' => 'upload_zipfile', 'uses' => 'CommissionPostApiController@uploadZipFile'
]);

$router->post('/check-desktop-product-version', [
    'as' => 'check_desktop_product_version', 'uses' => 'CommissionPostApiController@checkDesktopProductVersion'
]);


$router->post('/conver-old-to-new', [
    'as' => 'conver_old_to_new', 'uses' => 'ConvertOldToNewController@converOldToNew'
]);


//************************* Bachat Policy API *************************************************

$router->group(['prefix' => '/bachat/transaction'], function () use ($router) {
	
	$router->post('/get-policy', [
	    'as' => 'get_policy', 'uses' => 'BachatPolicyController@getBachatPolicy'
	]);

	$router->post('/save-policy', [
	    'as' => 'save_policy', 'uses' => 'BachatPolicyController@saveBachatPolicy'
	]);

	$router->post('/delete-policy', [
	    'as' => 'delete_policy', 'uses' => 'BachatPolicyController@deleteBachatPolicy'
	]);

});

//************************* Bachat Receipt API *************************************************

$router->group(['prefix' => '/receipt/transaction'], function () use ($router) {
	
	$router->post('/get-receipt', [
	    'as' => 'get_receipt', 'uses' => 'BachatReceiptController@getBachatReceipt'
	]);

	$router->post('/save-receipt', [
	    'as' => 'save_receipt', 'uses' => 'BachatReceiptController@saveBachatReceipt'
	]);

	$router->post('/delete-receipt', [
	    'as' => 'delete_receipt', 'uses' => 'BachatReceiptController@deleteBachatReceipt'
	]);

});

//************************* Gi Policy API *************************************************






$router->group(['prefix' => '/bachat/loan'], function () use ($router) {
	
	$router->post('/get-loan', [
	    'as' => 'get_loan', 'uses' => 'BachatLoanController@getBachatLoan'
	]);

	$router->post('/save-loan', [
	    'as' => 'save_loan', 'uses' => 'BachatLoanController@saveBachatLoan'
	]);

	$router->post('/delete-loan', [
	    'as' => 'delete_loan', 'uses' => 'BachatLoanController@deleteBachatLoan'
	]);

});


$router->group(['prefix' => '/bachat/rdsetup'], function () use ($router) {
	
	$router->post('/get-rdsetup', [
	    'as' => 'get_loan', 'uses' => 'BachatrdsetupController@getBachatPolicy'
	]);

	$router->post('/save-rdsetup', [
	    'as' => 'save_rdsetup', 'uses' => 'BachatrdsetupController@saveBachatrdsetup'
	]);

	$router->post('/delete-rdsetup', [
	    'as' => 'delete_rdsetup', 'uses' => 'BachatrdsetupController@deleteBachatrdsetup'
	]);

});


// $router->group(['prefix' => '/bachat/insterstrate'], function () use ($router) {
	
	
// 	$router->post('/get-loan', [
// 	    'as' => 'get_loan', 'uses' => 'BachatYearlyInsetsrtrateController@getBachatinterstrate'
// 	]);


// 	$router->post('/save-interstrate', [
// 	    'as' => 'save_interstrate', 'uses' => 'BachatYearlyInsetsrtrateController@saveBachatinterstrate'
// 	]);

// 	$router->post('/delete-interstrate', [
// 	    'as' => 'delete_interstrate', 'uses' => 'BachatYearlyInsetsrtrateController@deleteBachatinterstrate'
// 	]);

// });

$router->group(['prefix' => '/bachat/insterstrate'], function () use ($router) {
	
	$router->post('/get-loan', [
	    'as' => 'get_loan', 'uses' => 'BachatYearlyInsetsrtrateController@getBachatPolicy'
	]);

	
	$router->post('/save-interstrate', [
	    'as' => 'save_interstrate', 'uses' => 'BachatYearlyInsetsrtrateController@saveBachatPolicy'
	]);

	$router->post('/delete-interstrate', [
	    'as' => 'delete_policy', 'uses' => 'BachatYearlyInsetsrtrateController@deleteBachatPolicy'
	]);

});






$router->group(['prefix' => '/investment-portfolio/assetstype'], function () use ($router) {
    
    $router->post('/get-assetstype', [
        'as' => 'get_assetstype', 'uses' => 'InvestmentPortfolioAssetsTypeController@getInvestmentPortfolioAssetsType'
    ]);

    $router->post('/save-assetstype', [
        'as' => 'save_assetstype', 'uses' => 'InvestmentPortfolioAssetsTypeController@saveInvestmentPortfolioAssetsType'
    ]);

    $router->post('/delete-assetstype', [
        'as' => 'delete_assetstype', 'uses' => 'InvestmentPortfolioAssetsTypeController@deleteInvestmentPortfolioAssetsType'
    ]);

});


$router->group(['prefix' => '/gi/gi_insurer'], function () use ($router) {
     $router->post('/get-gi-insurer', [
       'as' => 'get_gi_insurer', 'uses' => 'GIInsurerController@getGIInsurer'
     ]);
});

$router->group(['prefix' => '/gi/gi_system_insurer_products'], function () use ($router) {
    $router->post('/get-gi-insurer-product', [
       'as' => 'get_gi_insurer_product', 'uses' => 'GISystemInsurerproductsController@getSystemInsurerproducts'
    ]);
});

// $router->group(['prefix' => '/gi/gi_policy'], function () use ($router) {
//      $router->post('/save-gi-policy', [
//        'as' => 'get_gi_save_policy', 'uses' => 'GISystemInsurerproductsController@savePolicy'
//      ]);
// });


$router->group(['prefix' => '/gi/gi_policy'], function () use ($router) {
    
    $router->post('/get-policy', [
        'as' => 'get_policy', 'uses' => 'GiPolicyController@getGiPolicy'
    ]);

    $router->post('/save-policy', [
        'as' => 'save_policy', 'uses' => 'GiPolicyController@saveGiPolicy'
    ]);

    $router->post('/delete-policy', [
        'as' => 'delete_policy', 'uses' => 'GiPolicyController@deleteGiPolicy'
    ]);

});


$router->group(['prefix' => '/gi/gi_vehicle_system_related_question'], function () use ($router) {    
    $router->post('/get-question', [
        'as' => 'gi_vehicle_system_related_question', 'uses' => 'GIVehicleSystemRelatedQuestionsController@getGIVehicleSystemRelatedQuestions'
    ]);
});