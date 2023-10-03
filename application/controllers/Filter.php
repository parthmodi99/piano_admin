<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Canada/Pacific');

class Filter extends CI_Controller {



	function __construct()

	{



		parent::__construct();

		$this->load->library('auth');

		if($this->auth->is_logged_in() == false)

			redirect(base_url());

		$this->load->helper('form');

		$this->load->model('admin_model','admin_model');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

		$this->output->set_header('Pragma: no-cache');

		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

		date_default_timezone_set('Europe/Paris');

	}

	public function index()

	{

		$this->load->view('datatrack');

	}

	public function getuserdata()
	{
		/*date_default_timezone_set('UTC');*/
		if($_REQUEST['time'] == 'Day')
		{

			$today_start = date('Y-m-d 00:00:01',strtotime(date($_REQUEST['duration'])));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_user = $this->admin_model->gettodayworkoutdata($today_start,$today_end);


			$this->load->view('filter_data',array('user'=>$get_user));

		}

    	//get this week data
		if($_REQUEST['time'] == 'Week')
		{
			$week = explode(' ',$_REQUEST['duration']);

			$this_week_start = date( "Y-m-d 00:00:01", strtotime(date($week[0])));
			if(isset($week[2]) && $week[2]!='')
			{
				$this_week_end   = date( "Y-m-d 23:59:00", strtotime(date($week[2])));
			}
			else
			{
				$this_week_end   = date( "Y-m-d 23:59:00", strtotime(date($week[0])));
			}


			$get_user = $this->admin_model->getweekworkoutdata($this_week_start,$this_week_end);

			$this->load->view('filter_week_user',array('user'=>$get_user));


		}

    	//get this Month data
		if($_REQUEST['time'] == 'Month')
		{
			$month = explode('/',$_REQUEST['duration']);

			$this_month_start = date(''.$month[1].'-'.$month[0].'-01 00:00:01');
			$this_month_end   = date(''.$month[1].'-'.$month[0].'-t 23:59:00');

			
			$get_user = $this->admin_model->getweekworkoutdata($this_month_start,$this_month_end);

			$this->load->view('filter_month_user',array('user'=>$get_user));


		}

    	//get this Year data
		if($_REQUEST['time'] == 'Year')
		{

			$this_year_start = date("".$_REQUEST['duration']."-m-d 00:00:01",strtotime("first day of january this year"));
			$this_year_end   = date("".$_REQUEST['duration']."-m-d 23:59:00",strtotime("December 31st"));

			

			$get_user = $this->admin_model->getweekworkoutdata($this_year_start,$this_year_end);

			$this->load->view('filter_year_user',array('user'=>$get_user));


		}
	}


	public function getdashboarddata()
	{
		if($_REQUEST['duration'] == 'Day')
		{
			$today_start = date('Y-m-d 00:00:01',strtotime("-2 days"));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_user = $this->admin_model->gettodayworkoutdashboarddata($today_start,$today_end);

			$get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($today_start,$today_end);

			$get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($today_start,$today_end);

			$new_user = 0;
			$old_user = 0;
			if(!empty($get_user))
			{
				foreach ($get_user as $value) 
				{
					if($value['new_user'] == 1)
					{
						$new_user++;
					}
					else
					{
						$old_user++;
					}
				}
			}
			$type = 'lastday';

			$this->load->view('dashboard_data',array('type'=>$type,'new_user' => $new_user,'old_user' => $old_user,'generated_user' => count($get_generated_refferal),'used_user' => count($get_used_refferal)));

		}

    	//get this week data
		if($_REQUEST['duration'] == 'Week')
		{
			$stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
	        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 8 days'));
	        $end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

	        /*print_r($start_date); print_r($end_date); die;*/

	        $get_user = $this->admin_model->gettodayworkoutdashboarddata($start_date,$end_date);

	        $get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($start_date,$end_date);

			$get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($start_date,$end_date);

			$new_user = 0;
			$old_user = 0;
			if(!empty($get_user))
			{
				foreach ($get_user as $value) 
				{
					if($value['new_user'] == 1)
					{
						$new_user++;
					}
					else
					{
						$old_user++;
					}
				}
			}
			$type = 'lastweek';

			//$this->load->view('dashboard_data',array('type'=>$type,'new_user' => $new_user,'old_user' => $old_user));
			$this->load->view('dashboard_data',array('type'=>$type,'new_user' => $new_user,'old_user' => $old_user,'generated_user' => count($get_generated_refferal),'used_user' => count($get_used_refferal)));
		}

    	//get this Month data
		if($_REQUEST['duration'] == 'Month')
		{
			$start_date = date('Y-m-d H:i:s', strtotime('today - 31 days'));
			$end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));
			
			$get_user = $this->admin_model->gettodayworkoutdashboarddata($start_date,$end_date);

			$get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($start_date,$end_date);

			$get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($start_date,$end_date);

			$new_user = 0;
			$old_user = 0;
			if(!empty($get_user))
			{
				foreach ($get_user as $value) 
				{
					if($value['new_user'] == 1)
					{
						$new_user++;
					}
					else
					{
						$old_user++;
					}
				}
			}
			$type = 'lastmonth';

			//$this->load->view('dashboard_data',array('type'=>$type,'new_user' => $new_user,'old_user' => $old_user));

			$this->load->view('dashboard_data',array('type'=>$type,'new_user' => $new_user,'old_user' => $old_user,'generated_user' => count($get_generated_refferal),'used_user' => count($get_used_refferal)));
		}
	}

	public function lastday()
	{
		$type = $_REQUEST['type'];
		if($type == 'new_user')
		{
			$today_start = date('Y-m-d 00:00:01',strtotime("-2 days"));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_user = $this->admin_model->gettodayworkoutnewuserdata($today_start,$today_end);

			$data['user'] = $get_user;

			$data['type'] = 'New';

			$this->load->view('lastday',$data);
		}
		elseif ($type == 'old_user') 
		{
			$today_start = date('Y-m-d 00:00:01',strtotime("-2 days"));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_user = $this->admin_model->gettodayworkoutolduserdata($today_start,$today_end);

			$data['user'] = $get_user;

			$data['type'] = 'Old';

			$this->load->view('lastday',$data);
			/*echo "<pre>";
			print_r($get_user); die;*/

		}
		else
		{
			redirect('dashboard');
		}

		
	}


	public function lastweek()
	{
		$type = $_REQUEST['type'];
		if($type == 'new_user')
		{
			$stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
	        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 8 days'));
	        $end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

	        $get_user = $this->admin_model->getweekworkoutnewuserdata($start_date,$end_date);

			$data['user'] = $get_user;

			$data['type'] = 'New';

			$this->load->view('lastweek',$data);
		}
		elseif ($type == 'old_user') 
		{
			$stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
	        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 8 days'));
	        $end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

			$get_user = $this->admin_model->getweekworkoutolduserdata($start_date,$end_date);

			$data['user'] = $get_user;

			$data['type'] = 'Old';

			$this->load->view('lastweek',$data);
			/*echo "<pre>";
			print_r($get_user); die;*/

		}
		else
		{
			redirect('dashboard');
		}

		
	}


	public function lastmonth()
	{
		$type = $_REQUEST['type'];
		if($type == 'new_user')
		{
			$start_date = date('Y-m-d H:i:s', strtotime('today - 31 days'));
			$end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));		
			$get_user = $this->admin_model->getweekworkoutnewuserdata($start_date,$end_date);

			$data['user'] = $get_user;

			$data['type'] = 'New';

			$this->load->view('lastmonth',$data);
		}
		elseif ($type == 'old_user') 
		{
			$start_date = date('Y-m-d H:i:s', strtotime('today - 31 days'));
			$end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));	
			$get_user = $this->admin_model->getweekworkoutolduserdata($start_date,$end_date);

			$data['user'] = $get_user;

			$data['type'] = 'Old';

			$this->load->view('lastmonth',$data);
			/*echo "<pre>";
			print_r($get_user); die;*/

		}
		else
		{
			redirect('dashboard');
		}

		
	}

	public function generated()
	{
		if($_REQUEST['type'] == 'all_user')
		{
			$get_generated_refferal = $this->admin_model->gettotalrefferalgenerateddashboarddata();
		}
		elseif($_REQUEST['type'] == 'lastday')
		{
			$today_start = date('Y-m-d 00:00:01',strtotime("-2 days"));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($today_start,$today_end);
		}
		elseif($_REQUEST['type'] == 'lastweek')
		{
			$stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
	        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 8 days'));
	        $end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

	        /*print_r($start_date); print_r($end_date); die;*/

	        $get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($start_date,$end_date);
		}
		elseif($_REQUEST['type'] == 'lastmonth')
		{
			$start_date = date('Y-m-d H:i:s', strtotime('today - 31 days'));
			$end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

			$get_generated_refferal = $this->admin_model->gettodayrefferalgenerateddashboarddata($start_date,$end_date);
		}
		else{
			redirect('dashboard');
		}
		$data['user'] = $get_generated_refferal;
		$this->load->view('generated_refferal',$data);

	}

	public function used()
	{
		if($_REQUEST['type'] == 'all_user')
		{
			$get_used_refferal = $this->admin_model->gettotalrefferaluseddashboarddata();
		}
		elseif($_REQUEST['type'] == 'lastday')
		{
			$today_start = date('Y-m-d 00:00:01',strtotime("-2 days"));

			$today_end = date('Y-m-d H:i:s',strtotime($today_start . '+1 day'));

			$get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($today_start,$today_end);
		}
		elseif($_REQUEST['type'] == 'lastweek')
		{
			$stop_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d H:i:s')));
	        $start_date = date('Y-m-d 00:00:01', strtotime($stop_date.' - 8 days'));
	        $end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

	        /*print_r($start_date); print_r($end_date); die;*/

	        $get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($start_date,$end_date);
		}
		elseif($_REQUEST['type'] == 'lastmonth')
		{
			$start_date = date('Y-m-d H:i:s', strtotime('today - 31 days'));
			$end_date = date('Y-m-d 00:00:01',strtotime("-1 days"));

			$get_used_refferal = $this->admin_model->gettodayrefferaluseddashboarddata($start_date,$end_date);
		}
		else{
			redirect('dashboard');
		}
		$data['user'] = $get_used_refferal;
		$this->load->view('used_refferal',$data);

	}

}

