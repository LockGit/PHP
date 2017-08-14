<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 17:03
 * 资源库模式
 * Repository 模式是架构模式，在设计架构时，才有参考价值。
 * 应用 Repository 模式所带来的好处，远高于实现这个模式所增加的代码。只要项目分层，都应当使用这个模式。
 */
class Post {

    private $id;
    private $title;
    private $text;
    private $author;
    private $created;
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getText() {
        return $this->text;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }
}


class PostRepository {
    private $persistence;

    public function __construct(Storage $persistence) {
        $this->persistence = $persistence;
    }

    /**
     * 通过指定id返回Post对象
     * @param int $id
     * @return Post|null
     */
    public function getById($id) {
        $arrayData = $this->persistence->retrieve($id);
        if (is_null($arrayData)) {
            return null;
        }

        $post = new Post();
        $post->setId($arrayData['id']);
        $post->setAuthor($arrayData['author']);
        $post->setCreated($arrayData['created']);
        $post->setText($arrayData['text']);
        $post->setTitle($arrayData['title']);

        return $post;
    }

    /**
     * 保存指定对象并返回
     * @param Post $post
     * @return Post
     */
    public function save(Post $post) {
        $id = $this->persistence->persist(array(
            'author'  => $post->getAuthor(),
            'created' => $post->getCreated(),
            'text'    => $post->getText(),
            'title'   => $post->getTitle()
        ));
        $post->setId($id);
        return $post;
    }

    /**
     * 删除指定的 Post 对象
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post) {
        return $this->persistence->delete($post->getId());
    }
}

interface Storage {
    /**
     * 持久化数据方法
     * 返回新创建的对象ID
     * @param array() $data
     * @return int
     */
    public function persist($data);

    /**
     * 通过指定id返回数据
     * 如果为空返回null
     * @param int $id
     * @return array|null
     */
    public function retrieve($id);

    /**
     * 通过指定id删除数据
     * 如果数据不存在返回false，否则如果删除成功返回true
     * @param int $id
     * @return bool
     */
    public function delete($id);
}

class MemoryStorage implements Storage {

    private $data;
    private $lastId;

    public function __construct() {
        $this->data = array();
        $this->lastId = 0;
    }

    public function persist($data) {
        $this->data[++$this->lastId] = $data;
        $this->data[$this->lastId]['id'] = $this->lastId;
        return $this->lastId;
    }

    public function retrieve($id) {
        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    public function delete($id) {
        if (!isset($this->data[$id])) {
            return false;
        }
        $this->data[$id] = null;
        unset($this->data[$id]);
        return true;
    }
}

$obj = new PostRepository(new MemoryStorage());
$post = new Post();
$post->setAuthor('lock');
$post->setCreated('create');
$post->setTitle('Lock Test');
$post->setText('Lock Test Text Area');
$obj->save($post);

var_export($obj->getById(1));
