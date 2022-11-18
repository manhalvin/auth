<?php

function isRole($dataArr, $moduleName, $role = 'view')
{
    if (!empty($dataArr[$moduleName])) {
        $roleArr = $dataArr[$moduleName];
        if (!empty($roleArr) && in_array($role, $roleArr)) {
            return true;
        }
    }
    return false;
}

function sendSuccess($result, $message, $code = 200)
{
    $response = [
        'success' => true,
        'data' => $result,
        'message' => $message,
        'status' => $code,
    ];

    return response()->json($response, $code);
}

function sendError($error, $errorMessages = [], $code = 404)
{
    $response = [
        'success' => false,
        'message' => $error,
        'data' => $errorMessages,
        'status' => $code
    ];

    return response()->json($response, $code);
}




