<?php

if(true)
{
	echo "Generatin folders...<br/>";
	
	if (!is_dir("./application/") && !mkdir("./application/")) {
		echo 'Failed to create application...';
	}
	if (!is_dir("./detail/") && !mkdir("./detail/")) {
		echo 'Failed to create detail...';
	}
	if (!is_dir("./detail/detail") && !mkdir("./detail/detail")) {
		echo 'Failed to create detail/detail...';
	}
	if (!is_dir("./index/") && !mkdir("./index/")) {
		echo 'Failed to create index...';
	}
	if (!is_dir("./progress/") && !mkdir("./progress/")) {
		echo 'Failed to create progress...';
	}
	if (!is_dir("./faq/") && !mkdir("./faq/")) {
		echo 'Failed to create faq...';
	}
	if (!is_dir("./search/") && !mkdir("./search/")) {
		echo 'Failed to create search...';
	}
	
    echo "Generating HTML...<br/>";
	
    file_get_contents('http://localhost/18laminas/public/');
    file_get_contents('http://localhost/18laminas/public/application');
	//file_get_contents('http://localhost/18laminas/public/application/index');
    file_get_contents('http://localhost/18laminas/public/index');
	//file_get_contents('http://localhost/18laminas/public/index/index');
    file_get_contents('http://localhost/18laminas/public/progress');
	//file_get_contents('http://localhost/18laminas/public/progress/progress');
    file_get_contents('http://localhost/18laminas/public/faq');
	//file_get_contents('http://localhost/18laminas/public/faq/faq');
    file_get_contents('http://localhost/18laminas/public/search');
	//file_get_contents('http://localhost/18laminas/public/search/search');
    
    
    echo "Generating Exercise pages...<br/>";
    for ($i = 1; $i <= 160; $i++) 
    {
        echo "Generating Exercise page ".$i."<br/>";
        file_get_contents('http://localhost/18laminas/public/detail/detail/'.$i);
        
        
        /*$path_to_file = './cache/detail/detail/'.$i;
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("\nH",",H",$file_contents);
        file_put_contents($path_to_file,$file_contents);*/
        
    }
    echo "Done Generating Exercise pages!<br/>";
    
    echo "Done!<br/>";
}
