<?php

namespace TomatoPHP\FilamentAlerts\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use TomatoPHP\FilamentAlerts\Models\NotificationsTemplate;
use TomatoPHP\FilamentAlerts\Models\UserNotification;
use TomatoPHP\FilamentAlerts\Models\UserReadNotification;
use TomatoPHP\FilamentAlerts\Models\UserToken;

class NotificationsController extends Controller
{
    /**
     * @var string
     */
    public string $model;

    public function __construct()
    {
        if(auth()->user()){
            $this->model = get_class(auth()->user()->getModel());
        }
        else {
            $this->model = config('filament-alerts.api-model') ?? User::class;
        }

    }

    /**
     * Notifications List
     *
     * Show All notifications of current login user by token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $searchItems = $request->except([
            'page',
            'limit'
        ]);

        $limit = $request->limit ?? 10;

        $notifications = UserNotification::where([
            'model_type' => $this->model,
            'model_id' => auth()->user()->id,
        ])
            ->select([
                "id",
                "template_id",
                "title",
                "description",
                "type",
                "url",
                "data",
                "created_at"
            ])
            ->orderBy('id','desc')
            ->paginate($limit);

        foreach ($notifications as $item) {
            $item->icon = $item->template ? count($item->template->getMedia('image')) ? $item->template->getMedia('image')->first()->getUrl() : null : null;
            $item->is_read = UserReadNotification::where('model_type', $this->model)
                ->where('model_id', $request->user()->id)
                ->where('notification_id', $item->id)->first() ? 1 : 0;
            unset($item->template);
        }

        return response()->json([
            "success" => true,
            "data" => $notifications,
            "message" => "Notifications List"
        ], 200);

    }

    /**
     * Clear Notifications
     *
     * Clear all notifications of current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {

        UserNotification::where('model_type', $this->model)->where('model_id', auth()->user()->id)->delete();

        return response()->json([
            "success" => true,
            "message" => __('Notifications Has Been Cleared'),
            "data" => []
        ]);
    }

    /**
     * Delete Notification
     *
     * Delete Selected notifications by ID
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $notification = UserNotification::where([
            'id' => $id,
            'model_id' => auth()->user()->id,
        ])->first();
        if($notification){
            $notification->delete();
            return response()->json([
                "success" => true,
                "message" => __('Notifications Has Been Deleted'),
                "data" => []
            ]);
        }else{
            return response()->json([
                "success" => true,
                "message" => __('There is no Notifications here to deleted'),
                "data" => []
            ]);
        }


    }

    /**
     * Make Notification as Read
     *
     * You can make the selected notification by id flag to be is_read=true
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $id)
    {
        $notifications = UserNotification::find($id);

        if ($notifications) {

            $notifications = new UserReadNotification();
            $notifications->model_type = $this->model;
            $notifications->model_id = $request->user()->id;
            $notifications->notification_id = $id;
            $notifications->read = true;
            $notifications->open = true;
            $notifications->save();

            return response()->json([
                "success" => true,
                "message" => __('Notifications Has Been Marked As Read'),
                "data" => []
            ]);
        }
        return response()->json([
            "success" => false,
            "message" => __('Notifications Not Found'),
            "data" => []
        ], 404);
    }

    /**
     * Update Notification Token
     *
     *
     * update notification token for FCM integration token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setting(Request $request)
    {
        $request->validate([
           "token" => "nullable|string",
           "provider" => "nullable|string"
        ]);

        if ($request->has('token') && $request->get('token')) {
            $checkIfTokenExists = UserToken::where('model_type', $this->model)
                ->where('provider', $request->has('provider') ? $request->get('provider')  : "fcm-api")
                ->where('model_id', $request->user()->id)->first();

            if($checkIfTokenExists){
                $checkIfTokenExists->provider = $request->has('provider') ? $request->get('provider')  : "fcm-api";
                $checkIfTokenExists->provider_token = $request->get('token');
                $checkIfTokenExists->save();
            }
            else {
                $token = new UserToken();
                $token->model_type = $this->model;
                $token->model_id = $request->user()->id;
                $token->provider = $request->has('provider') ? $request->get('provider')  : "fcm-api";
                $token->provider_token = $request->get('token');
                $token->save();
            }

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => __('Your Notifications Has Been On')
            ], 200);
        }

        UserToken::where('model_type', $this->model)
            ->where('provider', $request->has('provider') ? $request->get('provider')  : "fcm-api")
            ->where('model_id', $request->user()->id)
            ->delete();

        return response()->json([
            "success" => true,
            "message" => __('Your Notifications Has Been Off'),
            "body" => []
        ]);
    }

}
