<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.08.2017
 * Time: 4:58
 */

namespace App\Http\Controllers;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller {

    protected $statusCode = 200;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statisCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    public function respondDeniedPermission($message = 'Denied')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @return mixed
     */
    protected function respondCreated($message)
    {
        return $this->setStatusCode(201)
            ->respond($message);
    }

    /**
     * @param $lessons
     * @return mixed
     */
    protected function respondWithPagination(LengthAwarePaginator $lessons, $data)
    {
        $data = array_merge($data, [
                'paginator' => [
                    'total_count' => $lessons->total(),
                    'total_pages' => ceil($lessons->total() / $lessons->perPage()),
                    'current_page' => $lessons->currentPage(),
                    'limit' => $lessons->perPage()
                ]
            ]
        );

        return $this->respond($data);
    }

}