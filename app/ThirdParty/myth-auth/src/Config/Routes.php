<?php

/*
 * Myth:Auth routes file.
 */
$routes->group('', ['namespace' => 'Myth\Auth\Controllers'], function ($routes) {
    // User Profile
    $routes->get('thong-tin-ca-nhan', 'AuthController::userProfile', ['as' => 'user.auth.userProfile']);

    // Update Infomation
    $routes->post('update-profile', 'AuthController::updateProfile', ['as' => 'user.auth.updateProfile']);

    // Login/out
    $routes->get('dang-nhap', 'AuthController::login', ['as' => 'login']);
    $routes->post('dang-nhap', 'AuthController::attemptLogin');
    $routes->get('dang-xuat', 'AuthController::logout');

    // Registration
    $routes->get('dang-ky', 'AuthController::register', ['as' => 'register']);
    $routes->post('dang-ky', 'AuthController::attemptRegister');
    $routes->post('checkExistsEmail', 'AuthController::checkExistsEmail', ['as' => 'user.auth.checkExistsEmail']);

    // Activation
    $routes->get('kich-hoat-tai-khoan', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('quen-mat-khau', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('quen-mat-khau', 'AuthController::attemptForgot');
    $routes->get('dat-lai-mat-khau', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('dat-lai-mat-khau', 'AuthController::attemptReset');
});
