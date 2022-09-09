<?php

//class for database connection.

class database{
    //variables for db connection.

    private  $host;
    private  $username;
    private  $password;
    private  $db;

    // function for database connection.

    protected function connect(){
        $this->host      = 'localhost';
        $this->username  = 'root';
        $this->password   = "";
        $this->db        = 'testdb';
       
        //connecting to the database.
        $con = new mysqli($this->host, $this->username, $this->password, $this->db);
        
        return $con;
    }

}

//class for sql query.

class query extends database{

    //function for fetching data.

    public function getData($table,$field='*',$condition="",$order1 ="",$order2 ="desc",$limit=""){

        $sql = "SELECT $field FROM `$table`";

        if($condition!=""){
            $sql = $sql." WHERE ";
            $c = count($condition);
            $i=1;
           foreach($condition as $key=>$val){
                if($i==$c){
                    $sql = $sql." `$key`='$val' ";
                }else{
                    $sql = $sql."  `$key`='$val' AND ";
                }
                $i++;
           }
        }
        if($order1!=""){
            $sql = $sql." ORDER BY '$order1' '$order2' ";
        }
        if($limit!=""){
            $sql = $sql." LIMIT '$limit' ";
        }
       // echo"$sql<br>";
        $result = $this->connect()->query($sql);
       
        
       // print_r($result);
        return $result;
        // if($result->num_rows > 0){
        //     $arr = [];
        //     while($row = $result->fetch_assoc()){
        //         $arr[] = $row;
        //     }
        //     return $arr;
        // }else{
        //     return 0;
        // }

    }

    //function for Inserting data 

    public function insertData($table,$condition){


        if($condition!=""){
          
           foreach($condition as $key=>$val){
               $fieldarr[] = $key;
               $valuesarr[] = $val; 
           }
           $field = implode("`,`", $fieldarr);
           $field = '`'.$field.'`';
           $value = implode("','", $valuesarr);
           $value = "'".$value."'";
           $sql = "INSERT INTO $table ($field) VALUES ($value)";
           $result = $this->connect()->query($sql);
           //echo$sql;
           if($result){
             echo"Data inserted successfully.<br>";
           }
        

        }    
    }

    //Function for delete
    public function deleteData($table,$condition=""){

        $sql = "DELETE FROM `$table`";

        if($condition!=""){
            $sql = $sql." WHERE ";
            $c = count($condition);
            $i=1;
           foreach($condition as $key=>$val){
                if($i==$c){
                    $sql = $sql." `$key`='$val' ";
                }else{
                    $sql = $sql."  `$key`='$val' AND ";
                }
                $i++;
           }
           $result = $this->connect()->query($sql);
          return $result;
        }else{
            return 0;
        }
      
        

    }

    //fUNCTION FOR UPDATEDATA.
    public function updateData($table,$condition="",$field,$value){

        $sql = "UPDATE `$table`";

        if($condition!=""){
            $sql = $sql." SET ";
            $c = count($condition);
            $i=1;
           foreach($condition as $key=>$val){
                if($i==$c){
                    $sql = $sql." `$key`='$val' ";
                }else{
                    $sql = $sql."  `$key`='$val', ";
                }
                $i++;
           }
           $sql = $sql." WHERE `$field` = '$value'";
           $result = $this->connect()->query($sql);  
           return $result;
        
        }else{
            return 0;
        }
    }
      
        //funnction for search
        public function searchData($table,$search,$key){
            $sql = "SELECT * FROM `$table` WHERE";
            $c = count($key);
            $i=0;
            foreach($key as $val){
                if($i<$c-1){
                    $sql = $sql." `$key[$i]` LIKE '%$search%' OR ";
                }else{
                    $sql = $sql." `$key[$i]` LIKE '%$search%' ";
                }
                $i++;
            }
            $result = $this->connect()->query($sql);
            //echo" $sql";
            return $result;


        }

    }

?>
