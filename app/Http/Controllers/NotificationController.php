<?php

    namespace App\Http\Controllers;

    use App\Helpers\NotificationHelper;
    use Illuminate\Http\Request;

    class NotificationController extends Controller
    {
        public function send(Request $request)
        {
            $notification_helper = new NotificationHelper();
            $data = [
                'message' => $request->post('message'),
                'to_number' => $request->post('to_number'),
            ];
            return response()->json($notification_helper->send($data));
        }
    }
