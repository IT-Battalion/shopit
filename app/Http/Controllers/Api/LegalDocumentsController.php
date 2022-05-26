<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetAGBRequest;
use App\Http\Requests\SetImpressumRequest;
use App\Models\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LegalDocumentsController extends Controller
{
    public function impressum(Request $request): JsonResponse
    {
        try {
            $text = Document::where('text_type', 'impressum')->firstOrFail()->text_raw;
        } catch (ModelNotFoundException) {
            $text = "Hoppala! Leer! Bitte kontaktiere einen Administrator.";
        }
        return response()->json($text);
    }

    public function agb(Request $request): JsonResponse
    {
        try {
            $text = Document::where('text_type', 'agb')->firstOrFail()->text_raw;
        } catch (ModelNotFoundException) {
            $text = "Hoppala! Leer! Bitte kontaktiere einen Administrator.";
        }
        return response()->json($text);
    }

    public function setAGB(SetAGBRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $doc = Document::where('text_type', 'agb')->firstOrFail();
            $doc->update(['text_raw' => $data['text']]);
        } catch (ModelNotFoundException) {
            $doc = Document::create(['text_type' => 'agb', 'text_raw' => $data['text']]);
            $doc = Document::find($doc->id);
        }
        return response()->json($doc->refresh());
    }

    public function setImpressum(SetImpressumRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $doc = Document::where('text_type', 'impressum')->firstOrFail();
            $doc->update(['text_raw', $data['text']]);
        } catch (ModelNotFoundException) {
            $doc = Document::create(['text_type' => 'impressum', 'text_raw' => $data['text']]);
            $doc = Document::find($doc->id);
        }
        return response()->json($doc->refresh());
    }
}
