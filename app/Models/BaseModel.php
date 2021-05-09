<?php
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    /**
     * Method untuk mendapatkan data
     * 
     * @param array $data
     * @param array $column
     * @param string $isOrderBy
     * @param string $typeOrder
     * @return array|false Jika data yg terambil hanya satu baris akan mengembalikan array 1d, 
     * jika banyak akan mengembalikan array 2d, jika kosong akan mengembalikan False
     * 
     */    
    public function getData($data=false, $column=false, $orderBy=false, $typeOrder='desc')
    {
        // Where
        (!$data)?null:$this->where($data);

        // Order By
        (!$orderBy)?null:$this->orderBy($orderBy, $typeOrder);

        // Get result
        if($column == false) {
            $result = $this->findAll();
        }elseif (gettype($column) != 'array') {
            $result = $this->findColumn($column);
        }elseif(count($column) == 1) {
            $result = $this->findColumn($column[0]);
        }else{
            $resultArr = [];
            $result = $this->findAll();
            for ($i=0; $i < count($column); $i++) { 
                for ($j=0; $j < count($result); $j++) { 
                    $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
                }
            }
            $result = $resultArr;
        }

        // Output result
        if (!$result) {
            return false;
        }elseif (count($result) == 1) {
            return $result[0];
        }else {
            return $result;
        }
    }

    /**
     * Method untuk input data baru
     * 
     * @param array $data variabel yang akan diinputkan (e.g ['nama'=>'koko', 'umur':'5'])
     * @param array $dataExist variable yg menampung data yang akan dicek (e.g ['nama'=>'koko', 'umur':'5'])
     * @return integer|false jika berhasil mengembalikan id data yg diinput, jika gagal mengembalikan false
     */    
    public function insertData($data, $dataExist=false, $idFirstName='ownClass')
    {
        // Jika $dataExist ada, maka akan dilakukan pengecekan apakah data ada di db
        // jika ada maka tidak akan dilakukan proses input, dan mengembalikan false
        if($dataExist && $this->getData($dataExist)){
           return false;
        }

        // Generate Random id yg akan menjadi Primary Key
        // Jika $idFirstName ada, maka akan ditambahkan string pada depan id
        if($idFirstName=='ownClass'){
            $idFirstName = preg_replace( '/(.+)Models/', '', (get_called_class()) );
            $idFirstName = str_replace( '\\', '', $idFirstName);
            $idFirstName = substr($idFirstName, 0, 3);
        }

        $idList = $this->getData(0,'id');
        if (gettype($idList) != 'array'){
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if($id != $idList){
                    $isUnique = true;
                }
            }
            $data['id'] = $idFirstName.$id;
        }else if ($idList) {
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if(!in_array($id, $idList)){
                    $isUnique = true;
                }
            }
            $data['id'] = $idFirstName.$id;
        }else {
            $data['id'] = $idFirstName.$this->randomGenerator(5);
        }

        // Generate Unique Code
        $list = $this->getData(0,'uniqueCode');
        $isUnique = false;
        if (gettype($list) != 'array'){
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if($id != $list){
                    $isUnique = true;
                }
            }
            $data['uniqueCode'] = $id;        
        }else if ($list) {
            while(!$isUnique) { 
                $id = $this->randomGenerator(10, 1, 1, 0);
                if(!in_array($id, $list)){
                    $isUnique = true;
                }
            }
            $data['uniqueCode'] = $id;
        }else {
            $data['uniqueCode'] = $this->randomGenerator(10, 1, 1, 0);
        }

        // insert
        $this->insert($data);

        // Check data yg telah diinput
        // jika ada return id
        // jika tidak terinput return false 
        if( $this->getData($data) ) {
            return $this->getData($data, 'id');
        }else{
            return 'false';
        }
    }

    /**
     * Method untuk menghapus data input
     * Method ini hanya bisa digunakan jika data diinput 5 manit sebelumnya
     * 
     * @param string $id id PK pada baris yg akan dihapus
     * @return true|false jika berhasil mengembalikan true, jika gagal mengembalikan false
     */    
    public function rollbackInsert($id)
    {
        $data = $this->getData(['id'=>$id]);
        $dateNow = date('Y-m-d H:i:s');
        $dateAgo = date('Y-m-d H:i:s', strtotime($dateNow.' - 5 minutes'));

        // cek jika data baru saja diinput 
        if ($data) {
            if ($dateAgo <= $data['createDate'] && $data['createDate'] <= $dateNow ) {
                // delete row
                $this->delete(['id'=>$id]);
                return true;
            }
        }
        return false;
    }


    /**
     * Method untuk update data
     * 
     * @param array $data
     * @param array $where
     * @return integer|false Jka berhasil update akan mengembalikan id data yg terupdate, jika gagal akan mengembalikan False
     */    
    public function updateData($data, $where)
    {
        // update
        $this->db->table($this->table)->update($data, $where);

        // check if updated data excist
        if( $this->where($data)->first() ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Method untuk menghapus data yg terupdate
     * Method ini hanya bisa digunakan jika data diupdate 5 manit sebelumnya
     * 
     * @param string $id id PK pada baris yg akan dihapus
     * @return true|false jika berhasil mengembalikan true, jika gagal mengembalikan false
     */  
    public function rollbackUpdate($id, $currData)
    {
        $data = $this->getData(['id'=>$id]);
        $dateNow = date('Y-m-d H:i:s');
        $dateAgo = date('Y-m-d H:i:s', strtotime($dateNow.' - 5 minutes'));

        // cek jika data baru saja diupdate 
        if ($data) {
            if ($dateAgo <= $data['lastUpdate'] && $data['lastUpdate'] <= $dateNow ) {
                // delete row
                $this->db->table($this->table)->update($currData, ['id'=>$id]);
                return true;
            }
        }
        return false;
    }

    
    /**
     * Method untuk delete data
     * 
     * @param array $data
     * @param array $where
     * @return integer|false Jka berhasil delete akan mengembalikan true, jika gagal akan mengembalikan False
     */    
    public function deleteData($where)
    {
        // update
        $data = ['deleteDate' => date('Y-m-d H:i:s')];
        $this->db->table($this->table)->update($data, $where);

        // check if updated data excist
        if( $this->where($data)->first() ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Method untuk menghapus data yg terupdate
     * Method ini hanya bisa digunakan jika data diupdate 5 manit sebelumnya
     * 
     * @param string $id id PK pada baris yg akan dihapus
     * @return true|false jika berhasil mengembalikan true, jika gagal mengembalikan false
     */  
    public function rollbackDelete($id)
    {
        $currData = ['deleteDate' => null];
        $data = $this->getData(['id'=>$id]);
        $dateNow = date('Y-m-d H:i:s');
        $dateAgo = date('Y-m-d H:i:s', strtotime($dateNow.' - 5 minutes'));

        // cek jika data baru saja diupdate 
        if ($data) {
            if ($dateAgo <= $data['lastUpdate'] && $data['lastUpdate'] <= $dateNow ) {
                // delete row
                $this->db->table($this->table)->update($currData, ['id'=>$id]);
                return true;
            }
        }
        return false;
    }


    /**
     * Method untuk membuat random string
     * 
     * @param int $len panjang string yang akan dibuat
     * @param bool $isAngka menyertakan angka jika true
     * @param bool $isUppercase menyertakan huruf kapital jika true
     * @param bool $isLowercase menyertakan huruf kecil jika true
     * @return string mengembalikan random string
     */
	public function randomGenerator($len, $isAngka=true, $isUppercase=true, $isLowecase=true)
    {
		$rand='';
		for ($i=0; $i < $len; $i++) { 
            $random = [];
            ($isAngka)?array_push($random, rand(48,57)):null;
            ($isUppercase)?array_push($random, rand(65,90)):null;
            ($isLowecase)?array_push($random, rand(97,122)):null;
            if (count($random) == 3) {
                $rand = $rand.chr($random[rand(0,2)]);
            }elseif (count($random) == 2) {
                $rand = $rand.chr($random[rand(0,1)]);
            }elseif (count($random) == 1) {
                $rand = $rand.chr($random[rand(0,0)]);
            }else{
                return '';
            }
		}
		return $rand;
	}

    public function coba()
    {
        return($this->randomGenerator(10, 1, 1, 1));
    }

}