<?php /**
 *
 */
class GameAdmin extends CI_Model
{

  function allGames($id, $offset, $limit)
  {
    # code...
    return $this->db->select('*')->where('FULLNAME', $id)->limit($limit, $offset)->order_by('ID', 'DESC')->get('msweep')->result();
  }

  function aGames($id)
  {
    # code...
    return $this->db->select('*')->where('ID', (int)$id)->get('msweep')->result();
  }
  function mGames($id)
  {
    # code...
    return $this->db->select('*')->where('hash', $id)->get('minis')->result();
  }

  function aPlayers($id)
  {
    # code...
    return $this->db->select('*')->where('ID', (int)$id)->get('players')->result();
  }

  public function createGame($details, $input)
  {
    # code...
    if(!isset($details['ID'])){
      $ID = null;
      $this->db->insert('msweep', $details);
      $last = $this->db->select('*')->where('FULLNAME',$details['FULLNAME'])->
      where('EMAIL',$details['EMAIL'])->order_by('ID','DESC')->limit(1)->get('msweep')->result();
      foreach ($last as $key) {
        # code...
        $ID = $key->ID;
      }
      $input['ID'] = $ID;
      $this->db->insert('picks', $input);
      return $ID;

    }
  }
}
 ?>
