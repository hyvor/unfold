<?php

namespace App\Http\Controllers;

use Hyvor\Unfold\Embed\Iframe\PrivacyIframe;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Controller
{
    public function init(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url',
            'method' => 'nullable|string|in:embed,link',
        ]);

        $url = (string) $request->string('url');
        $method = (string) $request->string('method', 'link');
        try {
            if ($method === 'embed') {
                $response = Unfold::embed(
                    $url,
                    new UnfoldConfig(
                        app()->bound('httpClient') ? app('httpClient') : null
                    )
                );
            } else {
                $response = Unfold::link(
                    $url,
                    new UnfoldConfig(
                        app()->bound('httpClient') ? app('httpClient') : null
                    )
                );
            }
        } catch (UnfoldException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return response()->json($response);
    }

    public function iframe(Request $request): string
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = (string) $request->string('url');

        try {
            $data = Unfold::embed($url);
        } catch (UnfoldException) {
            return 'This URL cannot be embedded.';
        }

        return PrivacyIframe::wrap($data->embed);
    }
}
