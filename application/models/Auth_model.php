<?php
class Auth_model extends CI_Model
{   
    function login($email=null , $password=null)
    {
        if(empty($email) || empty($password)){
            return false;
        }else{
            $query = $this->db->query("SELECT * FROM users WHERE email = '$email' ");
            $check_login = $query->row();
            $count = $query->num_rows();
            $item = $query->result();
            
            $hash_password = md5($password);
            
            if($count == 1){
                foreach($item as $row){
                    if($row->email == $email && $row->password == $hash_password){
                        return $check_login;
                    }
                }
            }
        }
        return false;
     }
            
     function logout()
     {
        $user_data = array(
            'email' => '',
            'password' => '',
            'status' => '',
        );
        $this->session->set_userdata($user_data);
        return true;
    }
    
    function update_profile($id=null , $firstname=null , $lastname=null)
    {
        $this->db->where('id', $id);
        $user_data = array(
            'firstname' => $firstname,
            'lastname' => $lastname
        );
        $this->db->update('users' , $user_data);
        $success = $this->db->affected_rows();
        return $success;
    }
    
    function get_user_info($id=null)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }
    
    function change_password($id=null , $new_password=null)
    {
        $this->db->where('id' , $id);
        $new_password = array(
            'password' => md5($new_password)
        );
        $this->db->update('users' , $new_password);
    }
    
    function check_password($id=null , $old_password=null)
    {
        $query = $this->db->query("SELECT * FROM users WHERE id = '$id' ");
        $check_password = $query->result();
        
        $hash_password = md5($old_password);
        
        foreach($check_password as $row){
            if($row->password == $hash_password){
                return true;
            }
        }
        return false;
    }
}