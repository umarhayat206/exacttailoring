<?php
/**
 * class DataOutput2Xml
 * export data with xml format to [PCG]
 * this class match for benchmarkthailand.com
 * @author POPPO Pattaya<piyaphata@gmail.com>
 * 
 */
 

class DataOutput2Xml{
    private $db;
	private
		$dbname ,
		$dbuser,
		$dbpassword,
		$dbhost,
		$url
		;

	private $_content=""; // Content text
	//private $catchXml="catchXml.xml";
	
	function __construct($sql="",$agentName="",$setting=array()){
		
		$this->dbname=$setting['dbname'];
		$this->dbuser=$setting['dbuser'];
		$this->dbpassword=$setting['dbpassword'];
		$this->dbhost=$setting['dbhost'];
		$this->url=$setting['url'];
		$this->_connectDB();
		
		$this->_content='<?xml version="1.0" encoding="UTF-8"?>
<member verifykey="XML Product Feed" name="' . $agentName . '">    
<products>';
			$this->_storeData($sql);
		
	} //
	/*
	function test($sql)
	{
		if($rows=$this->db->get_results($sql))
		{
			foreach($rows as $r)
			{
				$i++;
				echo "<h1>{$i}</h1>";
				print_r($r);
				echo "<h1>******************</h1>";
			}
		}
	}
	*/
	private function _storeData($sql)
	{
		if($rows=$this->db->get_results($sql))
		{
			
			$this->_content.='<numRows> ' . $this->db->num_rows . '</numRows>';
			
			//print_r($rows);
			foreach($rows as $r)
			{
				$this->_content.="<product>
					<product_id>" . $this->_xmlCheck($r->f_id) . "</product_id>
					<product_code>" . $this->_xmlCheck($this->strip_html_tags($r->f_code)) . "</product_code>
					<product_type>" . $this->_xmlCheck($this->strip_html_tags($r->ft_name)) . "</product_type>
					<product_price>" . $this->_xmlCheck($r->f_price_per_shirt) . "</product_price>
					<product_name>" . $this->_xmlCheck($this->strip_html_tags($r->f_name)) . "</product_name>
					<product_detail>" . $this->_xmlCheck($this->strip_html_tags($r->ft_description)) . "</product_detail>
					<images>http://exacttailoring.com/" . $this->_xmlCheck($r->f_image) . "</images>
				</product>
				";
			}
		}
		$this->_content.='</products></member>';
	}
	
	private function strip_html_tags( $text )
	   {
		   $text = preg_replace(
			   array(
				 // Remove invisible content
				   '@<head[^>]*?>.*?</head>@siu',
				   '@<style[^>]*?>.*?</style>@siu',
				   '@<script[^>]*?.*?</script>@siu',
				   '@<object[^>]*?.*?</object>@siu',
				   '@<embed[^>]*?.*?</embed>@siu',
				   '@<applet[^>]*?.*?</applet>@siu',
				   '@<noframes[^>]*?.*?</noframes>@siu',
				   '@<noscript[^>]*?.*?</noscript>@siu',
				   '@<noembed[^>]*?.*?</noembed>@siu',
				 // Add line breaks before and after blocks
				   '@</?((address)|(blockquote)|(center)|(del))@iu',
				   '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				   '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				   '@</?((table)|(th)|(td)|(caption))@iu',
				   '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				   '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				   '@</?((frameset)|(frame)|(iframe))@iu',
			   ),
			   array(
				   ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				   "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				   "\n\$0", "\n\$0",
			   ),
			   $text );
		   return strip_tags( $text );
	   }
	
	/*
	private function _doFeatures($resource)
	{
		if($resource->prop_view!="")
		{
			$return.='<feature name="' . $resource->prop_view . '"/>';
		}
		if($resource->prop_set_golfcourse>0)
		{
			$return.='<feature name="golf course"/>';
		}
		if($resource->prop_tv!="")
		{
			$return.='<feature name="' . $resource->prop_tv . '"/>';
		}
		if($resource->prop_livingroom!="")
		{
			$return.='<feature name="Living Room"/>';
		}
		if($resource->prop_diningarea!="")
		{
			$return.='<feature name="Dining Area"/>';
		}
		if($resource->prop_kitchen!="")
		{
			$return.='<feature name="Kitchen"/>';
		}
		if($resource->prop_maid!="")
		{
			$return.='<feature name="Maid"/>';
		}
		if($resource->prop_washing!="")
		{
			$return.='<feature name="washing machine"/>';
		}
		if($resource->prop_furnish!="")
		{
			$return.='<feature name="' . $resource->prop_furnish . '"/>';
		}
		if($resource->prop_security!="")
		{
			$return.='<feature name="' . $resource->prop_security . '"/>';
		}
		if($resource->prop_hotwater!="")
		{
			$return.='<feature name="' . $resource->prop_hotwater . '"/>';
		}

		return $return;
	}
	
	private function _doImages($resource)
	{
		
		for($i=1;$i<=8;$i++)
		{
			$fieldName="prop_image".$i;
			if($resource->$fieldName!="")
			{
				$re.='<image thumb="' . $this->url.'administrator/thumb/'.$this->__imageNameCheck($resource->$fieldName) . '" path="' . $this->url."administrator/pictures/". $this->__imageNameCheck($resource->$fieldName) . '" default="' .(($i==1)?"true":"false") . '"/>';
			}
		}
		return $re;
	}
	*/
	
	private function __imageNameCheck($text)
	{
		$text=trim($text);
		$text=str_replace("&","&amp;",$text);
		$text=str_replace(" ","%20",$text);
		
		return $text;
	}
	function output()
	{
		header("Content-type: text/xml;  charset=utf-8");
		echo $this->_content;
		exit;
	}
	
	private function _connectDB()
	{
		include("ez_sql_core.php");
		include("ez_sql_mysql.php");
		$this->db=new ezSQL_mysql($this->dbuser, $this->dbpassword ,$this->dbname,$this->dbhost);
		
		
		// Cache expiry
		//$this->db->cache_timeout = 24; // Note: this is hours
	
		// Specify a cache dir. Path is taken from calling script
		//$this->db->cache_dir = 'sql_cache';
	
		// (1. You must create this dir. first!)
		// (2. Might need to do chmod 775)
	
		// Global override setting to turn disc caching off
		// (but not on)
		//$this->db->use_disk_cache = true;
	
		// By wrapping up queries you can ensure that the default
		// is NOT to cache unless specified
		//$this->db->cache_queries = true;
	}
	
	private function _xmlCheck($text)
	{
		/*
		$text=trim($text);
		$text=str_replace("’","&quot",$text);
		$text=str_replace("�","&quot",$text);
		$text=str_replace("&amp;","&",$text);
		$text=str_replace("&","&amp;",$text);
		$text=str_replace(" < ","&lt;",$text);
		$text=str_replace(" > ","&gt;",$text);
		$text=str_replace("'","&quot;",$text);
		$text=str_replace("/"," ",$text);
		*/
		
		$replace = array('([\40])','([^a-zA-Z0-9-\.])','(-{2,})');
		 $with = array(' ',' ',' ');
		$text = preg_replace($replace,$with,$text);
		
		return $text;
	}
	
	private function removeHTML($html_body){
		$search = array('@<script[^>]*?>.*?</script>@si','@<style[^>]*?>.*?</style>@siU','@<[\/\!]*?[^<>]*?>@si','@<![\s\S]*??[ \t\n\r]*>@','/\s{2,}/');

		$text = preg_replace($search, "\n", $html_body);

		$pat[0] = "/^\s+/";
		$pat[2] = "/\s+\$/";
		$rep[0] = "";
		$rep[2] = " ";

		$text = preg_replace($pat, $rep, trim($text));

		return $text; 
	}//__end func__//

} // n class
