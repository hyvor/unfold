<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Hyvor\Unfold\UnfoldMethod;

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

        return response()->json([
            'url' => $url,
            'method' => $method,
            'embedWrapInIframe' => $embedWrapInIframe,
            'embedMetaFallback' => $embedMetaFallback,
        ]);
    }
}
