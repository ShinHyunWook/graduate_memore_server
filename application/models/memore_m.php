<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 공통 게시판 모델 (이미지 포함)
 *
 * @author Jongwon Byun <advisor@cikorea.net>
 * @version 1.0
 */
class Memore_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function insert_member($arrays){
        $result = $this->db->insert('users',$arrays);
        
        $this->db->where('email',$arrays['email']);
        $this->db->select('id');
        $query = $this->db->get('users');
        $tmp = $query->result();
        $id = $tmp[0]->id;
        
        $insert_data = array(
            'user_id' => $id,
            'loc_time' => "0000-00-00"
        );
        $this->db->insert('location_data',$insert_data);
        return $result;
    }
    
    function login($arrays){
        $this->db->where('email',$arrays['email']);
        $this->db->where('password',$arrays['password']);
        $this->db->select('id,name');
        $query = $this->db->get('users');
        $result = $query->result();
        
        return $result;
    }
    
    function set_info($arrays){
        $this->db->where('email',$arrays['email']);
        $this->db->select('name,phoneNumber,profile,password,profile,email');
        $query = $this->db->get('users');
        $result = $query->result();
        
        return $result;
    }
    
    function save_location($arrays){
        $sql = 'SELECT id FROM location_data where user_id = '.$arrays['user_id'].' order by id DESC limit 1';
        $query = $this->db->query($sql);
        $loc_id = $query->result();
        $id = $loc_id[0]->id;
        
        $update_data = array(
            'user_id' => $arrays['user_id'],
            'loc_time' => $arrays['loc_time'],
            'loc_data' => $arrays['loc_data']
        );
        $this->db->where('id',$id);
        $result = $this->db->update('location_data',$update_data);
        
        $insert_data = array(
            'user_id' => $arrays['user_id']
        );
        $this->db->insert('location_data',$insert_data);
        
        return $result;
    }
    
    function get_location($arrays){
        $this->db->where('email',$arrays['email']);
        $this->db->select('id');
        $query = $this->db->get('users');
        $tmp = $query->result();
        $id = $tmp[0]->id;
        
        
        $this->db->where('user_id',$id);
        $this->db->where('loc_time',$arrays['loc_time']);
        $this->db->select('id,loc_data');
        $query = $this->db->get('location_data');
        $result = $query->result();
        return $result;
    }
    
    function    get_location_between($arrays){
        $this->db->where('email',$arrays['email']);
        $this->db->select('id');
        $query = $this->db->get('users');
        $tmp = $query->result();
        $id = $tmp[0]->id;
        
        $sql = 'SELECT id,loc_data FROM location_data where user_id = "'.$id.'" and loc_time between "'.$arrays['s_loc_time'].'" and "'.$arrays['e_loc_time'].'"';
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
        function get_location_id($arrays){        
        $this->db->where('user_id',$arrays['my_id']);
        $this->db->where('loc_time',$arrays['loc_time']);
        $this->db->select('id,loc_data');
        $query = $this->db->get('location_data');
        $result = $query->result();
        return $result;
    }
    
        function get_location_between_id($arrays){
        $sql = 'SELECT id,loc_data FROM location_data where user_id = "'.$arrays['user_id'].'" and loc_time between "'.$arrays['s_loc_time'].'" and "'.$arrays['e_loc_time'].'"';
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;
    }
    
    function search_person($arrays){
        $this->db->where('email',$arrays['email']);
        $this->db->select('id,name,phoneNumber');
        $query = $this->db->get('users');
        $result = $query->result();
        
        return $result;
    }
    
    function friend_request($arrays){
        $result = $this->db->insert('friends',$arrays);
        return $result;
    }
    
    function search_friend($arrays){
        $this->db->where('friend_one',$arrays['my_id']);
        $this->db->where('friend_two',$arrays['friend_id']);
        $query = $this->db->get('friends');
        $tmp = $query->result();
        
        if(count($tmp)==1){ //내가 신청한 상태
            $this->db->select('*');
            $this->db->where('friend_one',$arrays['my_id']);
            $this->db->where('friend_two',$arrays['friend_id']);
            $this->db->from('friends');
            $this->db->join('users', 'users.id = friends.friend_two');
            $query = $this->db->get();
            $result = $query->result();
        }else{
            $this->db->where('friend_one',$arrays['friend_id']);
            $this->db->where('friend_two',$arrays['my_id']);
            $query = $this->db->get('friends');
            $tmp2 = $query->result();
            if(count($tmp2)==1){
                $this->db->select('*');
                $this->db->where('friend_one',$arrays['friend_id']);
                $this->db->where('friend_two',$arrays['my_id']);
                $this->db->from('friends');
                $this->db->join('users', 'users.id = friends.friend_one');
                $query = $this->db->get();
                $result = $query->result();
                array_push($result,"requested");
            }else{
                $this->db->where('id',$arrays['friend_id']);
                $this->db->select('id,name,phoneNumber,email,profile');
                $query = $this->db->get('users');
                $result = $query->result();                
            }
        }
        return $result;
    }
    
    function cancel_friend_request($arrays){
        $this->db->where('friend_one',$arrays['friend_one']);
        $this->db->where('friend_two',$arrays['friend_two']);
        $result = $this->db->delete('friends');
        
        return $result;
    }
    
    function accept_friend($arrays){
        $data = array(
            'status' => '1'
        );
        $this->db->where('friend_one',$arrays['friend_one']);
        $this->db->where('friend_two',$arrays['friend_two']);
        $result = $this->db->update('friends',$data);
        return $result;
    }
    
    function reject_friend($arrays){
        $this->db->where('friend_one',$arrays['friend_one']);
        $this->db->where('friend_two',$arrays['friend_two']);
        $result = $this->db->delete('friends');
        return $result;
    } 
    
    function delete_friend($arrays){
        $this->db->where('friend_one',$arrays['friend_one']);
        $this->db->where('friend_two',$arrays['friend_two']);
        $query = $this->db->get('friends');
        $tmp = $query->result();
        if(count($tmp)==1){
            $this->db->where('friend_one',$arrays['friend_one']);
            $this->db->where('friend_two',$arrays['friend_two']);
            $result = $this->db->delete('friends');
        }else{
            $this->db->where('friend_one',$arrays['friend_two']);
            $this->db->where('friend_two',$arrays['friend_one']);
            $result = $this->db->delete('friends');
        }
        return $result;
    }
    
    function get_friend_list($arrays){
        $sql = 'SELECT id,email,name,phoneNumber,profile FROM `friends` join users on friends.friend_one = users.id WHERE friend_two = '.$arrays['u_id'].' AND status = "1"
        UNION ALL SELECT id,email,name,phoneNumber,profile FROM `friends` join users on friends.friend_two = users.id WHERE friend_one = '.$arrays['u_id'].' AND status = "1"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_search_friend_list($arrays){
        $sql = 'SELECT id,email,name,phoneNumber,profile FROM `friends` join users on friends.friend_one = users.id WHERE 
        friend_two = '.$arrays['u_id'].' AND status = "1" AND users.name Like "%'.$arrays['name'].'"
        OR friend_two = '.$arrays['u_id'].' AND status = "1" AND users.name Like "'.$arrays['name'].'%"
        OR friend_two = '.$arrays['u_id'].' AND status = "1" AND users.name Like "%'.$arrays['name'].'%"
        UNION ALL SELECT id,email,name,phoneNumber,profile FROM `friends` join users on friends.friend_two = users.id WHERE
        friend_one = '.$arrays['u_id'].' AND status = "1" AND users.name Like "%'.$arrays['name'].'"
        OR friend_one = '.$arrays['u_id'].' AND status = "1" AND users.name Like "'.$arrays['name'].'%"
        OR friend_one = '.$arrays['u_id'].' AND status = "1" AND users.name Like "%'.$arrays['name'].'%"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;        
    }
    
    function get_friend_request_list($arrays){
        $this->db->select('id,email,name,phoneNumber,profile');
        $this->db->where('friend_two',$arrays['my_id']);
        $this->db->where('status','0');
        $this->db->from('friends');
        $this->db->join('users', 'users.id = friends.friend_one');
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function user_info_update($arrays){
        $data = array(
            'profile' => $arrays['profile'],
            'name' => $arrays['name'],
            'password' => $arrays['password'],
            'phoneNumber' => $arrays['phoneNumber']
        );
        $this->db->where('id',$arrays['my_id']);
        $result = $this->db->update('users',$data);
        return $result;
    }
    
    function insert_cut($arrays){
        $sql = 'SELECT id FROM location_data where user_id = '.$arrays['user_id'].' order by id DESC limit 1';
        $query = $this->db->query($sql);
        $loc_id = $query->result();
        $id = $loc_id[0]->id;
        
        $insert_data = array(
            'image_name' => $arrays['image_name'],
            'user_id' => $arrays['user_id'],
            'caption' => $arrays['caption'],
            'location_data' => $arrays['location_data'],
            'location_id' => $id,
            'tag_id_list' => $arrays['tag_id_list']
        );
        $result = $this->db->insert('cut',$insert_data);
        return $result;
    }
    
    function get_cut_image_locID($arrays){
        for($i=0;$i<count($arrays['location_id']);$i++){
            $this->db->or_where('location_id',$arrays['location_id'][$i]);
        }
        $this->db->select('id,image_name,caption,location_data,tag_id_list');
        $query = $this->db->get('cut');
        $result = $query->result();
        return $result;
    }
//        function get_cut_image_locID($arrays){
//        $this->db->where('location_id',$arrays['location_id']);
//        $this->db->select('id,image_name,caption,location_data,tag_id_list');
//        $query = $this->db->get('cut');
//        $result = $query->result();
//        return $result;
//    }
    
    function get_tag_friend_list($arrays){
        for($i=0;$i<count($arrays['tag_list']);$i++){
            $this->db->or_where('id',$arrays['tag_list'][$i]);
        }
        $this->db->select('name,profile');
        $query = $this->db->get('users');
        $result = $query->result();
        return $result;
    }
    
    function post_feed($arrays){
        $result = $this->db->insert('feed',$arrays);
        return $result;
    }
    
    function get_feed($arrays){
        $sql = 'SELECT feed.id, user_id,name,profile,post_time,cut_id,start_loc_date,end_loc_date FROM feed join users on users.id = feed.user_id where user_id = '.$arrays['user_id'].' ORDER by feed.id DESC';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_cut_image_cut_id($arrays){
        $cut_arr = json_decode($arrays['cut_list']);
        for($i=0;$i<count($cut_arr);$i++){
            $this->db->or_where('id',$cut_arr[$i]);
        }
        $this->db->select('image_name,location_data,');
        $query = $this->db->get('cut');
        $result = $query->result();
        return $result;
    }
    
    function get_latest_date($arrays){
        $this->db->select('id');
        $this->db->where('email',$arrays['email']);    
        $query = $this->db->get('users');
        $tmp = $query->result();
        $id = $tmp[0]->id;
        
        $sql = 'SELECT loc_time FROM location_data where user_id = "'.$id.'" ORDER by loc_time DESC limit 1';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        
    }
    
    function add_thumb($arrays){
        $result = $this->db->insert('thumb',$arrays);
        return $result;    
    }
    
    function set_thumb_status($arrays){
        $this->db->where('feed_id',$arrays['feed_id']);
        $this->db->where('user_id',$arrays['user_id']);
        $this->db->select('id');
        $query = $this->db->get('thumb');
        $result = $query->result();
        return $result;
    }
    
    function delete_thumb($arrays){
        $this->db->where('feed_id',$arrays['feed_id']);
        $this->db->where('user_id',$arrays['user_id']);
        $result = $this->db->delete('thumb');
        return $result;
    }
    
    function set_feed_content($arrays){
        $sql = 'SELECT feed.id, user_id,name,profile,post_time,cut_id,start_loc_date,end_loc_date FROM feed join users on users.id = feed.user_id where feed.id = '.$arrays['feed_id'].'';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_cut_images($arrays){
        $cut_arr = json_decode($arrays['cut_id']);
        for($i=0;$i<count($cut_arr);$i++){
            $this->db->or_where('id',$cut_arr[$i]);
        }
        $this->db->select('image_name,caption,tag_id_list');
        $query = $this->db->get('cut');
        $result = $query->result();
        return $result;
    }
    
    function get_thumb($arrays){
        $sql = 'SELECT users.email,users.name,users.profile,users.id from thumb join users on thumb.user_id = users.id where feed_id = '.$arrays['feed_id'];
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_tag_info($arrays){
        $this->db->select('id,email,name,profile');
        $tag_list = json_decode($arrays['tag_list']);
        
        for($i=0;$i<count($tag_list);$i++){
            $this->db->or_where('id',$tag_list[$i]);
        }
        
        if(count($tag_list)!=0){
            $this->db->from('users');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;       
        }else{
            return 0;
        }

    }
    
    
    function get_feed_new($arrays){
        $id_arr = array();
        $sql = "Select * from friends where status = '1' and friend_one = ".$arrays['my_id']." or status = '1' and friend_two = ".$arrays['my_id'];
        $query = $this->db->query($sql);
        array_push($id_arr,$arrays['my_id']);
        $temp = $query->result();
        for($i = 0;$i<count($temp);$i++){
            if($temp[$i]->friend_one==$arrays['my_id']){
                array_push($id_arr,$temp[$i] -> friend_two);
            }else{
                array_push($id_arr,$temp[$i] -> friend_one);
            }
        }
        
        for($j = 0; $j<count($id_arr); $j++){
            $this->db->or_where('user_id',$id_arr[$j]);
        }

        if(count($id_arr)!=0){
            $this->db->select('feed.id, user_id,name,profile,post_time,cut_id,start_loc_date,end_loc_date');
            $this->db->from('feed');
            $this->db->join('users', 'users.id = feed.user_id');
            $this->db->order_by("feed.id", "desc");
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }else{
            return 0;
        }

    }
    
    function get_cut_list($arrays){
        $this->db->where('user_id',$arrays['my_id']);
        $this->db->select('id,image_name,caption,tag_id_list');
        $this->db->from('cut');
        $query = $this->db->get();
        $result = $query -> result();
        return $result;
    }
    
    function mypage_cut_list($arrays){
        $sql = 'SELECT cut.id,cut.image_name,cut.caption,cut.tag_id_list FROM cut join location_data on cut.location_id = location_data.id where cut.user_id = "'.$arrays['my_id'].'" and loc_time between "'.$arrays['select_date_start'].'" and "'.$arrays['select_date_end'].'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_share_info($arrays){
//        $this->db->where('feed_id',$arrays['feed_id']);
//        $this->db->select("cut_id");
//        $this->db->from('thumb');
//        $query = $this->db->get();
//        $tmp = $query->result();
//        print_r($tmp);
//        if(empty($tmp[0]->cut_id)){
            $this->db->where('feed_id',$arrays['feed_id']);
            $this->db->select('thumb.image_name,thumb.cut_id,thumb.user_id,users.email,users.name,users.profile');
            $this->db->from('thumb');
            $this->db->join('users','users.id = thumb.user_id');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
//        }else{
//            $this->db->where('feed_id',$arrays['feed_id']);
//            $this->db->select('thumb.image_name,thumb.cut_id,thumb.user_id,users.email,users.name,users.profile,cut.caption');
//            $this->db->from('thumb');
//            $this->db->join('users','users.id = thumb.user_id');
//            $this->db->join('cut','cut.id = thumb.cut_id');
//            $query = $this->db->get();
//            $result = $query->result();
//            return $result;
//        }
    }
    
    function get_cut_info($arrays){
        $this->db->where('id',$arrays['cut_id']);
        $this->db->select('caption,image_name,tag_id_list');
        $this->db->from('cut');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_cut_date($arrays){
        $this->db->where('cut.id',$arrays['cut_id']);
        $this->db->select('location_data.loc_time');
        $this->db->from('cut');
        $this->db->join('location_data','location_data.id=cut.location_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->loc_time;
    }
    
}











