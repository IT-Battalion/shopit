<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        } catch (ModelNotFoundException $ex) {
            $text = "Hoppala! Leer! Bitte kontaktiere einen Administrator.";
        }
        return response()->json($text);
    }

    public function agb(Request $request): JsonResponse
    {
        try {
            $text = Document::where('text_type', 'agb')->firstOrFail()->text_raw;
        } catch (ModelNotFoundException $ex) {
            $text = "Hoppala! Leer! Bitte kontaktiere einen Administrator.";
        }
        return response()->json($text);
    }
}
