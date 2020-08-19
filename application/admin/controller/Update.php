<?php
// +----------------------------------------------------------------------
// | HulaCWMS 呼啦企业网站管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://www.zhuopro.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 灼灼文化
// +----------------------------------------------------------------------

namespace app\admin\controller;
use ZipArchive;
use think\db;

class Update extends Base
{
    /**
     * hulcwms系统更新
     */
    public function index()
    {
        if(!is_writable(__ROOT__)){
            $this->error('文件夹没有写入的权限，无法更新');
        }
        return $this -> fetch();
    }
    /**
     * hulcwms系统更新
     */
    public function update_check()
    {
        $version_info = get_hula_version();
        if(!$version_info){
            $this->error('错误：版本信息丢失！','');
        }
        if(!isset($version_info->version)){
            $this->error('错误：版本信息丢失！','');
        }

        //访问远程地址，获取更新信息
        $content = curl_post_ssl(config('UPDATE_SERVER_URL').'?v=' . $version_info->version);
        //转换
        $content = json_decode($content);
        if(!$content){
            $this->error("错误：远程服务器没有正确的响应!",'');
        }
        if(!isset($content->code)){
            $this->error("错误：响应码错误!",'');
        }
        if ($content->code != 200) {
            $this->error($content->msg,'');
        }

        $this->success($content->msg,null,$content->data);
        //缓存线上的更新包版本
        //$this->success('发现新版本V'.$content->data->version.'，是否更新？更新前建议备份网站程序和数据库！');
    }
    public function update_start()
    {
        $version_info = get_hula_version();
        if(!$version_info){
            $this->error('错误：版本信息丢失！','');
        }
        if(!isset($version_info->version)){
            $this->error('错误：版本信息丢失！','');
        }

        //访问远程地址，获取更新信息
        $content = curl_post_ssl(config('UPDATE_SERVER_URL').'?v=' . $version_info->version);

        $content = json_decode($content);
        if(!$content){
            $this->error("错误：远程服务器没有正确的响应!",'');
        }
        if(!isset($content->code)){
            $this->error("错误：响应码错误!",'');
        }
        if ($content->code != 200) {
            $this->error($content->msg,'');
        }
        if (!isset($content->data->update_path)) {
            $this->error($content->msg,'');
        }

        //缓存线上的更新包版本
        cache('UPDATE_VERSION',$content->data->version);

        $url=url('update_down').'?upath='.urlencode($content->data->update_path);
        $this->success('正在下载新版本V'.$content->data->version.'，请稍后...',$url);
    }
    /**
     * hulcwms系统更新_下载
     * $upath=远程更新包地址
     */
    public function update_down($upath)
    {
        if(!$upath){
            $this->error("参数错误");
        }
        $update_path=config('UPDATE_PATH');

        //下载更新补丁包
        //固定更新地址，防止任意文件下载
        $file_path = down_file(urldecode('http://update.hulaxz.com'.$upath), $update_path);

        //进入下一步骤，解压更新包
        $this->success('正在解压更新包，请稍后',url('update_zip').'?fpath='.$file_path);
    }
    /**
     * hulcwms系统更新_解压
     * $fpath=下载更新包的存放地址
     */
    public function update_zip($fpath)
    {
        $update_path=config('UPDATE_PATH');

        //解压文件
        $zip = new ZipArchive();
        $openRes = $zip->open($fpath);
        if ($openRes === false) {
            $this->error('权限不足，无法解压更新补丁！');
        }
        //命名
        $dir_name = basename($fpath, ".zip");
        $update_dir_path = $update_path . $dir_name;
        $zip->extractTo($update_dir_path);
        $zip->close();

        //删除更新包压缩文件
        unlink($fpath);
        //进入下一步骤，更新文件
        $this->success('正在更新系统，请稍后',url('update_exe').'?upath='.$update_dir_path);
    }

    /**
     * hulcwms系统更新_执行
     * $upath=解压后文件存放地址
     */
    public function update_exe($upath)
    {
        $open_update_dir_path = opendir($upath);
        if(!$open_update_dir_path){
            $this->error('权限不足，无法打开更新文件夹！');
        }

        //复制文件中的文件覆盖系统文件
        while (($file = readdir($open_update_dir_path)) !== false) {//循环读出目录下的文件，直到读不到为止
            if ($file != '.' && $file != '..') {//排除一个点和两个点
                if (is_dir($upath . '/' . $file)) {
                    //复制文件夹
                    dir_copy($upath.'/'.$file,__ROOT__.$file);
                } else {
                    //判断是含有sql文件
                    if (strpos($file, 'update_sql') > -1) {
                        //读取sql
                        $sql_path = $upath . '/' . $file;
                        $sql_read = fopen($sql_path, "r");

                        $sqldata = fread($sql_read, filesize($sql_path));
                        fclose($sql_read);

                        //拆分为一条
                        $sql_list = explode(';', $sqldata);
                        //执行sql
                        foreach ($sql_list as $sql) {
                            if ($sql == '') {
                                continue;
                            }
                            //执行sql文件
                            Db::execute($sql);
                        }
                    }
                    else{
                        //复制文件
                        copy($upath.'/'.$file, __ROOT__.$file);
                    }
                }
            }
        }
        closedir($open_update_dir_path);
        //进入下一步骤，更新文件
        $this->success('正在清理更新文件，请稍后','update_end');
    }

    /**
     * hulcwms系统更新_清理
     * $opath=解压后文件存放地址
     */
    public function update_end()
    {
        //更新系统版本信息,写入
        $data['version']=cache('UPDATE_VERSION');
        if(!$data['version']){
            $this->error('错误：版本信息丢失！');
        }
        $data['update_time']=time();

        //写入文件
        $filename = config('UPDATE_PATH').'/info';
        $file = fopen($filename, "w");
        if(!$file){
            $this->error('权限不足，无法写入版本信息！');
        }
        fwrite($file, json_encode($data));
        fclose($file);
        cache('UPDATE_VERSION',null);
        //清空缓存
        cache('DB_CONFIG_DATA_ADMIN',null);

        //情况thinkphp缓存
        deldir(__ROOT__.'runtime/temp/');
        deldir(__ROOT__.'runtime/cache/');

        //进入下一循环，判断是否还有更新的补丁
        $this->success('正在校验系统版本，请稍后','update_start');
    }
}
