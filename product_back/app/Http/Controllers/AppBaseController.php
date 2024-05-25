<?php

namespace App\Http\Controllers;

use Deto\Generator\Utils\ResponseUtil;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Response;

/**
 * @SWG\Swagger(
 *   basePath="/$API_PREFIX$/$API_VERSION$",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(AppBaseController::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(AppBaseController::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
    protected function proccesRelationWithRequest(Relation $relation, array $items)
    {
        $relation->getResults()->each(function ($model) use ($items) {
            foreach ($items as $item) {
                if ($model->id === ($item['id'] ?? null)) {
                    $model->fill($item)->save();
                    return;
                }
            }

            return $model->delete();
        });

        foreach ($items as $item) {
            if ($item['id'] < 1)
                $relation->create($item);
        };
    }
}
