<?php

class DB {

private $dsn="mysql:host=localhost;charset=utf8;dbname=db01";
private $root="root";
private $password="12345";
private $table;
private $pdo;

public function __construct($table)
{
  $this->table=$table;
  $this->pdo=new PDO($this->dsn,$this->root,$this->password);
}


public function all(...$arg){
  $sql="select * from $this->table ";
  // $arg=[]  or [陣列],[SQL字串],[陣列,SQL字串],

  if(isset($arg[0])){
      if(is_array($arg[0])){
          //["欄位"=>"值","欄位"=>"值"]
          //where `欄位`='值' && `欄位`='值'
          //"欄位"=>"值" ====> `欄位`='值'

          foreach($arg[0] as $key => $value){
              $tmp[]=sprintf("`%s`='%s'",$key,$value);
          }
              $sql=$sql . " where " . implode(" && ",$tmp);
      }else{
          //當它是字串
          $sql=$sql . $arg[0];
      }

      if(isset($arg[1])){
          //當它是字串
          $sql=$sql . $arg[1];
      }

  }

  echo $sql;
  return $this->pdo->query($sql)->fetchAll();

}

public function count(...$arg){
  $sql="select count(*) from $this->table ";
  
  if(isset($arg[0])){
      if(is_array($arg[0])){
          
        foreach($arg[0] as $key => $value){
              $tmp[]=sprintf("`%s`='%s'",$key,$value);
          }
              $sql=$sql . " where " . implode(" && ",$tmp);
      }else{

        $sql=$sql . $arg[0];
      }

      if(isset($arg[1])){
          $sql=$sql . $arg[1];
      }

  }

  // echo $sql;
  return $this->pdo->query($sql)->fetchColumn();

}

}




$admin = new DB ("admin");
echo "<pre>";
print_r($admin->all(['acc'=>'root' , 'pw'=>'1234' ]));
echo "</pre>";

// echo "<pre>";
// print_r($admin->all(" where acc='root' "));
// echo "</pre>";

// echo "<pre>";
// print_r($admin->all(" where `pw`='1234'","order by `id` DESC"));
// echo "</pre>";
