<?php

/**
 * DbRepository.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */
abstract class DbRepository
{
    protected $con;

    /**
     * コンストラクタ
     *
     * @param PDO $con
     */
    public function __construct($con)
    {
        $this->setConnection($con);
    }

    /**
     * コネクションを設定
     *
     * @param PDO $con
     */
    public function setConnection($con)
    {
        $this->con = $con;
    }

    /**
     * クエリを実行
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement $stmt
     */
    public function execute($sql, $params = array())
    {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * クエリを実行し、結果を1行取得
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetch($sql, $params = array())
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * クエリを実行し、結果をすべて取得
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, $params = array())
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
