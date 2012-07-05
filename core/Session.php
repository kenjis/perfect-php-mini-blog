<?php

/**
 * Session.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */
class Session
{
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    /**
     * コンストラクタ
     * セッションを自動的に開始する
     */
    public function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    /**
     * セッションに値を設定
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * セッションから値を取得
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     */
    public function get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return $default;
    }

    /**
     * セッションから値を削除
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * セッションを空にする
     */
    public function clear()
    {
        $_SESSION = array();
    }

    /**
     * セッションIDを再生成する
     *
     * @param boolean $destroy trueの場合は古いセッションを破棄する
     */
    public function regenerate($destroy = true)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);

            self::$sessionIdRegenerated = true;
        }
    }

    /**
     * 認証状態を設定
     *
     * @param boolean
     */
    public function setAuthenticated($bool)
    {
        $this->set('_authenticated', (bool)$bool);

        $this->regenerate();
    }

    /**
     * 認証済みか判定
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->get('_authenticated', false);
    }
}
