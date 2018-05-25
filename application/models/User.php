<?php /**
 *
 */
class User extends CI_Model
{

  function Create($user_dets)
  {
    # code...
    if($this->db->where('EMAIL',$user_dets['EMAIL'])
    ->or_where('USERNAME', $user_dets['USERNAME'])
    ->get('user')->num_rows() < 1) {
      $this->db->insert('user',$user_dets);
      return true;
            // redirect('/gor'.json_encode($user_dets));
    }else{
      return false;
    }
  }

  public function Authenticated($login_dets)
  {
    # code...
    $query = $this->db->select('*')->where('USERNAME', $login_dets['USERNAME'])
    ->where('PASSWORD',$login_dets['PASSWORD'])->get('user');
    if($query->num_rows() > 0){
      foreach ($query->result() as $row) {
        # code...
        if($row->ACTIVE == 1){
          $this->session->set_userdata(array('fullName'=>$row->FULLNAME,'email'=>$row->EMAIL, 'loggedIn'=>true, 'ID'=> $row->ID));
          return 1;
        }else{
          return 2;
        }
      }
    }else{
      return 3;
    }

  }

  public function getSecQuest($email)
  {
    # code...
    $query = $this->db->select('QUESTION')->where('EMAIL',$email)->get('user');
    $question = '';
    if($query->num_rows() > 0){
      foreach ($query->result() as $key ) {
        # code...
        $question = $key->QUESTION;
      }
      return $question;
    }else{
      return false;
    }
  }


  function checkSecQuest($answer, $email)
  {
    # code...
    $query = $this->db->select('*')->where('EMAIL',$email)->where('ANSWER', $answer)->get('user');

    if($query->num_rows() > 0){
      $link = site_url().'lottery/password_recovery/'.sha1($email);
      $this->db->set('RESET', $link)->where('EMAIL', $email)->update('user');
      foreach ($query->result() as $key ) {
        # code...
        $data['name'] = $key->FULLNAME;
        $data['link'] = $key->RESET;
      }
      return $data;
    }else{
      return false;
    }
  }

  public function check_rec_link($link)
  {
    # code...
    $query = $this->db->select('*')->where('RESET',site_url().'lottery/password_recovery/'.$link)->get('user');
    if($query->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  public function updatePassword($password,$link)
  {
    # code...
    // echo $password; break;
    $this->db->set('PASSWORD',$password)->where('RESET',site_url().'lottery/password_recovery/'.$link)->update('user');
    $this->db->set('RESET', '')->where('RESET',site_url().'lottery/password_recovery/'.$link)->update('user');
    return true;
  }

  public function gameDetails($id)
  {
    # code...

    return $this->db->select('*')->where('RANDOMHASH', $id)->get('msweep')->result();
  }



}
 ?>
