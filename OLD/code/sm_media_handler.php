<?php

class media_handler{
	
	function convert_media($filename, $rootpath, $inputpath, $outputpath, $width, $height, $bitrate, $samplingrate){
		$outfile = "";
		// root directory path, where FFMPEG folder exist in your application.
		$rPath = $rootpath."\ffmpeg";
		// which shows FFMPEG folder exist on the root.
		// Set Media Size that is width and hieght
		$size = $width."x".$height;
		// remove origination extension from file adn add .flv extension, becuase we must give output file name to ffmpeg command.
		$outfile =$filename;

		// Media Size
		$size = $width & "x" & $height;
		
		// remove origination extenstion from file and add .flv extension , becuase we must give output filename to ffmpeg command.
		
		$outfile = 'out_file.flv';
		// Use exec command to access command prompt to execute the following FFMPEG Command and convert video to flv format.
		
		$ffmpegcmd1 = "ffmpeg -i ".$inputpath."\\".$filename. " -acodec mp3 -ar " .$samplingrate." -ab ".$bitrate."	-f flv -s ".$size." ".$outputpath."\\".$outfile;
		$ret = shell_exec($ffmpegcmd1);
		
		// return output file name for other operations 
		return $outfile;
	}

	// Becuase FFMPEG can't set Buffering for flv files , so i use another tool that is FLVTool to set buffering of flv file. You must put all files with root folder into the main folder of your web application. -->
	function set_buffering($filename,$rootpath,$path){
		// root directory path
		$_rootPath = $rootpath."\flvtool";

		// Execute FLV TOOL command also on exec , you can also use other tool for executing command prompt commands.

		$ffmpegcmd1 = "flvtool2 -U ".$path."\\".$filename;
		$ret = shell_exec($ffmpegcmd1);
		
		// Execute this command to set buffering for FLV
	}
		
		// This function is used to Grab Thumbnail Image from Generated Flv files , to be display on the list, Note that, FFMPEG can create thumbnail only from FLV Files.. -->
		
	function grab_image($filename, $rootpath, $inputpath,$outputpath, $no_of_thumbs, $frame_number, $image_format, $width, $height)
		{
		// root directory path
		$_rootpath = $rootpath."\ffmpeg";
		// Media Size
		$size = $width. "x".$height;
		
		// I am using static image, you can dynamic it with your own choice.
		$outfile = "sample.png";
		
		$ffmpegcmd1 = "ffmpeg -i ".$inputpath."\\".$filename." -vframes ".$no_of_thumbs." -ss 00:00:03 -an -vcodec ". $image_format." -f rawvideo -s ".$size. " ". $outputpath."\\".$outfile;
		$ret = shell_exec($ffmpegcmd1);
		
		// Execute this command using exec command or any other tool to grab image from converted flv file.
		
		return $outfile;
	}
}

?>