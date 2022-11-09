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

function data_tree($data, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($data as $item) {
        if ($item['parent_id'] == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;
            unset($data[$item['id']]);
            $child = data_tree($data, $item['id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}
