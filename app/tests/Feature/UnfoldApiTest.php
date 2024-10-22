<?php

it('returns Unfold response', function () {

    $response = $this->postJson('/unfold', [
        'url' => 'https://supun.io'
    ]);

    $response->assertStatus(200);
});
