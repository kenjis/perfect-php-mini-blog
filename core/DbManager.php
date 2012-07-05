<?php

/**
 * DbManager.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */
class DbManager
{
    protected $connections = array();
    protected $repository_connection_map = array();
    protected $repositories = array();

    /**
     * データベースへ接続
     *
     * @param string $name
     * @param array $params
     */
    public function connect($name, $params)
    {
        $params = array_merge(array(
            'dsn'      => null,
            'user'     => '',
            'password' => '',
            'options'  => array(),
        ), $params);

        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $con;
    }

    /**
     * コネクションを取得
     *
     * @string $name
     * @return PDO
     */
    public function getConnection($name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    /**
     * リポジトリごとのコネクション情報を設定
     *
     * @param string $repository_name
     * @param string $name
     */
    public function setRepositoryConnectionMap($repository_name, $name)
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * 指定されたリポジトリに対応するコネクションを取得
     *
     * @param string $repository_name
     * @return PDO
     */
    public function getConnectionForRepository($repository_name)
    {
        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }

        return $con;
    }

    /**
     * リポジトリを取得
     *
     * @param string $repository_name
     * @return DbRepository
     */
    public function get($repository_name)
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($con);

            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    /**
     * デストラクタ
     * リポジトリと接続を破棄する
     */
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}
