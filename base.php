<?php 

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
              echo "處理陣列";
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
};
      ##串資料表
$db = new 



?>