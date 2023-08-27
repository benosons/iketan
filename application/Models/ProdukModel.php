<?php namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model{

    public function getproduk()
    {

        $sql =   "select * from data_produk";
       
        $result = $this->db->query($sql);
        $row = $result->getResult();
        return $row;
    }

    public function getharianterjual( $date = null )
    {

        $sql =   "select DISTINCT id_produk, 
                  (select nama from data_produk where id = data_terjual.id_produk) as nama,
                  (select img from data_produk where id = data_terjual.id_produk) as img,
                  (select harga from data_produk where id = data_terjual.id_produk) as harga,
                  sum(qty) as qty 
                  from data_terjual ";
        if($date){

        }else{
          $sql .= " where DATE_FORMAT(create_date, '%Y-%m-%d') = CURDATE()";
        }
        $sql .= " GROUP BY id_produk";
       
        $result = $this->db->query($sql);
        $row = $result->getResult();
        return $row;
    }

    public function insertproduk( $data = null)
    {
      $this->db->table('data_terjual')->insert($data);
      return true;
    }


}
