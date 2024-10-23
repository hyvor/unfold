<?php

namespace App\Http\Controllers;

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
            'method' => 'nullable|string|in:link,embed,link_embed',
            'embedWrapInIframe' => 'nullable|boolean',
            'embedMetaFallback' => 'nullable|boolean',
        ]);

        $url = (string) $request->string('url');
        $method = $request->string('method', 'link');
        $method = UnfoldMethod::from($method);
        $embedWrapInIframe = $request->boolean('embedWrapInIframe', true);
        $embedMetaFallback = $request->boolean('embedMetaFallback');

        try {
            $response = Unfold::unfold(
                $url,
                $method,
                new UnfoldConfig(
                    $embedWrapInIframe,
                    $embedMetaFallback,
                   httpClient: app()->bound('httpClient') ? app('httpClient') : null
                )
            );
        } catch (UnfoldException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return response()->json($response);
    }
}
