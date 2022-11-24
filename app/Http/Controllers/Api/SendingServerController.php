<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SendingServer;
use Auth;
use Response;

/**
 * /api/v1/sending_servers - API controller for managing sending servers.
 */
class SendingServerController extends Controller
{
    /**
     * Display all sending servers.
     *
     * GET /api/v1/sending_servers
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('api')->user();

        // authorize
        if (!$user->admin->can('readAll', new SendingServer())) {
            return Response::json(['message' => 'Unauthorized'], 401);
        }

        $servers = SendingServer::getAll()
            ->select('uid', 'name', 'created_at', 'updated_at')
            ->get();

        return Response::json($servers, 200);
    }
}
