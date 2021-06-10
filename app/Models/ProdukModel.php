<?php

namespace App\Models;

class ProdukModel extends BaseModel
{
    protected $table = "produk";
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;

    protected $deletedField  = 'deleteDate';

    function join2table()
    {
        $result = $this->table('produk')
            ->select()
            ->join('kategori', 'kategori.kode_kategori = produk.kode_kategori')
            ->findAll();
        return $result;
    }

    public function search($keyword)
    {
        return $this->Like('nama_kategori', $keyword, 'both')->findAll();
    }

    public function getProduks($idUser = false, $data = false, $column = false, $orderBy = false, $typeOrder = 'desc')
    {
        // Where
        (!$data) ? null : $this->where($data);

        // Order By
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);

        // join user
        if ($idUser) {
            $this->select('produk.*');
            $this->join('user', 'user.id = produk.idUser');
            $this->where('user.id', $idUser);
        }

        // Get result
        if ($column == false) {
            $result = $this->findAll();
        } elseif (gettype($column) != 'array') {
            $result = $this->findColumn($column);
        } else {
            $resultArr = [];
            $result = $this->findAll();
            for ($i = 0; $i < count($column); $i++) {
                for ($j = 0; $j < count($result); $j++) {
                    $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
                }
            }
            $result = $resultArr;
        }

        // Output result
        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function getProduk($data = false, $column = false, $orderBy = false, $typeOrder = 'desc', $category = '')
    {
        // Where
        (!$data) ? null : $this->where($data);

        // Order By
        (!$orderBy) ? null : $this->orderBy($orderBy, $typeOrder);

        // Get result
        if ($column == false && $category != '') {
            $result = $this->where('nama_kategori', $category)->findAll();
        } elseif ($column == false) {
            $result = $this->findAll();
        } elseif (gettype($column) != 'array') {
            $result = $this->findColumn($column);
        } elseif (count($column) == 1) {
            $result = $this->findColumn($column[0]);
        } else {
            $resultArr = [];
            $result = $this->findAll();
            for ($i = 0; $i < count($column); $i++) {
                for ($j = 0; $j < count($result); $j++) {
                    $resultArr[$j][$column[$i]] = $result[$j][$column[$i]];
                }
            }
            $result = $resultArr;
        }

        // Output result
        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function kategori()
    {
        $query = $this->query('SELECT nama_kategori FROM produk GROUP BY nama_kategori');
        $result = $query->getResultArray();

        $newResult = [];
        foreach ($result as $keyResult => $valResult) {
            array_push($newResult, $valResult['nama_kategori']);
        }
        return $newResult;
    }

    public function insert_produk($data, $dataExist = false, $id = 'ownClass')
    {
        // Jika $dataExist ada, maka akan dilakukan pengecekan apakah data ada di db
        // jika ada maka tidak akan dilakukan proses input, dan mengembalikan false
        if ($this->getProduk($dataExist) && $dataExist) {
            return false;
        }

        // Generate Random id yg akan menjadi Primary Key
        // Jika $idFirstName ada, maka akan ditambahkan string pada depan id
        if ($id == 'ownClass') {
            $id = preg_replace('/(.+)Models/', '', (get_called_class()));
            $id = str_replace('\\', '', $id);
            $id = substr($id, 0, 3);
        }

        $idList = $this->getProduk(0, 'id');
        if (gettype($idList) != 'array') {
            $isUnique = false;
            while (!$isUnique) {
                $id = $this->randomGenerator(5);
                $id = $id;
                if ($id != $idList) {
                    $isUnique = true;
                }
            }
            $data['id'] = $id . $id;
        } else if ($idList) {
            $isUnique = false;
            while (!$isUnique) {
                $id = $this->randomGenerator(5);
                $id = $id;
                if (!in_array($id, $idList)) {
                    $isUnique = true;
                }
            }
            $data['id'] = $id . $id;
        } else {
            $data['id'] = $id . $this->randomGenerator(5);
        }

        // Generate Unique Code
        $list = $this->getProduk(0, 'uniqueCode');
        $isUnique = false;
        if (gettype($list) != 'array') {
            $isUnique = false;
            while (!$isUnique) {
                $id = $this->randomGenerator(5);
                $id = $id;
                if ($id != $list) {
                    $isUnique = true;
                }
            }
            $data['uniqueCode'] = $id;
        } else if ($list) {
            while (!$isUnique) {
                $id = $this->randomGenerator(10, 1, 1, 0);
                if (!in_array($id, $list)) {
                    $isUnique = true;
                }
            }
            $data['uniqueCode'] = $id;
        } else {
            $data['uniqueCode'] = $this->randomGenerator(10, 1, 1, 0);
        }

        // insert
        $this->db->table($this->table)->insert($data);

        // Check data yg telah diinput
        // jika ada return id
        // jika tidak terinput return false 
        if ($this->getProduk($data)) {
            return $this->getProduk($data, 'id');
        } else {
            return 'false';
        }
    }

    public function rollbackInsert($id)
    {
        $data = $this->getData(['id' => $id]);
        $dateNow = date('Y-m-d H:i:s');
        $dateAgo = date('Y-m-d H:i:s', strtotime($dateNow . ' - 5 minutes'));

        // cek jika data baru saja diinput 
        if ($data) {
            if ($dateAgo <= $data['createDate'] && $data['createDate'] <= $dateNow) {
                // delete row
                $this->delete(['id' => $id]);
                return true;
            }
        }
        return false;
    }

    public function update_produk($data, $uniqueCode)
    {
        // update
        $this->db->table($this->table)->update($data, ['uniqueCode' => $uniqueCode]);
        // check if updated data excist
        if ($this->where($data)->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function rollbackUpdate($id, $currData)
    {
        $data = $this->getData(['id' => $id]);
        $dateNow = date('Y-m-d H:i:s');
        $dateAgo = date('Y-m-d H:i:s', strtotime($dateNow . ' - 5 minutes'));

        // cek jika data baru saja diupdate 
        if ($data) {
            if ($dateAgo <= $data['lastUpdate'] && $data['lastUpdate'] <= $dateNow) {
                // delete row
                $this->db->table($this->table)->update($currData, ['id' => $id]);
                return true;
            }
        }
        return false;
    }

    public function delete_produk($where)
    {
        // update
        $data = ['deleteDate' => date('Y-m-d H:i:s')];
        $this->db->table($this->table)->update($data, $where);

        // check if updated data excist
        return true;
    }

    public function randomGenerator($len, $isAngka = true, $isUppercase = true, $isLowecase = true)
    {
        $rand = '';
        for ($i = 0; $i < $len; $i++) {
            $random = [];
            ($isAngka) ? array_push($random, rand(48, 57)) : null;
            ($isUppercase) ? array_push($random, rand(65, 90)) : null;
            ($isLowecase) ? array_push($random, rand(97, 122)) : null;
            if (count($random) == 3) {
                $rand = $rand . chr($random[rand(0, 2)]);
            } elseif (count($random) == 2) {
                $rand = $rand . chr($random[rand(0, 1)]);
            } elseif (count($random) == 1) {
                $rand = $rand . chr($random[rand(0, 0)]);
            } else {
                return '';
            }
        }
        return $rand;
    }
}
