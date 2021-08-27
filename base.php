<?php 
session_start();
date_default_timezone_set("Asia/Taipei");
//設定後台的抬頭文字
$ts=[
        "title"=>"網站標題管理",
        "ad"=>"動態文字廣告管理",
        "mvim"=>"動畫圖片管理",
        "image"=>"校園映像資料管理",
        "menu"=>"選單管理",
        "news"=>"最新消息資料管理",
        "total"=>"進站總人數管理",
        "admin"=>"管理者帳號管理",
        "bottom"=>"頁尾版權資料管理",
];
##新增
$as=[
        "title"=>"新增網站標題",
        "ad"=>"新增動態文字廣告",
        "mvim"=>"新增動畫圖片",
        "image"=>"新增校園映像資料",
        "news"=>"新增最新消息資料",
        "admin"=>"新增管理者帳號",
        "menu"=>"新增選單",
];
##headerstring
$hs=[
  "title"=>"網站標題",
  "ad"=>"動態文字廣告",
  "mvim"=>"動畫圖片",
  "image"=>"校園映像資料",
  "news"=>"最新消息資料",
  "admin"=>"管理者帳號",
  "menu"=>"選單",
];

        

class DB {                                            ##資料庫
      private $dsn="mysql:host=localhost;charset=utf8;dbname=db01";
      private $root='root';
      private $password='12345';
      private $table;
      private $pdo;
                      ##建構式
      public function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
      }
      
      // ...$arg 不定參數，使所有的參數都放入到陣列中
      public function all(...$arg) {
        $sql="select * from $this->table ";

            ##判斷有東西
        if (isset($arg)) {
            ##位置0是不是陣列
          if(is_array($arg[0])){
              
                //["欄位"=>"值","欄位"=>"值"]
                //where `欄位` = '值' && `欄位` = `值`
            foreach($arg[0] as $key => $value){
                $tmp[] = sprintf("`%s`='%s'",$key,$value);
            }
              
              $sql = $sql . " where " . implode(" && ",$tmp);
          }  
          else {

              //當它是字串
              $sql = $sql . $arg[0];
            }
          
          if (isset($arg[1])) {
              //當它是字串
              $sql = $sql . $arg[1];
          }

        } 
        
        // echo $sql;
        return $this->pdo->query($sql)->fetchAll();
      }


      public function count(...$arg) {
        $sql="select count(*) from $this->table ";

            ##判斷有東西
        if (isset($arg)) {
            ##位置0是不是陣列
          if(is_array($arg[0])){
              
                //["欄位"=>"值","欄位"=>"值"]
                //where `欄位` = '值' && `欄位` = `值`
            foreach($arg[0] as $key => $value){
                $tmp[] = sprintf("`%s`='%s'",$key,$value);
            }
              
              $sql = $sql . " where " . implode(" && ",$tmp);
          }  
          else {

              //當它是字串
              $sql = $sql . $arg[0];
            }
          
          if (isset($arg[1])) {
              //當它是字串
              $sql = $sql . $arg[1];
          }

        } 
        
        // echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
      }

      public function find($id) {
        $sql="select * from $this->table ";

            ##位置0是不是陣列
          if(is_array($id)){
              
                //["欄位"=>"值","欄位"=>"值"]
                //where `欄位` = '值' && `欄位` = `值`
            foreach($id as $key => $value){
                $tmp[] = sprintf("`%s`='%s'",$key,$value);
            }
              
              $sql = $sql . " where " . implode(" && ",$tmp);
          }  
          else {

              //當它是字串
              $sql = $sql . "where `id`='$id'";
            }
          
        // echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
      }


      public function del($id) {
        $sql="delete from $this->table ";

            ##位置0是不是陣列
          if(is_array($id)){
              
                //["欄位"=>"值","欄位"=>"值"]
                //where `欄位` = '值' && `欄位` = `值`
            foreach($id as $key => $value){
                $tmp[] = sprintf("`%s`='%s'",$key,$value);
            }
              
              $sql = $sql . " where " . implode(" && ",$tmp);
          }  
          else {

              //當它是字串
              $sql = $sql . "where `id`='$id'";
            }
          
        echo $sql;
        return $this->pdo->exec($sql);
      }

      public function save($array) {
          if (isset($array['id'])){
            //update
            foreach($array as $key => $value){
              if ($key!='id') {
                $tmp[] = sprintf("`%s`='%s'",$key,$value);
              }
          }

            $sql="update $this->table set".implode(',',$tmp). "where `id` = '{$array['id']}'";
          } 
          else{
            //inseret


            $sql = "insert into $this->table 
            (`".implode("`,`",array_keys($array))."`) values
            ('".implode("','",$array)."')";
          }
          
          echo $sql;
          return $this->pdo->exec($sql);
      }




}

function to($url) {
    header("location:".$url);
}

$Total=new DB('total');


?>