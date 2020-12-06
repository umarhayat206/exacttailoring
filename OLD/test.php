<h6>test</h6>
<?php
phpinfo();
class connection {
    protected $link;
    private $server, $username, $password, $db;
    
    public function __construct($server, $username, $password, $db){
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->connect();
    }
    
    private function connect(){
        $this->link = mysql_connect($this->server, $this->username, $this->password);
        mysql_select_db($this->db, $this->link);
    }
    
    public function __sleep(){
        return array('server', 'username', 'password', 'db');
    }
    
    public function __wakeup(){
        $this->connect();
    }
}
$timeS = time();
echo("Began ".$timeS."<br />");
for($i=1;$i<=2;$i++){
	sleep(2);
	echo("During ". time()."<br />");
}
$timeF =  time() - $timeS;
echo("Finished ".$timeF);

?>