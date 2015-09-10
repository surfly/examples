<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: Content-Type');

/*

Use Below sql to create table for maintain queue data

CREATE TABLE IF NOT EXISTS `incoming_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `viewer_link` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
*/

$con = mysqli_connect("localhost","vino247","","surfly");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_POST['viewer_link']))
{
    $sql = "INSERT INTO incoming_queue (session_id, url, viewer_link, status)
    VALUES ('". $_POST['id'] ."', '". $_POST['url'] ."', '". $_POST['viewer_link'] ."', 1)";
    
    mysqli_query($con, $sql);
    echo mysqli_insert_id($con);
    exit;
}
elseif(isset($_GET['action']) && $_GET['action'] == 'update_queue_status')
{
    echo $sql = "UPDATE incoming_queue SET status=0 WHERE id=". $_GET['queue_id'];
    
    mysqli_query($con, $sql);
    exit;
}
elseif(isset($_GET['action']) && $_GET['action'] == 'get_list')
{
    $queue_list = mysqli_query($con, "Select * from incoming_queue where status = 1");
    $result = array();
    if(mysqli_num_rows($queue_list)){
	    while($row = mysqli_fetch_assoc($queue_list)){
	        $result[] = $row;
	    }
    }
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

$queue_list = mysqli_query($con, "Select * from incoming_queue where status = 1");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Custom Javascript Endpoint Dashboard - Surfly Code Samples</title>
		<link rel="stylesheet" href="style.css">
		<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	</head>
	<body>
		<header>
			<a href=" https://www.surfly.com/ ">
				<img alt="Delicious Mint" src="https://www.surfly.com/wp-content/themes/delicious/img/mint/logo.png">
			</a>
		</header>
		<div class="main_container">
			<h1>Custom Javascript Endpoint Dashboard</h1>
			<div class="source_link">
				<p><b>Source code</b> : <a href="https://github.com/surfly/examples/blob/gh-pages/custom_queue_functionality/queue_handler_dashboard.html" target="_blank"> Github</a></p>
			</div>
			<table id="queue" width="100%">
				<thead>
					<tr>
						<th>Id</th>
						<th>User Link</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				    <?php 
				    if(mysqli_num_rows($queue_list)){
				    while($row = mysqli_fetch_assoc($queue_list)){?>
    				    <tr>
    				        <td><?php echo $row['session_id']; ?></td>
    				        <td><?php echo $row['url']; ?></td>
    				        <td><a target="_blank" onclick="call_taken(<?php echo $row['id']; ?>)" href="<?php echo $row['viewer_link']; ?>">Join</a></td>
    				    </tr>
				    <?php }}?>
				</tbody>
			</table>
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
			   setInterval(function(){
			       $.get("https://surfly-examples-vino247-1.c9.io/?action=get_list", function(response){
			           $html = '';
			           $.each(response, function(k,data){
			               $html += '<tr><td>'+data.session_id+'</td><td>'+data.url+'</td><td><a onclick="call_taken(\''+ data.id +'\')" target="_blank" href="'+data.viewer_link+'">Join</a></td></tr>';
			           });
			           $("#queue tbody").html($html);
			       });
			   }, 5000);
			});
			
			function call_taken(id)
			{
				$.get("https://surfly-examples-vino247-1.c9.io/?action=update_queue_status&queue_id="+id, function(response){
					console.log(response);
				});
			}
		</script>
	</body>
</html>
<?php
mysqli_close($con);