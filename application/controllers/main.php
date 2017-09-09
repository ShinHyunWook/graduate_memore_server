<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

     	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->model('memore_m');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        
	}
    
    public function register() {
        date_default_timezone_set("Asia/Seoul");
        $joinDate =  date("Y-m-d H:i:s",time());
        $member_data = array(
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'password' => $_POST['password'],
            'phoneNumber' => $_POST['phone'],
            'joinDate' => $joinDate
        );

        $data['result'] = $this->memore_m->insert_member($member_data);
        $this->load->view('register_v.php',$data);
    }
    
    public function login(){
        $login_data = array(
            'email' => $_POST['id'],
            'password' => $_POST['pw']
        );
        
        $data['result'] = $this->memore_m->login($login_data);
        $this->load->view('login_v.php',$data);
    }
    
    public function set_info(){
        $input_data = array(
            'email' => $_POST['email']
        );
        $data['result'] = $this->memore_m->set_info($input_data);
        $this->load->view('set_info_v',$data);
    }
    
    public function save_location(){
        $input_data = array(
            'user_id' => $_POST['my_id'],
            'loc_time' => $_POST['loc_time'],
            'loc_data' =>$_POST['loc_data']
        );
        $data['result'] = $this->memore_m->save_location($input_data);
        $this->load->view('save_location_v',$data);
    }
    
    public function get_location(){
        $input_data = array(
            'email' => $_POST['email'],
            'loc_time' => $_POST['loc_time']
        );

        $data['result'] = $this->memore_m->get_location($input_data);
        $this->load->view('get_location_v',$data);
    }
    
    public function get_location_between(){
        $input_data = array(
            'email' => $_POST['email'],
            's_loc_time' => $_POST['start_date'],
            'e_loc_time' => $_POST['end_date']
        );

        $data['result'] = $this->memore_m->get_location_between($input_data);
        $this->load->view('get_location_between_v',$data);
    }
    
    
    public function get_location_id(){
        $input_data = array(
            'my_id' => $_POST['my_id'],
            'loc_time' => $_POST['loc_time']
        );

        $data['result'] = $this->memore_m->get_location_id($input_data);
        $this->load->view('get_location_v',$data);
    }    
    
    public function get_location_between_id(){
        $input_data = array(
            'user_id' => $_POST['my_id'],
            's_loc_time' => $_POST['start_loc_date'],
            'e_loc_time' => $_POST['end_loc_date']
        );

        $data['result'] = $this->memore_m->get_location_between_id($input_data);
        $this->load->view('get_location_between_v',$data);
    }  
    
    
//    public function get_location(){
//        $input_data = array(
//            'email' => $_POST['email'],
//            'start_date' => $_POST['start_date'],
//            'end_date' => $_POST['end_date']
//        );
//
//        $data['result'] = $this->memore_m->get_location($input_data);
//        $this->load->view('get_location_v',$data);
//    }
//    
    public function search_person(){
        $input_data = array(
            'email' => $_POST['email']
        );
        $data['result'] = $this->memore_m->search_person($input_data);
        $this->load->view('search_person_v',$data);
    }
    
    public function friend_request(){
        $input_data = array(
            'friend_one' => $_POST['friend_one'],
            'friend_two' => $_POST['friend_two']
        );
        $data['result'] = $this->memore_m->friend_request($input_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function search_friend(){
        $input_data = array(
            'my_id' => $_POST['my_id'],
            'friend_id' => $_POST['friend_id']
        );
        $data['result'] = $this->memore_m->search_friend($input_data);
        $this->load->view('search_friend_v',$data);
    }
    
    public function cancel_friend_request(){
        $input_data = array(
            'friend_one' => $_POST['friend_one'],
            'friend_two' => $_POST['friend_two']
        );
        $data['result'] = $this->memore_m->cancel_friend_request($input_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function accept_friend(){
        $input_data = array(
            'friend_one' => $_POST['friend_one'],
            'friend_two' => $_POST['friend_two']
        );
        $data['reault'] = $this->memore_m->accept_friend($input_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function reject_friend(){
        $input_data = array(
            'friend_one' => $_POST['friend_one'],
            'friend_two' => $_POST['friend_two']
        );
        $data['reault'] = $this->memore_m->reject_friend($input_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function delete_friend(){
        $input_data = array(
            'friend_one' => $_POST['friend_one'],
            'friend_two' => $_POST['friend_two']
        );
        $data['reault'] = $this->memore_m->delete_friend($input_data);
        $this->load->view('friend_request_v',$data);        
    }
    
    public function get_friend_list(){
        $input_data = array(
//            'u_id' => '1'
            'u_id' => $_POST['my_id']
        );
        $data['result'] = $this->memore_m->get_friend_list($input_data);
        $this->load->view('friend_list_v',$data);
    }
    
    public function get_search_friend_list(){
        $input_data = array(
            'u_id' => $_POST['my_id'],
            'name' => $_POST['name']
        );
        $data['result'] = $this->memore_m->get_search_friend_list($input_data);
        $this->load->view('friend_list_v',$data);
    }
    
    public function get_friend_request_list(){
        $input_data = array(
            'my_id' => $_POST['my_id']
        );
        $data['result'] = $this->memore_m->get_friend_request_list($input_data);
        $this->load->view('friend_list_v',$data);
    }
    
    public function user_info_update() {
        $member_data = array(
            'my_id' => $_POST['my_id'],
            'profile' => $_POST['profile'],
            'name' => $_POST['name'],
            'password' => $_POST['password'],
            'phoneNumber' => $_POST['phone']
        );

        $data['result'] = $this->memore_m->user_info_update($member_data);
        $this->load->view('friend_request_v',$data);
    }    
    
    public function insert_cut(){
        $imageNameList = $_POST['elements'];
        $imageNameList = json_encode($imageNameList);
        $insert_data = array(
            'image_name' => $imageNameList,
            'user_id' => $_POST['my_id'],
            'caption' => $_POST['caption'],
            'location_data' => $_POST['location_data'],
            'tag_id_list' => $_POST['tag_id_list']
        );
        $data['result'] = $this->memore_m->insert_cut($insert_data);
        $this->load->view('save_location_v',$data);
    }
    
    public function get_cut_image_locID(){
        $insert_data = array(
            'location_id' => $_POST['loc_id']
        );
        $data['result'] = $this->memore_m->get_cut_image_locID($insert_data);
        $this->load->view('get_cut_image_locID_v',$data); 
    }
    
//        public function get_cut_image_locID(){
//        $insert_data = array(
//            'location_id' => $_POST['loc_id']
//        );
//        $data['result'] = $this->memore_m->get_cut_image_locID($insert_data);
//        $this->load->view('get_cut_image_locID_v',$data);
//    }
    
    public function get_tag_friend_list(){
        $insert_data = array(
            'tag_list' => $_POST['tag_id_list']
        );
        $data['result'] = $this->memore_m->get_tag_friend_list($insert_data);
        $this->load->view('get_tag_friend_list_v',$data);
    }
    
//    public function post_feed(){
//        date_default_timezone_set("Asia/Seoul");
//        $date = date("Y-m-d H:i:s",time());
//        $cut_list = $_POST['elements'];
//        $cut_list = json_encode($cut_list);
//        $insert_data = array(
//            'cut_id' => $cut_list,
//            'user_id' => $_POST['my_id'],
//            'location_date' => $_POST['location_date'],
//            'post_time' => $date
//        );
//        $data['result'] = $this->memore_m->post_feed($insert_data);
//        $this->load->view('friend_request_v',$data);
//    }
    
    public function post_feed(){
        date_default_timezone_set("Asia/Seoul");
        $date = date("Y-m-d H:i:s",time());
        $cut_list = $_POST['elements'];
        $cut_list = json_encode($cut_list);
        $insert_data = array(
            'cut_id' => $cut_list,
            'user_id' => $_POST['my_id'],
            'start_loc_date' => $_POST['start_date'],
            'end_loc_date' => $_POST['end_date'],
            'post_time' => $date
        );
        $data['result'] = $this->memore_m->post_feed($insert_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function get_feed(){
        $insert_data = array(
            'user_id' => $_POST['my_id']
        );
        $data['result'] = $this->memore_m->get_feed($insert_data);
        $this->load->view('get_feed_v',$data);
    }
    
    public function get_cut_image_cut_id(){
        $insert_data = array(
            'cut_list' => $_POST['cut_list']
        );
        $data['result'] = $this->memore_m->get_cut_image_cut_id($insert_data);
        $this->load->view('get_cut_image_cut_id_v',$data);
    }
    
    public function get_latest_date(){
        $insert_data = array(
            'email' => $_POST['email']
        );
        $data['result'] = $this->memore_m->get_latest_date($insert_data);
        $this->load->view('get_latest_date_v',$data);
    }
    
    public function add_thumb(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id'],
            'user_id' => $_POST['my_id'],
            'cut_id' => $_POST['cut_id'],
            'image_name' => $_POST['image_name']
        );
        $data['result'] = $this->memore_m->add_thumb($insert_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function set_thumb_status(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id'],
            'user_id' => $_POST['user_id']
        );
        $data['result'] = $this->memore_m->set_thumb_status($insert_data);
        $this->load->view('set_thumb_status_v',$data);
    }
    
    public function delete_thumb(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id'],
            'user_id' => $_POST['user_id']
        );
        $data['result'] = $this->memore_m->delete_thumb($insert_data);
        $this->load->view('friend_request_v',$data);
    }
    
    public function set_feed_content(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id']
        );
        $data['result'] = $this->memore_m->set_feed_content($insert_data);
        $this->load->view('get_feed_v',$data);
    }
    
    public function get_cut_images(){
        $insert_data = array(
            'cut_id' => $_POST['cut_id']
        );
        $data['result'] = $this->memore_m->get_cut_images($insert_data);
        $this->load->view('get_cut_images_v',$data);
    }
    
    public function get_thumb(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id']
        );
        $data['result'] = $this->memore_m ->get_thumb($insert_data);
        $this->load->view('get_thumb_v',$data);
    }
    
    public function get_tag_info(){
        $insert_data = array(
            'tag_list' => $_POST['tag_list']
        );
        $data['result'] = $this->memore_m ->get_tag_info($insert_data);
        $this->load->view('friend_list_v',$data);
    }
    
    public function get_feed_new(){
        $insert_data = array(
            'my_id' => $_POST['my_id']
        );
        $data['result'] = $this->memore_m->get_feed_new($insert_data);
        $this->load->view('get_feed_v',$data);
    }
    
    public function get_cut_list(){
        $insert_data = array(
            'my_id' => $_POST['my_id']
        );
        $data['result'] = $this->memore_m->get_cut_list($insert_data);
        $this->load->view('get_location_between_v',$data);
    }
    
    public function get_share_info(){
        $insert_data = array(
            'feed_id' => $_POST['feed_id']
        );
        $data['result'] = $this->memore_m->get_share_info($insert_data);
        $this->load->view('get_share_info_v',$data);
    }
    
    public function get_cut_info(){
        $insert_data = array(
            'cut_id' => $_POST['cut_id']
        );
        $data['result'] = $this->memore_m->get_cut_info($insert_data);
        $this->load->view('get_cut_info_v',$data);
    }
    
    public function mypage_cut_list(){
        $insert_data = array(
            'my_id' => $_POST['my_id'],
            'select_date_start' => $_POST['select_date_start'],
            'select_date_end' => $_POST['select_date_end']
        );
        $data['result'] = $this->memore_m->mypage_cut_list($insert_data);
        $this->load->view('get_location_between_v',$data);
    }
    
    public function get_cut_date(){
        $insert_data = array(
            'cut_id' => $_POST['cut_id']
        );
        $data['result'] = $this->memore_m->get_cut_date($insert_data);
        $this->load->view('friend_request_v',$data);
    }
}









