<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseController extends Controller
{
	protected $user;

	public function __construct(AuthManager $auth)
	{
		$this->middleware('web');
		$this->user = $auth->guard('api')->user() ?: $auth->guard('web')->user();
	}

	protected function sendError($msg, $error_code = 400)
	{
		throw new HttpResponseException(
			response()->json([
				'msg' => $msg,
				'status' => 'error'
			], $error_code)
		);
	}

	protected function sendSuccess($msg, $response_meta = [])
	{
		return response()->json(array_merge([
			'msg' => $msg,
			'status' => 'success',
			'event' => 'done',
		], $response_meta), 200);
	}

	public function index()
	{
		return (Auth::user()) ? view('app.index') : view('home.index');
	}

	public function app()
	{
		return (Auth::user()) ? view('app.index') : view('app.login');
	}

	public function back()
	{
		return back();
	}

	public function error500()
	{
		return view('index');
	}

	public function error404()
	{
		return view('index');
	}
}
