<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/24
 * Time: 00:26
 * 数据映射模式
 * 目的是让持久化数据存储层、驻于内存的数据表现层、以及数据映射本身三者相互独立、互不依赖。
 * 最典型的数据映射模式例子就是数据库 ORM 模型 类似
 */

class user{
    public $id;
    public $name;
    public $email;
    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }
}

class userMap{

    private $db;

    /**
     * userMap constructor.
     * @param Database $db
     */
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * @param user $user
     * @return mixed
     */
    public function save(user $user){
        $data = array(
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
        );

        if(null===($id=$user->id)){
            unset($data['id']);
            return $this->db->insert($data);
        }
        return $this->db->update($data,array('id=?'=>$id));
    }

    /**
     * @param $id
     * @return user|void
     */
    public function findById($id){
        $res = $this->db->findById($id);
        $row = $res->current();
        if(0===count($row)){
            return;
        }
        return $this->mapObject($row);
    }

    /**
     * @param $row
     * @return user
     */
    protected function mapObject($row){
        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $user->email = $row['email'];
        return $user;
    }
}

class Database{

    public $currentArr;
    public function insert(){
        echo 'I will insert data to db...'.PHP_EOL;
    }

    public function update(){
        echo 'I will update data save to db...'.PHP_EOL;
    }

    /**
     * @param $id
     * @return array
     */
    public function findById($id){
        /**
         * select * from xxx where id=:id limit 1
         * get $res
         */
        $res = ['id'=>1,'name'=>'lock','email'=>'xxxxx@gmail.com'];
        $this->currentArr = $res;
        return $this;
    }

    public function current(){
        return $this->currentArr;
    }
}

$dataBaseObj = new Database();
$userMapObj = new userMap($dataBaseObj);
$user = new user();
$user->id = 1;
$user->name = 'lock';
$user->email = 'xxxxx@gmail.com';
$userMapObj->save($user);

$find = $userMapObj->findById(1);
var_export($find->id);
var_export($find->name);
var_export($find->email);
