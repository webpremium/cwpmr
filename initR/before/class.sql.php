<?php

/*header('Content-type: text/plain; charset=utf-8');
/**/
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
/**/

if ( !isset($_SESSION) ) session_start();
/**/
	  



class rREQ{/*start*/
	private $host,$db,$table,$user,$pass,$connection,$_affected_rows_=0,$_insert_id_=0,
	$_type_value_=Array(
		'INT'=>true,
		'MEDIUMINT'=>true,
		'BIGINT'=>true,
		'FLOAT'=>true,
		'DOUBLE'=>true,
		'DECIMAL'=>true,
		'DATE'=>true,
		'DATETIME'=>true,
		'TIMESTAMP'=>true,
		'TIME'=>true,
		'YEAR'=>true,
		'CHAR'=>true,
		'VARCHAR'=>true,
		'BLOB'=>true,
		'TEXT'=>true,
		'TINYBLOB'=>true,
		'TINYTEXT'=>true,
		'MEDIUMBLOB'=>true,
		'MEDIUMTEXT'=>true,
		'LONGBLOB'=>true,
		'LONGTEXT'=>true,
		'ENUM'=>true
	),
	$command=Array(
		'DESCRIBE',
		'CALL',
		'DELETE',
		'DO',
		'HANDLER',
		'INSERT',
		'LOAD DATA INFILE',
		'LOAD XML',
		'REPLACE',
		'SELECT',
		'SHOW',
		'Subquery',
		'UPDATE',
		'ALTER DATABASE',
		'ALTER EVENT',
		'ALTER LOGFILE GROUP',
		'ALTER FUNCTION',
		'ALTER PROCEDURE',
		'ALTER SERVER',
		'ALTER TABLE',
		'ALTER TABLESPACE',
		'ALTER VIEW',
		'CREATE DATABASE',
		'CREATE DATABASE',
		'CREATE EVENT',
		'CREATE FUNCTION',
		'CREATE INDEX',
		'CREATE LOGFILE GROUP',
		'CREATE PROCEDURE and CREATE FUNCTION',
		'CREATE SERVER',
		'CREATE TABLE',
		'CREATE TABLESPACE',
		'CREATE TRIGGER',
		'CREATE VIEW',
		'DROP DATABASE',
		'DROP EVENT',
		'DROP FUNCTION',
		'DROP INDEX',
		'DROP LOGFILE GROUP',
		'DROP PROCEDURE and DROP FUNCTION',
		'DROP SERVER',
		'DROP TABLE',
		'DROP TABLESPACE',
		'DROP TRIGGER',
		'DROP VIEW',
		'RENAME TABLE',
		'TRUNCATE TABLE'
	),$option_command=Array(
		'SELECT'=>Array(
			'ALL'=>0,
			'DISTINCT'=>0,
			'DISTINCTROW'=>0,
			'HIGH_PRIORITY'=>1,
			'STRAIGHT_JOIN'=>2,
			'SQL_SMALL_RESULT'=>3,
			'SQL_BIG_RESULT'=>4,
			'SQL_BUFFER_RESULT'=>5,
			'SQL_CACHE'=>6,
			'SQL_NO_CACHE'=>6,
			'SQL_CALC_FOUND_ROWS'=>7
		)
		,'SHOW'=>Array(
			'COLUMNS'=>0,
			'TABLES'=>0
		)
	),$table_join=Array(
		'INNER JOIN',
		'CROSS JOIN',
		'STRAIGHT_JOIN',
		'FULL JOIN',
		'FULL OUTER JOIN',
		'LEFT JOIN',
		'RIGHT JOIN',
		'LEFT OUTER JOIN',
		'RIGHT OUTER JOIN',
		'NATURAL LEFT JOIN',
		'NATURAL RIGHT JOIN',
		'NATURAL LEFT OUTER JOIN',
		'NATURAL RIGHT OUTER JOIN'
	)
	,$apostrophe=Array('`'=>'`',"'"=>"'",'"'=>'"')
	,$TransactSQL=Array(
		'='=>'=',
		'>'=>'>',
		'<'=>'<',
		'>='=>'>=',
		'<='=>'<=',
		'<>'=>'<>',
		'!='=>'!=',
		'!<'=>'!<',
		'!>'=>'!>'
	)
	,$BooleanLOGIC=Array(
		'NOT'=>'NOT',
		'!'=>'!',
		'AND'=>'AND',
		'&&'=>'&&',
		'OR'=>'OR',
		'||'=>'||',
		'XOR'=>'XOR',
		'<='=>'<=',
		'<>'=>'<>',
		'!='=>'!=',
		'!<'=>'!<',
		'!>'=>'!>'
	)
	,$BooleanSIMPLE=Array(
		'AND'=>'AND',
		'&&'=>'&&',
		'OR'=>'OR',
		'||'=>'||',
		'XOR'=>'XOR'
	)
	,$TYPE=Array(
		'AND'=>'AND',
		'&&'=>'&&',
		'OR'=>'OR',
		'||'=>'||',
		'XOR'=>'XOR'
	)
	,$join_condition=Array(
		'ON',
		'USING'
	)
	,$index_hint=Array(
		'USE',
		'IGNORE',
		'FORCE'
	)
	,$ANDORS=Array()
	,$_ARG_=Array()
	,$position=0
	,$REQUEST_ARRAY=Array()
	,$REPONSEtmp=Array()
	,$_SELECTING_INNER_JOIN_TMP_=Array()
	,$REPONSEtmpJOIN=Array()
	,$memcache=false;
	public 
	$REPONSE=Array()
	,$num_rows=0
	,$OPTIMIZER=true
	,$trunkTimeSleep=200000
	,$version="10.1-A"
	;

	private function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	private function explode_recursive($p,$s,$b=false){
	$t='';$a=Array();
	if($b===false)$s=explode($p,$s);$b=true;
	if(count($s)==1)return current($s);
	$t=(string)current($s);unset($s[key($s)]);$a[$t]=$this->explode_recursive($p,$s,$b);return $a;
	}
	private function file_array( $a , $s=false ){
		if( $s==false ){
			return '<?php $array='.$this->array_writable($a).'; ?>';
		}
	}

	function array_writable($array,$e2=""){
		if( is_string( $e2 )===true )
			$e1=$e2;
		else
			$e1=(string)$e2
		;
		
		if($this->OPTIMIZER===true){
			$returnLign="";
			$e1.="";
		}else{
			$returnLign="\r\n";
			$e1.="	";
		}
		
		$lastOI=0;$distance=0;
		$v='';
		$r=$e1."Array(".$returnLign;
		
		foreach($array as $k => $d){
			if(is_array($k)) $r.=$e1.$v.$this->array_writable($k,$e1).$returnLign;
			else if(is_array($d)) $r.=$e1.$v."'".$k."'=>".$this->array_writable($d,$e1).$returnLign;
			else $r.=$e1.$v."'".$k."'=>'".addcslashes($d,"'\\")."'".$returnLign;
			
			if($v=='')$v=',';
		}
		return $r.$returnLign.$e2.')'.$returnLign;
	}

	private function quick_save( $a , $c, $fp=false , $m='w+' , $s=false , $b=false , $l='' ){
		if( $b===false && is_string($a) && ( strpos($a, '/')!==false && strpos($a, '/')!==false ) ){
			if(strpos($a, '/')!==false)
				$a=$this->explode_recursive('/',$a);
			else
				$a=$this->explode_recursive('\\',$a);
		}$b=true;
		if( is_array($a) ){
			foreach( $a as $k => $d ){
				$l.=$k;
				if(!is_dir($l) && $s==false ){
					mkdir($l);
					if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')chmod($l, 0775);
				}else if(!is_dir($l)){
					mkdir($l,$s);
					if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')chmod($l, 0775);
					
				}
				$l.='/';
				$this->quick_save($d,$c,$fp,$m,$s,$b,$l);
			}
		}else{
			$this->save(($l.$a),$c,$m, $fp);
		}
	}

	public function reset_fetch(){
		$this->position=0;
		reset( $this->REPONSE );
	}
	public function affected_rows(){
		
		return $this->_affected_rows_;
		
	}
	
	public function insert_id(){
		
		return $this->_insert_id_;
		
	}

	private function save($link,$data,$m='w+', $fp=false){
		if($link=='')return false;
		if(!isset($data))return false;
		if($fp==false)	$f = fopen($link,$m);
		else			$f = $fp;
		fwrite($f,$data);
		if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')chmod($link, 0664);
	}



	private function safe_virtual( $filename ){
		if(is_file($filename)){
			$dateStr=filemtime($filename);
			if(class_exists('Memcache')){
				if($this->memcache===false){
					$this->memcache=new Memcache;
					$this->memcache->connect('localhost', 11211) or die ("Could not connect");
				}
				$f=$_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename;
				$g=$this->memcache->get($f);
				if($g!==false)
					if($g["modifier"]==$dateStr)return$g["file"];
					else{
						include $filename;
						$this->memcache->delete($f);
						$this->memcache->set($f,Array('modifier'=>$dateStr,'file'=>$array),false,2592000);
						return $array;
					}
				else{
					include $filename;
					$this->memcache->set($f,Array('modifier'=>$dateStr,'file'=>$array),false,2592000);
					return $array;
				}
			}else if( extension_loaded('apc') && ini_get('apc.enabled') ){
				if(apc_exists ($_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename)){

						if(
							isset($_SESSION[$_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename]["modifier"])
							&&
							$_SESSION[$_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename]["modifier"]==$dateStr
						){
							return apc_fetch($_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename);
						}else{
							include $filename;
							apc_delete ( $_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename );
							if (ini_get('opcache.enable'))  opcache_reset ();
							
							apc_clear_cache();
							apc_clear_cache('user');
							apc_clear_cache('opcode');
							apc_store ( $_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename , $array ,0);
							$_SESSION[$_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename]["modifier"]=$dateStr;
							return $array;
						}
					
				}else{
					if(file_exists($filename)){
								
						include $filename;
						if (ini_get('opcache.enable'))  opcache_reset ();
						apc_store ( $_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename , $array ,0);
						$_SESSION[$_SERVER["HTTP_HOST"].'/'.$_SERVER['PHP_SELF'].'/'.$filename]["modifier"]=$dateStr;
						return $array;
					}
				}
			}else{
				if(isset($_SESSION[$filename]["modifier"])){
					
					
						if($_SESSION[$filename]["modifier"]==$dateStr){
								return $_SESSION[$filename]["file"];
							
						}else{
							include $filename;
							$_SESSION[$filename]["file"]=$array;
							$_SESSION[$filename]["modifier"]=$dateStr;
							return $array;
						}
					
				}else{
					if(file_exists($filename)){
					include $filename;
						$_SESSION[$filename]["file"]=$array;
						$_SESSION[$filename]["modifier"]=$dateStr;
						return $array;
					}
				}
			}/**/
		}
	}

	public function get_collumn_pos($a){
		$m=array();
		if( is_array($a) && is_array($a[0]) ){
			foreach( $a[0] as $k => $d ){
				$m[$d]=$k;
			}
		}
		return $m;
	}

	public function db($db) { 
		$this->db = $db;
		return true;
	}
	private function first_command($S){$a=Array();foreach($this->command as$C){$p=strpos($S,$C);if($p!==false)$a[$p]=$C;}ksort($a);return$a[key($a)];}
	private function _type_($S,$p=0){
		
		foreach($this->_type_value_ as$C => $BOOL){
			
			if( strtoupper(substr( $S , $p , strlen($C) )) == $C ){
				$type=Array();
				$p=$this->skip_space_nmb($S, $p+strlen($C) );
				if( substr( $S , $p , 1 )=='(' ){
					$type[$C]=substr( $S , $p+1 , strpos( $S , ')' , $p )-$p-1 );
				}else{
					$type[$C]=true;
				}
				
				
				return $type;
				
			}
			
		}
		
		return false;
	}

	private function opt_command_value($S,$T,$P=0){
		$a=Array();
		
		foreach($this->option_command[$T] as$K=>$C){
			$p=strpos($S,$K);
			if($p!==false){
				$a[$C]=$K;
				
				if($P<=$p)$P=$p+strlen($C);
			}
		}
		
		return Array('opt'=>$a,'pos'=>$P);
	}
	/*
	function first_command($S){
		$a=Array();
		foreach($this->command as$C){
			$p=strpos($S,$C);
			if($p!==false)$a[$p]=$C;
		}
		ksort($a);
		return$a[key($a)];
	}


	*/


	private function is_skipable($S){
		if( $S=="\r\n" )return 2;
		else if( $S==' ' || $S=="\r" || $S=="\n" )return 1;
		else return false;
	}

	private function skip_space_nmb($S,$p=0){
		
		while(	$A=$this->is_skipable(substr($S,$p,1)	)	)
			$p+=$A;
		return $p;
	}



	private function is_apostrophe($S){
		
		if( isset($this->apostrophe[$S]))return $this->apostrophe[$S];else return false;
	}
	private function next_apostrophe($S){
		return isset($apostrophe[$S]);
	}
	private function value_extract_value($S,$p,$more=0){
		
		$p=$this->skip_space_nmb($S,$p);
		$a=Array();
		
		if(substr( $S,$p-1,1)!='\\')
		$t=$this->is_apostrophe(substr( $S,$p,1)); else $t=false;
		
		
		
		if( $t!=false ){
			
			$tn=strpos($S,$t,$p+1);
			while( substr($S,$tn-1,2)=='\\'.$t ){
				$tn=strpos($S,$t,$tn+1);
			}
			
			$argument=substr($S,$p+1,$tn-$p-1);
			$p=$this->skip_space_nmb($S,$tn+1);
			
		}else{
			
			$equal=strpos($S,'=',$p);
			$next_space=strpos($S,' ',$p);
			$next_return=strpos($S,"\r\n",$p);
			$next_virgule=strpos($S,',',$p);

			if( $p<=$next_space ){
				if( $next_return!==false && $next_return<=$next_space){$next_space=$next_return;}
				if( $next_virgule!==false && $next_virgule<=$next_space){$next_space=$next_virgule;}
			}else{
				if( $next_return!==false && $next_virgule!==false){
					if( $next_return<=$next_virgule)
						$next_space=$next_return;
					else
						$next_space=$next_virgule;
				}else if( $next_return!==false )
					$next_space=$next_return;
				else if( $next_virgule!==false )
					$next_space=$next_virgule;
				else
					$next_space=$p;
			}
			if( $equal!==false && $equal<=$next_space ){
				$tn=$equal;
			}else{
				$tn=$next_space;
			}
			
			$argument=substr($S,$p,$tn-$p);
			
			
			$p=$this->skip_space_nmb($S,$tn);
		}
		
		
		
		if( substr($S,$p,1)=='=' && substr($S,$p-1,2)!='!=' ){
			$p++;
			if(substr( $S,$p-1,1)!='\\')
			$t=$this->is_apostrophe(substr( $S,$p,1)); else $t=false;
			
			
			
			
			if( $t!=false ){
				
				$tn=strpos($S,$t,$p+1);
				while( substr($S,$tn-1,2)=='\\'.$t ){
					$tn=strpos($S,$t,$tn+1);
				}
				
				$value=substr($S,$p+1,$tn-$p-1);
				$p=$tn+1;
			}else{
				$equal=strpos($S,',',$p);
				$next_space=strpos($S,' ',$p);
				$next_return=strpos($S,"\r\n",$p);
			
				if( $next_return!==false && $next_return<=$next_space)$next_space=$next_return;
				if( $equal!==false && $equal<=$next_space ){
					$tn=$equal;
				}else{
					$tn=$next_space;
				}
				
				$value=substr($S,$p,$tn-$p);
				$p=$tn;
			}
			//$this->_ARG_[$argument]=$value;
			if( $more=='type' && $more!=false ){
			
				$p=$this->skip_space_nmb($S,$p);
				
				$type=$this->_type_($S,$p);
				
				if($type!=false)$this->_ARG_[$argument]=Array( $value => $type );
				
			}else{
				$this->_ARG_[$argument]=$value;
			}	
		}else{
			if( $more=='type' ){
				$p=$this->skip_space_nmb($S,$p);
				//echo ' : '.$p.' - '.$S.' : ';
				$type=$this->_type_($S,$p);
				
				if($type!=false){
					$this->_ARG_[]=Array( $argument => $type );
				}else{
					$this->_ARG_[]=$argument;
				}
			}else{
				$this->_ARG_[]=$argument;
			}
		}
		
		
		
		$p=$this->skip_space_nmb($S,$p);
		
		
			//if(isset($_GET['r-adminv2']))print_r(substr($S,$p,1));
		
		
		if( substr($S,$p,1)==',' ){
			$p++;
			
			$return = $this->value_extract_value($S,$p);
			return  Array( 'table_references'=>$this->_ARG_ , 'pos'=>$return['pos']);
		}else{
			return  Array( 'table_references'=>$this->_ARG_ , 'pos'=>$p);
		}
		
		
		
	}

	private function __WHERE_condition_value__( $S,$p ){
		
		$i=0;
		$v=Array();
		
		if(substr($S,$p-1,1)!='\\')
		$t=$this->is_apostrophe(substr($S,$p,1)); else $t=false;
		
		if(strlen ($S)==$p){
			return Array('where_condition'=>$v,'pos'=>$p);
		}else if($t!=false){
			$e=strpos($S,$t,$p+1);
			$equal=strpos($S,'=',$p);
			
			if(substr($S,$equal,1)!='\\')
			$t=$this->is_apostrophe(substr($S,$equal+1,1)); else $t=false;
			
			if($t!=false){
				$e=strpos($S,$t,$equal+2);
				$v[substr($S,$p+1,$e-$p-1)]=substr($S,$equal+2,$e-$equal-2);
			}else{
				$E=strpos($S,' ',$p+1);
				$v[substr($S,$p+1,$e-$p-1)]=substr($S,$equal+1,$E-$equal);
			}
			$p=$e+1;
		}else{
			
			$equal=strpos($S,'=',$p);
			
			if(substr($S,$equal,1)!='\\')
			$t=$this->is_apostrophe(substr($S,$equal+1,1)); else $t=false;
			
			
			if($t!=false){
				$E=strpos($S,' ',$p+1);
				$e=strpos($S,$t,$equal+2);
				if( $equal!==false && $equal<=$E ){
					$v[substr($S,$p,$equal-$p)]=substr($S,$equal+2,$e-$equal-2);
				}else{
					$v[substr($S,$p,$E-$p)]=substr($S,$equal+2,$e-$equal-2);
				}
				$p=$e+1;
			}else{
				$E=strpos($S,' ',$equal+1);
				if( $equal!==false && $equal<=$E ){
					$v[substr($S,$p,$equal-$p)]=substr($S,$equal+1,$E-$equal-1);
				}else{
					$v[substr($S,$p,$E-$p)]=substr($S,$equal+1,$E-$equal-1);
				}
				$p=$E;
			}
			
		}return  Array('where_condition'=>$v,'pos'=>$p);
	}





	private function WHERE_condition_value( $S,$p ){if(strlen($S)==$p)return$v;	$i=0;$continue=true;
		while( $continue ){
			$r=$this->__WHERE_condition_value__( $S,$p );
			$p=$r['pos'];
			if( !isset($this->REQUEST_ARRAY['WHERE'][$i]) )$this->REQUEST_ARRAY['WHERE'][$i]=Array();
			$this->REQUEST_ARRAY['WHERE'][$i][count($this->REQUEST_ARRAY['WHERE'][$i])]=$r['where_condition'];
			$p=$this->skip_space_nmb($S,$p);
			foreach( $this->BooleanSIMPLE as $d )
				if( substr($S,$p,mb_strlen($d))==$d )
					if( $d=='AND' || $d=='&&' ){
						$p=$this->skip_space_nmb($S,$p+mb_strlen($d));
						$r=$this->__WHERE_condition_value__( $S,$p );
						if( !isset($this->REQUEST_ARRAY['WHERE'][$i]) )$this->REQUEST_ARRAY['WHERE'][$i]=Array();
						$this->REQUEST_ARRAY['WHERE'][$i][count($this->REQUEST_ARRAY['WHERE'][$i])]=$r['where_condition'];
						$p=$this->skip_space_nmb($S,$r['pos']);
					}else if( $d=='OR' || $d=='||' ){
						$i++;
						if( !isset($this->REQUEST_ARRAY['WHERE'][$i]) )$this->REQUEST_ARRAY['WHERE'][$i]=Array();
						$p=$this->skip_space_nmb($S,$p+mb_strlen($d));
						$r=$this->__WHERE_condition_value__( $S,$p );
						if( !isset($this->REQUEST_ARRAY['WHERE'][$i]) )$this->REQUEST_ARRAY['WHERE'][$i]=Array();
						$this->REQUEST_ARRAY['WHERE'][$i][count($this->REQUEST_ARRAY['WHERE'][$i])]=$r['where_condition'];
						$p=$this->skip_space_nmb($S,$r['pos']);
					}
			$continue=false;
			foreach( $this->BooleanSIMPLE as $d )if( substr($S,$p,mb_strlen($d))==$d )$continue=true;
		}
		return $this->REQUEST_ARRAY['WHERE'];
	}


	public function _format_row_($row,$m){
		foreach( $row as $k => $d ){
			if( is_array( $d ) ){
				$row[$k]='(array)'.$this->array_writable($d);
			}
		}
		return $row+$this->_orient_row_($row,$m);
	}
	public function _orient_row_($row,$m){
		$a=Array();
		foreach( $m as $k => $d )if(isset($row[$d])){
			$a[$k]=$row[$d];
		}return $a;
	}
	
	
	private function _fetch_array_(){
		
		if( $this->position==0 && current($this->REPONSE) ){
			$this->position=1;
			return current($this->REPONSE);
		}else{
			$k1=key($this->REPONSE);
			next($this->REPONSE);
			$k2=key($this->REPONSE);
			if( $k1 != $k2 ){
				return current($this->REPONSE);
			}else return false;
		}
	}
	public function fetch_array(){
		return $this->_fetch_array_();
	}


	
	private function _SELECTING_LEFT_JOIN_($d,$dJOIN,$bool){
		if($bool)$this->REPONSEtmp[]=$d+$dJOIN;
		else{
			
		}
	}
	private function _SELECTING_RIGHT_JOIN_($d,$dJOIN,$bool){
		$this->REPONSEtmp[]=$dJOIN+$d;
	}
	private function _SELECTING_INNER_JOIN_($d,$dJOIN,$bool){
		if( isset( $this->_SELECTING_INNER_JOIN_TMP_['nmb'] ) ){
			$this->_SELECTING_INNER_JOIN_TMP_['nmb']++;
		}else{
			$this->_SELECTING_INNER_JOIN_TMP_['nmb']=0;
		}
		if( 1 <= $this->_SELECTING_INNER_JOIN_TMP_['nmb'] ){
			
			$this->REPONSEtmp[]=$d+$dJOIN;
			
		}else $this->REPONSEtmp[]=$d+$dJOIN;
		
	}
	private function _SELECTING_FULL_JOIN_($d,$dJOIN,$bool){
		$this->REPONSEtmp[]=$d+$dJOIN;
	}
	
	
	private function _SELECTING_JOINS_(){
		
		foreach( $this->REQUEST_ARRAY['ON'] as $var1 => $var2 ){
			$var1 = explode( '.' , $var1 );
			$var2 = explode( '.' , $var2 );
			foreach( $this->REPONSEtmpJOIN['FROM'][$var1[0]] as $k => $d ){
				if( $this->REQUEST_ARRAY['JOINS']=='INNER JOIN' ){
					foreach( $this->REPONSEtmpJOIN['FROM'][$var2[0]] as $dJOIN ){
						if( $d[$var1[1]] == $dJOIN[$var2[1]] ){
							if( $this->REQUEST_ARRAY['JOINS']=='LEFT JOIN' )
								$this->_SELECTING_LEFT_JOIN_($d,$dJOIN,true);
							else if( $this->REQUEST_ARRAY['JOINS']=='RIGHT JOIN' )
								$this->_SELECTING_RIGHT_JOIN_($d,$dJOIN,true);
							
							else if( $this->REQUEST_ARRAY['JOINS']=='INNER JOIN' ){
								
								_SELECTING_INNER_JOIN_($d,$dJOIN,true);
								
								unset( $this->_SELECTING_INNER_JOIN_TMP_['nmb'] );
								
							}else if( $this->REQUEST_ARRAY['JOINS']=='FULL JOIN' )
								_SELECTING_FULL_JOIN_($d,$dJOIN,true);
							
							
							
						}else{
							if( $this->REQUEST_ARRAY['JOINS']=='LEFT JOIN' ){
								$this->_SELECTING_LEFT_JOIN_($d,$dJOIN,false);
							}
							else if( $this->REQUEST_ARRAY['JOINS']=='RIGHT JOIN' )
								$this->_SELECTING_RIGHT_JOIN_($d,$dJOIN,false);
							
						}
					}
				}
			}
		}
	}
	private function wd_remove_accents($str, $charset='utf-8')
{
    //$str = htmlentities($str, ENT_NOQUOTES, $charset);
    
    return preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', htmlentities($str, ENT_NOQUOTES, $charset));
    //$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
   // $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    //$str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    return $str;
}
	private function _SELECTING_WHERE_($F){
		if(isset($F) && $F!=''){
			/*echo realpath($this->db.'/'.$F.'/index.php');*/
			$array=$this->safe_virtual( $this->db.'/'.$F.'/index.php' );
			if($array==false)return false;
			/*print_r($array);*/
			
			$m = $this->get_collumn_pos($array);
			
			if($array[1][$m['type']]=='article'){
				$array=$this->safe_virtual( $this->db.'/'.$F.'/_0.php' );
			}else if($array[1][$m['type']]=='menu'){
				$array=$this->safe_virtual( $this->db.'/'.$F.'/menu.php' );
			}else if($array[1][$m['type']]=='table'){
				$array=$this->safe_virtual( $this->db.'/'.$F.'/table.php' );
			}else if($array[1][$m['type']]=='user'){
				$array=$this->safe_virtual( $this->db.'/'.$F.'/user.php' );
			}else if($array[1][$m['type']]=='privileges'){
				$array=$this->safe_virtual( $this->db.'/'.$F.'/privileges.php' );
			}
			$m = $this->get_collumn_pos($array);
			unset($array[0]);
			
			$j=1;
			
			$EXISTresult=Array();
			
			foreach( $array as $key => $row ){
				
				if( isset($this->REQUEST_ARRAY['LIMIT']) && $j <= $this->REQUEST_ARRAY['LIMIT'][0] || !isset($this->REQUEST_ARRAY['LIMIT']) ){
					$orderBY='';
					if(isset( $this->REQUEST_ARRAY['WHERE'] )){
						foreach( $this->REQUEST_ARRAY['WHERE'] as $OR ){
							
							
							$size = sizeOf($OR);
							for ($i=0; $i<$size; $i++)
								foreach($OR[$i] as $collumn => $value )
									if( strpos($value,"%")===0 && substr($value,-1)==="%" ){
										if( stripos($this->wd_remove_accents($row[$m[$collumn]]),$this->wd_remove_accents(substr($value,1,-1)))!==false && !isset( $EXISTresult[$key] ) )$EXISTresult[$key]=true;
										
									}else
										if( isset($m[$collumn]) &&  isset($row[$m[$collumn]]) && $row[$m[$collumn]]." " == $value." " && !isset( $EXISTresult[$key] ) ) $EXISTresult[$key]=true;
							
							
							
							if( isset($EXISTresult[$key]) ){
								if( isset($this->REQUEST_ARRAY['GROUP_BY']) ){
									foreach( $this->REQUEST_ARRAY['GROUP_BY'] as $col ){
										$orderBY.=$col;
									}
									$this->REPONSEtmp[$orderBY.$i]=$this->_format_row_($row,$m);
									$i++;
								}else{
									$this->REPONSEtmp[]=$this->_format_row_($row,$m);
								}
							}
						}
					}else{
						if( isset($this->REQUEST_ARRAY['GROUP_BY']) ){
							foreach( $this->REQUEST_ARRAY['GROUP_BY'] as $col ){
								$orderBY.=$col;
							}
							$this->REPONSEtmp[$orderBY.$i]=$this->_format_row_($row,$m);
							$i++;
						}else{
						
							$this->REPONSEtmp[]=$this->_format_row_($row,$m);
						}
					}
				}else{
					break;
				}
				$j++;
			}
			return $this->REPONSEtmp;
		}
	}
	private function SELECT($REQ){
		
		$tmp=0;
		$p=0;
		//echo $REQ;
		
		/*         OPTION         *//*non complété*/
		
		$tmp=strpos($REQ,'SELECT');
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('SELECT'));
			$opt=$this->opt_command_value($REQ,'SELECT',$p);
			$this->REQUEST_ARRAY['OPTION']=$opt['opt'];
			if( $p<<$opt['pos'] )$p=$opt['pos'];
		}
		
		
		/*         FROM table_references         */
		
		$tmp=strpos($REQ,'FROM',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('FROM'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['FROM']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		$p=$this->skip_space_nmb($REQ,$p);
		
		foreach( $this->table_join as $d ){
			if( substr($REQ,$p,strlen($d))==$d ){
				
				$p+=strlen($d);
				$p=$this->skip_space_nmb($REQ,$p);
				$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
				$this->REQUEST_ARRAY[$d]=$v['table_references'];
				if( $p<<$v['pos'] )$p=$v['pos'];
				
				$this->REQUEST_ARRAY['JOINS']=$d;
				
				$p=$this->skip_space_nmb($REQ,$p);
				if( substr($REQ,$p,2)=='ON' ){
					$p+=2;
					$p=$this->skip_space_nmb($REQ,$p);
					
					
					
					$v=$this->value_extract_value($REQ,$p-1);$this->_ARG_=Array();
					
					
					
					$this->REQUEST_ARRAY['ON']=$v['table_references'];
					if( $p<<$v['pos'] )$p=$v['pos'];
					
				}
				
				
				
			}
		}
		
		
		
		
		
		/*         PARTITION         */
		
		
		
		/*         WHERE         */
		
		$tmp=strpos($REQ,'WHERE',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('WHERE'));
			$this->WHERE_condition_value($REQ,$p);
		}
		
		
		/*         GROUP BY         */
		
		
		$tmp=strpos($REQ,'GROUP BY',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('GROUP BY'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['GROUP_BY']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		/*         HAVING         */
		
		
		
		/*         ORDER BY         */
		
		$this->REQUEST_ARRAY['ORDER_BY']=false;
		$tmp=strpos($REQ,'ORDER BY',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('ORDER BY'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['ORDER_BY']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		/*         ASC | DESC         */
		
		$tmp=strpos($REQ,'ASC',$p);
		if( $tmp!==false ){
			$p=$tmp+strlen('ASC');
			$this->REQUEST_ARRAY['ORDER']='ASC';
		}
		$tmp=strpos($REQ,'DESC',$p);
		if( $tmp!==false ){
			$p=$tmp+strlen('DESC');
			$this->REQUEST_ARRAY['ORDER']='DESC';
		}
		
		/*
		$this->REQUEST_ARRAY=Array(
			 'REQ'=>'SELECT'
			,'OPTION'=>$OPTION
			,'FROM'=>$FROM
			,'WHERE'=>$WHERE
			,'GROUP_BY'=>$GROUP_BY
			,'ORDER_BY'=>$ORDER_BY
			,'ORDER'=>$ORDER
		);*/
		
		
		/*         LIMIT         */
		
		
		$tmp=strpos($REQ,'LIMIT',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('LIMIT'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['LIMIT']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		/*         PROCEDURE         */
		
		
		
		/*         INTO OUTFILE         */
		
		
		
		/*         CHARACTER SET         */
		
		
		
		/*         export_options         */
		
		
		
		/*         INTO DUMPFILE         */
		
		
		
		/*         INTO         */
		
		
		
		/*         FOR UPDATE | LOCK IN SHARE MODE         */
		
		
		
		/*return print_r($this->REQUEST_ARRAY);*/
		
		
		
		$exist=true;
		
		$this->REPONSE=Array();
		$i=0;
			
			
		if( isset($this->REQUEST_ARRAY['JOINS'] ) && $this->REQUEST_ARRAY['JOINS']!=false ){
			
			foreach( $this->REQUEST_ARRAY['FROM'] as $F ){
				
				$this->REPONSEtmp=Array();
				
				$this->_SELECTING_WHERE_($F);
				
				$this->REPONSEtmpJOIN['FROM'][$F]=$this->REPONSEtmp;
				
			}
			foreach( $this->REQUEST_ARRAY[$this->REQUEST_ARRAY['JOINS']] as $F ){
				
				$this->REPONSEtmp=Array();
				
				$this->_SELECTING_WHERE_($F);
				
				$this->REPONSEtmpJOIN['FROM'][$F]=$this->REPONSEtmp;
				
				$this->REPONSEtmpJOIN[$this->REQUEST_ARRAY['JOINS']][$F]=$F;
				
			}
			
			$this->_SELECTING_JOINS_();
			
			$this->REPONSE=$this->REPONSEtmp;
			
			
			
			
		}else{
			foreach( $this->REQUEST_ARRAY['FROM'] as $F ){
				
				if( !is_array($F) ){
					$this->_SELECTING_WHERE_($F);
					
					$this->REPONSE=$this->REPONSEtmp;
					
				}
					
			}
		}
		
		
		
		if( isset($this->REQUEST_ARRAY['ORDER']) ){
			if( $this->REQUEST_ARRAY['ORDER']=='ASC' )
				ksort($this->REPONSE);
			else if( $this->REQUEST_ARRAY['ORDER']=='DESC' )
				krsort($this->REPONSE);
		}
		
		
		
		reset($this->REPONSE);
		
		$this->num_rows=count( $this->REPONSE );

		
	}
	private function SHOW($REQ){
		
		$tmp=0;
		$p=0;
		
		
		/*         OPTION         *//*non complété*/
		
		$tmp=strpos($REQ,'SHOW');
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('SHOW'));
			$opt=$this->opt_command_value($REQ,'SHOW',$p);
			$this->REQUEST_ARRAY['OPTION']=$opt['opt'];
			
			if( $p<<$opt['pos'] )$p=$opt['pos'];
		}
		
		
		/*         FROM table_references         */
		
		$tmp=strpos($REQ,'FROM',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('FROM'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['FROM']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		//print_r($this->REQUEST_ARRAY);
		$p=$this->skip_space_nmb($REQ,$p);
		
		if ( $this->REQUEST_ARRAY['OPTION'][0] == 'COLUMNS' ){
			
			
			include( $this->db.'/'.$this->REQUEST_ARRAY['FROM'][0].'/index.php' );
			$m = $this->get_collumn_pos($array);
			$type=$array[1][$m['type']];
			$collumnTYPE=$array[1][$m['collumnTYPE']];
			if($type=='article')$fn='_0.php';
			else if($type=='menu')$fn='menu.php';
			else if($type=='table')$fn='table.php';
			else if($type=='user')$fn='user.php';
			
			include( $this->db.'/'.$this->REQUEST_ARRAY['FROM'][0].'/'.$fn );
			
			if(is_array($array)){
				foreach( $array[0] as $k => $d ){
					$this->REPONSE[$k]['Field']=$d;
					if(isset($collumnTYPE[$d])){
						$this->REPONSE[$k]['type']=$collumnTYPE[$d];
					}
					$this->REPONSE[$k][]=$d;
				}
			}
			
		}else if ( $this->REQUEST_ARRAY['OPTION'][0] == 'TABLES' ){
			
		}
		
		
		/**/
		
		
		
		reset($this->REPONSE);
		
		$this->num_rows=count( $this->REPONSE );

		
	}
	/*					DESCRIBE					*/
	private function DESCRIBE($REQ){
		$REQ=trim($REQ);
		if( substr($REQ,-1,1 ) == ";" )$REQ=substr($REQ,0,-1 );
		
		$tmp=strpos($REQ,'DESCRIBE')+strlen("DESCRIBE");
		$p=$this->skip_space_nmb($REQ,$tmp);
		$v=$this->value_extract_value($REQ,$p);
		$col=Array();
		foreach( $v["table_references"] as $F ){
			if( $F!='' && is_file($this->db.'/'.$F.'/index.php') ){
			
				include( $this->db.'/'.$F.'/index.php' );
				$m = $this->get_collumn_pos($array);
				$type=$array[1][$m['type']];
				unset($array);
				$array=false;
				/* aquisition*/
				if($type=='article')$fn='_0.php';
				else if($type=='menu')$fn='menu.php';
				else if($type=='table')$fn='table.php';
				else if($type=='user')$fn='user.php';
				if( is_file($this->db.'/'.$F.'/'.$fn ) ){
					include( $this->db.'/'.$F.'/'.$fn );
					foreach( $array[0] as $d ){
						
						$this->REPONSE[]=$d;
						
					}
				}
			}
			
			
		}
		
	}

	/*					INSERT					*/
	private function INSERT($REQ,$fp=false){
		
		
		$tmp=0;
		$p=0;
		$a=Array();
		
		
		$tmp=strpos($REQ,'INTO');
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('INTO'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['INSERT']['INTO']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		$tmp=strpos($REQ,'(',$p)+1;
		$tmp2=strpos($REQ,')',$p);
		
		$this->REQUEST_ARRAY['INSERT']['VALUE']=Array();
		if( $tmp!==false ){
			$collumn=$this->value_extract_value(substr($REQ,0,$tmp2).' ',$tmp);
			$this->_ARG_=Array();
			$tmp=strpos($REQ,'(',$tmp2+1)+1;
			$tmp2=strpos($REQ,')',$tmp);
			$tmpError=strpos($REQ,'(',$tmp)+1;
			$tmp2T=strpos($REQ,'(',$tmp)+1;
			
			while( $tmp<=$tmpError && $tmpError<=$tmp2 && $tmpError!==false && $tmpError!=1 ){
				$tmp2T=strpos($REQ,')',$tmp2+1);
				$tmpError=strpos($REQ,'(',$tmpError)+1;
				if($tmp2T!==false)$tmp2=$tmp2T;
			}
			
			$value=$this->value_extract_value(substr($REQ,0,$tmp2).' ',$tmp);
			
			
			$this->_ARG_=Array();
			
			
			
			
			foreach( $collumn['table_references'] as $k => $d ){
				$this->REQUEST_ARRAY['INSERT']['VALUE'][$d]=$value['table_references'][$k];
			}
			
		}
		
		
		foreach( $this->REQUEST_ARRAY['INSERT']['INTO'] as $F ){
		/*if( is_array( $F ) ){
			print_r($this->REQUEST_ARRAY);
			die;
		}else */if( !is_array($F) && is_file ($this->db.'/'.$F.'/index.php') ){
			
		
			
			include( $this->db.'/'.$F.'/index.php' );
			if(is_array($array)){
				$m = $this->get_collumn_pos($array);
				$type=$array[1][$m['type']];
				unset($array);
				$array=false;
				
				
				
				/* aquisition*/
				if($type=='article')$fn='_0.php';
				else if($type=='menu')$fn='menu.php';
				else if($type=='table')$fn='table.php';
				else if($type=='user')$fn='user.php';
				
				if( $fp = fopen($this->db.'/'.$F.'/'.$fn, 'c+') ){0;}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->INSERT($REQ);
				}
				while( flock($fp, LOCK_EX | LOCK_NB )==false ){
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->INSERT($REQ);
				}
				eval('?>'.fread($fp, filesize($this->db.'/'.$F.'/'.$fn)));
				/* /aquisition*/
				
				
				
				
				$a=Array();
				foreach( $array[0] as $k => $d ){
					if( isset( $this->REQUEST_ARRAY['INSERT']['VALUE'][$d] ) ){
						
						//print_r($this->REQUEST_ARRAY['INSERT']['VALUE'][$d]);insert_id
						
						if(strpos($d,'(array)')!==false && strpos($d,'(array)')==0)$DD=eval( '$arrayEVAL='.$this->REQUEST_ARRAY['INSERT']['VALUE'][$d].';' );
						else $DD=false;
						if( $DD===false ){
							$a[$k]=$this->REQUEST_ARRAY['INSERT']['VALUE'][$d];
						}else{
							$a[$k]=$arrayEVAL;
						}
						
						$this->_affected_rows_++;
					}else
						$a[$k]='';
				}
				
				
				if($type=='article')array_splice($array,1,0,Array( $a ));
				else if($type=='menu')$array[]=$a;
				else if($type=='table')$array[]=$a;
				else if($type=='user')$array[]=$a;
				
				end( $array );
				$this->_insert_id_ = key( $array );
				
				
				/* écriture fermeture*/
				$aFile=$this->file_array($array);
				if($array!=false && $aFile!=false){
					rewind($fp);
					ftruncate($fp, 0);
					$this->quick_save( $this->db.'/'.$F.'/'.$fn , $aFile ,$fp);
					fflush($fp);
					flock($fp, LOCK_UN);
					fclose($fp);
				
				}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					fclose($fp);
					return $this->INSERT($REQ);
				}
				/* /écriture fermeture*/
			}
			
		}}
		return $this->REQUEST_ARRAY;
		/**/
		
	}

	private function UPDATE($REQ){
		
		
		$tmp=0;
		$p=0;
		$a=Array();
		
		
		$tmp=strpos($REQ,'UPDATE');
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('UPDATE'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['UPDATE']['INTO']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		$tmp=strpos($REQ,'SET');
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('SET'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['UPDATE']['SET']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		
		$tmp=strpos($REQ,'WHERE',$p);
		
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('WHERE'));
			$this->REQUEST_ARRAY['UPDATE']['WHERE']=$this->WHERE_condition_value($REQ,$p);
		}
		
		
		
		
		
		
			
		
		
		$exist=true;
		
		
		$i=0;
		foreach( $this->REQUEST_ARRAY['UPDATE']['INTO'] as $F ){
			
			include( $this->db.'/'.$F.'/index.php' );
			$m = $this->get_collumn_pos($array);
			$type=$array[1][$m['type']];
			
			
			/* aquisition*/
				if($type=='article')$fn='_0.php';
				else if($type=='menu')$fn='menu.php';
				else if($type=='table')$fn='table.php';
				else if($type=='user')$fn='user.php';
				
				if( $fp = fopen($this->db.'/'.$F.'/'.$fn, 'c+') ){0;}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->UPDATE($REQ);
				}
				while( flock($fp, LOCK_EX | LOCK_NB )==false ){
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->UPDATE($REQ);
				}
				eval('?>'.fread($fp, filesize($this->db.'/'.$F.'/'.$fn)));
				/* /aquisition*/
			
			
			
			
			
			
			
			$m = $this->get_collumn_pos($array);
			
			
			foreach( $array as $id => $row )if($id!=0){
			
			
				
				
				
				$orderBY='';
				if(isset( $this->REQUEST_ARRAY['UPDATE']['WHERE'] )){
					foreach( $this->REQUEST_ARRAY['UPDATE']['WHERE'] as $OR ){
						$exist=true;
						foreach( $OR as $AND ){
							
							foreach( $AND as $collumn => $value ){
							
								
							
							
								settype($row[$m[$collumn]], "string");
								settype($value, "string");
								if( $row[$m[$collumn]].' ' != $value.' ' ){
									$exist=false;
								}
								
							}
							
						}
						
						if( $exist==true ){
							
							foreach( $this->REQUEST_ARRAY['UPDATE']['SET'] as $k => $d ){
								if(strpos($d,'(array)')!==false && strpos($d,'(array)')==0)eval( '$DD= '.$d.';' );
								else $DD=false;
								/*echo $k;/**/
								if( $DD===false ){
									/*print_r($id);
									echo "<br />";
									print_r($k);
									echo "<br />";
									print_r($m);
									echo "<br />";
									print_r($d);
									echo "<br />";
									/**/
									if( !isset($m[$k]) ){
										
										$array[0][]=$k;
										$m = $this->get_collumn_pos($array);
										
									}
									
									$array[$id][$m[$k]]=$d;
									$this->_affected_rows_++;
								}else{
									$array[$id][$m[$k]]=$arrayEVAL;
									$this->_affected_rows_++;
								}
							}
						}
					}
				}else{
					
				}
			}
			/* écriture fermeture*/
				$aFile=$this->file_array($array);
				$e=eval('?>'.$aFile.'<?php ;');
				if($e!==false){
					if($array!=false && $aFile!=false ){
						rewind($fp);
						ftruncate($fp, 0);
						$this->quick_save( $this->db.'/'.$F.'/'.$fn , $aFile ,$fp);
						fflush($fp);
						flock($fp, LOCK_UN);
						fclose($fp);
					
					}else{
						fflush($fp);
						flock($fp, LOCK_UN);
						usleep ( $this->trunkTimeSleep );
						fclose($fp);
						return $this->UPDATE($REQ);
					}
				}else{
						fflush($fp);
						flock($fp, LOCK_UN);
						usleep ( $this->trunkTimeSleep );
						fclose($fp);
				}
				/* /écriture fermeture*/
			
			
			
		}
		
		
		
		
		/**/
		
	}
	private function DELETE($REQ){
		
		$tmp=0;
		$p=0;
		
		
		/*         OPTION         *//*non complété*/
		
		
		$this->REQUEST_ARRAY['DELETE']=Array();
		$tmp=strpos($REQ,'FROM',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('FROM'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['DELETE']['FROM']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		
		/*         PARTITION         */
		
		
		
		/*         WHERE         */
		
		$tmp=strpos($REQ,'WHERE',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('WHERE'));
			$this->REQUEST_ARRAY['DELETE']['WHERE']=$this->WHERE_condition_value($REQ,$p);
		}
		
		
		
		
		
		
		
		
		
		$exist=true;
		
		
		$i=0;
		foreach( $this->REQUEST_ARRAY['DELETE']['FROM'] as $F ){
			
			include( $this->db.'/'.$F.'/index.php' );
			$m = $this->get_collumn_pos($array);
			$type=$array[1][$m['type']];

			
			
			
			/* aquisition*/
				if($type=='article')$fn='_0.php';
				else if($type=='menu')$fn='menu.php';
				else if($type=='table')$fn='table.php';
				else if($type=='user')$fn='user.php';
				
				if( $fp = fopen($this->db.'/'.$F.'/'.$fn, 'c+') ){0;}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->DELETE($REQ);
				}
				while( flock($fp, LOCK_EX | LOCK_NB )==false ){
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->DELETE($REQ);
				}
				eval('?>'.fread($fp, filesize($this->db.'/'.$F.'/'.$fn)));
				/* /aquisition*/
			
			
			
			
			$m = $this->get_collumn_pos($array);
			
			
			
			foreach( $array as $id => $row )if($id!=0){
				
				$orderBY='';
				if(isset( $this->REQUEST_ARRAY['DELETE']['WHERE'] )){
					foreach( $this->REQUEST_ARRAY['DELETE']['WHERE'] as $OR ){
						$exist=true;
						foreach( $OR as $AND ){
							
							foreach( $AND as $collumn => $value )if(isset( $m[$collumn] ) && isset( $row[$m[$collumn]] )){
								settype($row[$m[$collumn]], "string");
								settype($value, "string");
								if( $row[$m[$collumn]].' ' != $value.' ' ){
									$exist=false;
								}
								
							}else{
								
								
								
							}
							
						}
						
						if( $exist==true ){
							unset( $array[$id] );
							$this->_affected_rows_++;
						}
					}
				}else{
					
				}
			}
			
			/* écriture fermeture*/
				$aFile=$this->file_array($array);
				if($array!=false && $aFile!=false){
					rewind($fp);
					ftruncate($fp, 0);
					$this->quick_save( $this->db.'/'.$F.'/'.$fn , $aFile ,$fp);
					fflush($fp);
					flock($fp, LOCK_UN);
					fclose($fp);
				
				}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					fclose($fp);
					return $this->DELETE($REQ);
				}
				/* /écriture fermeture*/
			


			
		}
		
		
		
		
		
	}
	private function CREATE_TABLE($REQ){
		
		
		$p=0;	
		
		$this->REQUEST_ARRAY['CREATE TABLE']=Array();
		$tmp=strpos($REQ,'CREATE TABLE',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('CREATE TABLE'));
			$v=$this->value_extract_value($REQ,$p);
			
			$this->_ARG_=Array();
			$this->REQUEST_ARRAY['CREATE TABLE']['NAME']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		$e=strpos($REQ,'(',$p)+1;
		$e1=strrpos($REQ,')',$p);
		$CREATE=substr($REQ,$e,$e1-$e);
		$p=$e1+1;
		$CREATE=explode(',',$CREATE);
		$tmp=Array();
		foreach( $CREATE as $K => $C ){
			$tmp=$this->value_extract_value($C,0,'type');
			//$tmp2=$this->value_extract_value($C,$tmp['pos']);
		}
		
		//print_r($tmp);
		//print_r($tmp2);
		
		
		
		$this->REQUEST_ARRAY['CREATE TABLE']['COLLUMN']=$tmp['table_references'];
		
		
		
		
		$indexValue=Array();
		
		$aI=Array();
		foreach( $this->REQUEST_ARRAY['CREATE TABLE']['COLLUMN'] as $d ){
			//print_r($d);
			if( is_array( $d ) ){
				foreach( $d as $collumn => $TYPE ){
					$indexValue[$collumn]=$TYPE;
					$aI[]=$collumn;
				}
			}else{
				$aI[]=$d;
			}
		}
		if(isset($indexValue)){
			
			
			$index=Array(
							'0'=>	Array(	'0'=>'type','1'=>'collumnTYPE'	)
							,'1'=>	Array(	'0'=>'table','1'=>$indexValue	)
						);
			
		}else{
			
			$index=Array(
							'0'=>	Array(	'0'=>'type'	)
							,'1'=>	Array(	'1'=>'table')
						);
			
		}
		/*print_r($aI);
		print_r($indexValue);*/
		
		/*$tmp="\r\nCREATE TABLE:";
		$tmp2="\r\nNOCREATE TABLE:";*/
		
		foreach( $this->REQUEST_ARRAY['CREATE TABLE']['NAME'] as $table ){
			
			if( !is_array($table) && !is_dir($this->db.'/'.$table) ){
				$this->quick_save( $this->db.'/'.$table.'/index.php' , $this->file_array($index) );
				$this->quick_save( $this->db.'/'.$table.'/table.php' , $this->file_array(Array('0'=>$aI)) );
				//echo 'table created';
				/*$tmp.=' '.$table;*/
			}else{
				
			}
			
		}
		
		/*echo $tmp.$tmp2;*/
		
		
	}

	private function DROP_TABLE($REQ){
		
		
		$p=0;	
		
		$this->REQUEST_ARRAY['DROP TABLE']=Array();
		$tmp=strpos($REQ,'DROP TABLE',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('DROP TABLE'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['DROP TABLE']['NAME']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		/*$tmp='DROP TABLE :';*/
		foreach( $this->REQUEST_ARRAY['DROP TABLE']['NAME'] as $table ){
			
			if(is_dir($this->db.'/'.$table)){
				$this->deleteDir($this->db.'/'.$table);
				/*$tmp.=' '.$table;*/
			}
		}
		
		/*echo $tmp;*/
	}
	private function TRUNCATE_TABLE($REQ){
		
		
		$p=0;	
		
		$this->REQUEST_ARRAY['TRUNCATE TABLE']=Array();
		$tmp=strpos($REQ,'TRUNCATE TABLE',$p);
		if( $tmp!==false ){
			$p=$this->skip_space_nmb($REQ,$tmp+strlen('TRUNCATE TABLE'));
			$v=$this->value_extract_value($REQ,$p);$this->_ARG_=Array();
			$this->REQUEST_ARRAY['TRUNCATE TABLE']['NAME']=$v['table_references'];
			if( $p<<$v['pos'] )$p=$v['pos'];
		}
		
		/*$tmp="\r\nTRUNCATE TABLE :";*/
		foreach( $this->REQUEST_ARRAY['TRUNCATE TABLE']['NAME'] as $F )if( is_file($this->db.'/'.$F.'/index.php') ){
			
			include( $this->db.'/'.$F.'/index.php' );
			$m = $this->get_collumn_pos($array);
			$type=$array[1][$m['type']];
			
			
			

			/* aquisition*/
				if($type=='article')$fn='_0.php';
				else if($type=='menu')$fn='menu.php';
				else if($type=='table')$fn='table.php';
				else if($type=='user')$fn='user.php';
				
				if( $fp = fopen($this->db.'/'.$F.'/'.$fn, 'c+') ){0;}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->TRUNCATE_TABLE($REQ);
				}
				while( flock($fp, LOCK_EX | LOCK_NB )==false ){
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					return $this->TRUNCATE_TABLE($REQ);
				}
				$fileS=filesize($this->db.'/'.$F.'/'.$fn);
				if(1<=$fileS)eval('?>'.fread($fp, filesize($this->db.'/'.$F.'/'.$fn)));
				/* /aquisition*/
			
			
			$array=Array('0'=>$array[0]);

			/* écriture fermeture*/
				$aFile=$this->file_array($array);
				if($array!=false && $aFile!=false){
					rewind($fp);
					ftruncate($fp, 0);
					$this->quick_save( $this->db.'/'.$F.'/'.$fn , $aFile ,$fp);
					fflush($fp);
					flock($fp, LOCK_UN);
					fclose($fp);
				
				}else{
					fflush($fp);
					flock($fp, LOCK_UN);
					usleep ( $this->trunkTimeSleep );
					fclose($fp);
					return $this->TRUNCATE_TABLE($REQ);
				}
				/* /écriture fermeture*/
			
			
				/*$tmp.=' '.$table;*/
			
			
			
		}/*echo $tmp;*/
		
	}


	function REPONSE(){
		
		return($this->REPONSE);
		
	}
	function query($REQ){
		$REQ.=' ';
		$C=$this->first_command($REQ);
		return $this->{str_replace(' ','_',$C)}($REQ);
	}


	/*end*/	 
}









/********************************************************demo start********************************************************/




/*

$runnerTOTAL = microtime(true);

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/**/

$REQUETE=new rREQ();

$REQUETE->db('db');

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/


/*
$REQUETE->query("DROP TABLE table_name");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/


/*
$REQUETE->query("
CREATE TABLE table_name
(
PersonID int,
CustomerID int,
LastName  varchar(255),
'FirstName' varchar(255),
Address varchar(255),
City varchar(255)
);
");
$REQUETE->query("
CREATE TABLE Customers
(
PersonID int,
CustomerID int,
LastName  varchar(255),
'FirstName' varchar(255),
Address varchar(255),
City varchar(255)
);
");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/*

$REQUETE->query("INSERT INTO table_name ( PersonID, LastName) VALUES ('data1', 'data2')");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/*

$REQUETE->query("UPDATE table_name  SET PersonID='rammasse miette'  WHERE  PersonID=data1");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/**/
/*
$REQUETE->query("SELECT FROM  table_name  LIMIT 100 ");

echo '<br />'.$REQUETE->num_rows;


/*
while( $R=$REQUETE->fetch_array() ){
	print_r($R);
}


/* JOINS non complet */

/*


$REQUETE->query("SELECT 
FROM table_name LEFT JOIN Customers 
ON   table_name.CustomerID=Customers.CustomerID   ");

while( $R=$REQUETE->fetch_array() ){
	print_r($R);
}

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/*

$REQUETE->query("DELETE FROM la-bible-parle-predication-jeff-laurin WHERE alias='predication-du-15-mars-2015-les-actes-des-apotres-partie-12' ");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/

/*

$REQUETE->query("TRUNCATE TABLE table_name");

/**/

//	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/	/





/*

$runnerTOTAL_end = microtime(true);
echo "\r\n".'Rendu TOTAL: '.number_format($runnerTOTAL_end - $runnerTOTAL,25)."\r\n";

/**/


/********************************************************demo end********************************************************/











?>