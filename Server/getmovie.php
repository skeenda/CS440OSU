<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$mygenre = $_GET['genre'];
$myyear = $_GET['year'];
$myrating = $_GET['rating'];
$myrandom = $_GET['random'];
$connection = mysqli_connect('classmysql.engr.oregonstate.edu', 'cs440_skeenda', 5895, cs440_skeenda);
if (!$connection) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($connection,"cs440_skeenda");
if (!($myrandom)) {
    if (($mygenre != "") && ($myyear != "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND startYear = '".$myyear."' AND IMDBratings.averageRating = '".$myrating."'";
    }
    if (($mygenre == "") && ($myyear != "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE startYear = '".$myyear."' AND IMDBratings.averageRating = '".$myrating."'";
    }
    if (($mygenre != "") && ($myyear == "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND IMDBratings.averageRating = '".$myrating."'";
    }
    if (($mygenre != "") && ($myyear != "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND startYear = '".$myyear."'";
    }
    if (($mygenre == "") && ($myyear == "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE IMDBratings.averageRating = '".$myrating."'";
    }
    if (($mygenre != "") && ($myyear == "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%'";
    }
    if (($mygenre == "") && ($myyear != "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE startYear = '".$myyear."'";
    }
}
else {
    if (($mygenre == "") && ($myyear == "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre != "") && ($myyear != "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND startYear = '".$myyear."' AND IMDBratings.averageRating = '".$myrating."' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre == "") && ($myyear != "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE startYear = '".$myyear."' AND IMDBratings.averageRating = '".$myrating."' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre != "") && ($myyear == "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND IMDBratings.averageRating = '".$myrating."' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre != "") && ($myyear != "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' AND startYear = '".$myyear."' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre == "") && ($myyear == "") && ($myrating != "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE IMDBratings.averageRating = '".$myrating."' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre != "") && ($myyear == "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE genres LIKE '%".$mygenre."%' ORDER BY RAND() LIMIT 1";
    }
    if (($mygenre == "") && ($myyear != "") && ($myrating == "")) {
        $sql="SELECT * FROM IMDBbasics INNER JOIN IMDBratings on IMDBratings.tconst = IMDBbasics.tconst WHERE startYear = '".$myyear."' ORDER BY RAND() LIMIT 1";
    }
}
$result = mysqli_query($connection,$sql);

echo "<table>
<tr>
<th>Movie Title</th>
<th>Year</th>
<th>Genre</th>
<th>Rating</th>
<th>Length</th>
<th>Cast</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['primaryTitle'] . "</td>";
    echo "<td>" . $row['startYear'] . "</td>";
    echo "<td>" . $row['genres'] . "</td>";
    echo "<td>" . $row['averageRating'] . "</td>";
    echo "<td>" . $row['runtimeMinutes'] . "</td>";
	$cast = mysqli_query($connection,"SELECT * FROM `Cast_Crew_View` WHERE tconst = '".$row['tconst']."'");
	echo "<td>";
	echo "<table>";
	echo "<tr>";
	echo "<th>Name</th>";
	echo "<th>Category</th>";
	echo "<th>Characters</th>";
	echo "</tr>";
	while($castRow = mysqli_fetch_array($cast)) {
		echo "<tr>";
		echo "<td>" . $castRow['primaryName'] . "</td>";
		echo "<td>" . $castRow['category'] . "</td>";
		if($castRow['characters'] === 'N'){
			$char = "";
		}
		else{
			$char = $castRow['characters'];
		}
		echo "<td>" . $char . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>