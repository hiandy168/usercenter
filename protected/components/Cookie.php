<?php

final class Cookie
{
    /**     * 设置 Cookie     * @param string $name 名称     * @param string $value 值     * @param int $expire 时间，单位：秒     * @param array $options 选项，具体请参考 CHttpCookie     * @return boolean     */
    static public function set($name, $value = '', $expire = 0, $options = [])
    {
        if (!is_string($name) || !is_int($expire) || !is_array($options)) {
            return false;
        }
        $cookie = new CHttpCookie($name, $value);
        if ($expire) {
            $cookie->expire = time() + $expire;
        }
        if (!empty($options)) {
            foreach ($options as $optionIndex => $optionVal) {
                $cookie->$optionIndex = $optionVal;
            }
        }
        Mod::app()->getRequest()->cookies[$name] = $cookie;
        return true;
    }

    /**     * 获取 Cookie     * @param string $name 名称     * @return mixed */
    static public function get($name)
    {
        if (!(is_string($name) && $name)) {
            return false;
        }
        return isset(Mod::app()->getRequest()->cookies[$name]) ? Mod::app()->getRequest()->cookies[$name]->value : '';
    }

    /**     * 清除全部 Cookie     * @return void */
    static public function clear()
    {
        Mod::app()->getRequest()->getCookies()->clear();
    }

    /**     * 删除某个 Cookie     * @param string $name 名称     * @return boolean */
    static public function remove($name)
    {
        if (!(is_string($name) && $name) || !isset(Mod::app()->getRequest()->cookies[$name])) {
            return false;
        }
        self::set($name, '', -1);
        return true;
    }
}