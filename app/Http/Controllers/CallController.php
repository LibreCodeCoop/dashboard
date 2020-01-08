<?php

namespace App\Http\Controllers;

use App\Call;
use App\Services\CallService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        return view('calls.index', compact('userId'));
    }

    public function play(Request $request) {
        $products = DB::select(
            DB::raw('SELECT path_s3 FROM '.env('DB_DATABASE_VOIP').'.gravacoes_s3 gs WHERE uuid = ?'),
            [$request->query('uuid')]
        );
        if ($products) {
            $uri = parse_url($products[0]->path_s3);
            $s3 = Storage::createS3Driver([
                'driver' => 's3',
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'region' => env('AWS_DEFAULT_REGION'),
                'bucket' => $uri['host']
            ]);
            return $s3->download($uri['path']);
        }
    }
}
