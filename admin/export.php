<?php
require_once '../globals.php';
Is_Admin ();
$export = ''; // init
if (isset ( $_GET ['export'] ) && ($_GET ['export'] == 'contacts' || $_GET ['export'] == 'messages')) {
	$export = $_GET ['export'];
	// the file name
	$file = $export . ".csv";
	if (file_exists ( $file ))
		unlink ( "$file" ); // delete the old file
			                    // chech the table from the database
	System::Get ( 'db' )->Execute ( "SELECT*FROM `$export`" );
	if (System::Get ( 'db' )->AffectedRows ()) // check if there are rows
	{ // get the rows
		$values = System::Get ( 'db' )->GetRows ();
		if(count($values) != 0)
		{
			// start keep it in an excle sheet
			foreach ( $values as $key => $message )
			{
				if ($key == 0) // set the table header
				{
					foreach ( $message as $head => $vvv ) 
					{
						file_put_contents ( "$file", "\"" . $head . "\",", FILE_APPEND | LOCK_EX );
					}
					file_put_contents ( "$file", PHP_EOL, FILE_APPEND | LOCK_EX );
				}
				
				// the other content
				foreach ( $message as $set => $value ) 
				{
					file_put_contents ( "$file", "\"" . $value . "\",", FILE_APPEND | LOCK_EX );
				}
				
				file_put_contents ( "$file", PHP_EOL, FILE_APPEND | LOCK_EX );
			}
			System::RedirectTo ( '../' . $file );
		}
		else
		{
			echo "can't export".' <a href="../">HOME</a>';
		}
		
	}
	else
	{
		echo "There is no ".$export.' <a href="../">HOME</a>';
	}
} 
else 
{
	echo "can't export".' <a href="../">HOME</a>';
}
