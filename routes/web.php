<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::post(config('git-webhook.route', '/webhooks/github'), function () {
    $github_hash = request()->header('X-Hub-Signature');
    $github_payload = request()->getContent();

    $secret = config('git-webhook.secret');
    $sent_hash = 'sha1=' . hash_hmac('sha1', $github_payload, $secret, false);

    if ($github_hash === null || hash_equals($github_hash, $sent_hash)) {
        Artisan::queue('github:deploy');
        return response('', 200);
    } else {
        return response('', 403);
    }
});
