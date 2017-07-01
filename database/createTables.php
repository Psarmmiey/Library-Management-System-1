<?php
/**
 * Created by PhpStorm.
 * User: DiniX
 * Date: 28-Jun-17
 * Time: 11:47 PM
 */


$connection = mysqli_connect('localhost','root','');
mysqli_select_db($connection,'LMS_DB')or die("Error occured");

//create admins table
$sql = "CREATE TABLE IF NOT EXISTS admins(
    id INT NOT NULL AUTO_INCREMENT, 
   admin_name VARCHAR(100) NOT NULL, 
   admin_type VARCHAR(20) NOT NULL, 
   username VARCHAR(50) NOT NULL UNIQUE, 
   pwd VARCHAR(50) NOT NULL,
   join_date timestamp(6) NOT NULL,
   last_login_date timestamp(6),
   admin_status VARCHAR(20),
   primary key ( id ))";
$retval = mysqli_query(  $connection, $sql );
if(! $retval ) {
    die('Could not create table: ');
}
echo "Table admins created successfully\n";



//create books table
$sql = "CREATE TABLE IF NOT EXISTS books(
        id INT NOT NULL,
        title VARCHAR(500) NOT NULL,
		author VARCHAR(500) NOT NULL,
        ISBN VARCHAR(50),
        category_no VARCHAR(50) NOT NULL,
        publisher_name VARCHAR(500) NOT NULL,
        published_date DATE NOT NULL,
        publisher_address VARCHAR(500)NOT NULL,
        price FLOAT NOT NULL,
        no_pages INT  NOT NULL,
        date_added TIMESTAMP(6) NOT NULL,
        book_type VARCHAR(100) NOT NULL,
        book_status VARCHAR(50) NOT NULL,
        remarks VARCHAR(1000),
        primary key (id))";
$retval = mysqli_query($connection,$sql);
if(!$retval){
    die('Could not create table:');
}
echo "Table books created successfully\n";



//create members table
$sql = "CREATE TABLE IF NOT EXISTS members(
        id VARCHAR(20) NOT NULL,
        member_name VARCHAR(100) NOT NULL,
        member_fullname VARCHAR(200) NOT NULL,
        member_type VARCHAR(20) NOT NULL,
        join_date timestamp(6) NOT NULL,
        addmission_date DATE NOT NULL,
        permanent_address VARCHAR(300),
        current_address VARCHAR(300),
        member_email VARCHAR(100),
        contact_no VARCHAR(20),
        member_status VARCHAR(30) NOT NULL,
        primary key(id)
        )";
$retval = mysqli_query($connection, $sql);
if(!$retval){
    die('could not create table:');
}
echo "Table member created successfully\n";

//create logins table
$sql = "CREATE TABLE IF NOT EXISTS logins(
    id INT NOT NULL , 
   password VARCHAR(50) NOT NULL, 
   last_login_date timestamp(6), 
   primary key ( id ))";
$retval = mysqli_query(  $connection, $sql );
if(! $retval ) {
    die('Could not create table: ');
}
echo "Table logins created successfully\n";


//create book_sessions table
$sql ="CREATE TABLE IF NOT EXISTS book_sessions(
    id INT NOT NULL,
  book_id INT NOT NULL,
  member_id VARCHAR(20) NOT NULL,
  date_of_borrowal DATE NOT NULL,
  date_to_be_returned DATE NOT NULL,
  date_of_returned DATE,
  session_status VARCHAR (20) NOT NULL,
  primary key(id),
  CONSTRAINT bk_id_fk foreign key(book_id) references books(id),
  CONSTRAINT m_id_fk foreign key(member_id) references members(id)
  )";
$retval = mysqli_query(  $connection, $sql );
if(! $retval ) {
    die('Could not create table: ');
}
echo "Table book_sessions created successfully\n";



mysqli_close($connection);
?>

