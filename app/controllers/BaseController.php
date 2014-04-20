<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$member_id = Session::get('member_id');
			$level = Session::get('level');
			$is_admin = Session::get('is_admin');

			View::share('member_id', $member_id);
			View::share('level', $level);
			View::share('is_admin', $is_admin);

			$this->layout = View::make($this->layout);
		} 
	}
}