<?php 
include 'loadfunction2.php'; 
include 'modules.php'; 

@$myanswer = $_POST['choiceanswer'];
@$mynumber = $_POST['choicenumber']; 
@$mycode = $_POST['choicecode']; 
@$myhiring =  $_POST['choicehiring'];
@$username = $_COOKIE['usname']; 
$mynumber = $mynumber;

// echo $myanswer. ' ' . $mynewnumber . ' ' . $mycode; 
@$mysession = loadmysession($_COOKIE['usname'],$myhiring,$mycode); 

include 'dbconfig.php'; 

$mysqlme = "SELECT * from onlineresults Where qno Like '$mynumber' and session Like '$mysession' and username Like '$username' and course Like '$mycode' and hiringid Like '$myhiring'"; 
$dba = mysqli_query($sqlcon, $mysqlme); 


if(!mysqli_error($sqlcon))
{
    if(mysqli_num_rows($dba)!=0)
    {

        while($rows = mysqli_fetch_assoc($dba))
        {
            
            @$id = $rows['ID']; 
            $mystatus = ""; 
            if($myanswer==$rows['answer'])
            {
                $mystatus = "PASSED"; 
            }
            else 
            {
                $mystatus = "FAILED"; 
            }
            include 'dbconfig.php'; 
            $mysqli = "UPDATE onlineresults SET `uranswer`='$myanswer', `status`='$mystatus' Where ID Like '$id'"; 
            $dbx = mysqli_query($sqlcon, $mysqli); 

            if(!mysqli_error($sqlcon))
            {
                $mynumber = $mynumber + 1;
                echo loadmyquestion($mynumber,$mycode,$mysession,$myhiring);
            }
            else 
            {
                include 'forcookie.php'; 
            }
            
       
        }
    }
    else 
    {
        echo $mysqlme ;
       
    }
}
else 
{
echo mysqli_error($sqlcon);
}








?> 
