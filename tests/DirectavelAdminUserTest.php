<?php

use SevenUte\Directavel\Exceptions\DirectavelMissingAdminUser;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

test('updating project admin works', function () {
    $token = (string) Str::uuid();
    config()->set('directavel.admin_token', $token);

    $users = DB::table('directus_users')->get();
    expect($users[0]->token)->toBeNull();

    DirectavelFacade::updateProjectAdmin();

    $users = DB::table('directus_users')->get();
    expect($users[0]->token)->toEqual($token);
});

test('updating without admin user should fail', function () {
    DB::table('directus_users')->truncate();
    expect(function () {
        DirectavelFacade::updateProjectAdmin();
    })->toThrow(DirectavelMissingAdminUser::class);
});
