<?php
session_start();
require('connection.php');

if(!isset($_SESSION['Logger']))
    header('Location: ../index.php');

if($_SESSION['Role'] == '1')
    $MainStatements = "email = '".$_SESSION['Email']."'";
else
    $MainStatements = "role <= '".$_SESSION['Role']."'";

$preSelectedDemos = [
    'FilteredQuery.Id',
    'FilteredQuery.Name',
    'FilteredQuery.Email',
    'FilteredQuery.Password',
    'FilteredQuery.ConfirmPassword',
    'FilteredQuery.Role',
    'FilteredQuery.Active',
    'FilteredQuery.CreatedAt',
    'FilteredQuery.UpdatedAt'
];

$OrderByArray = [];
$FilterStatements = '';
$Start = (isset($_POST['start'])) ? $_POST['start'] : 0;
$Limit = (isset($_POST['length'])) ? $_POST['length'] : 10;

if(!is_null($_POST['order']))
    foreach($_POST['order'] as $Order) {
        $OrderByArray[] = $preSelectedDemos[$Order['column']].' '.$Order['dir'];
    }

$OrderByString = (count($OrderByArray) > 0) ? 'ORDER BY '.implode(",", $OrderByArray) : '';

if($_POST['search']['value'] != '')
    $FilterStatements .= "WHERE MainQuery.Name LIKE '%".$_POST['search']['value']."%' OR MainQuery.Email LIKE '%".$_POST['search']['value']."%'";

    $queryString = "
            WITH MainQuery AS (
                SELECT
                    Id,
                    Name,
                    Email,
                    '' AS Password,
                    '' AS ConfirmPassword,
                    Role,
                    Active,
                    CreatedAt,
                    UpdatedAt
                FROM users
                WHERE $MainStatements
            ),
            TotalResult AS (
                SELECT count(*) As recordsTotal FROM MainQuery              
            ),
            FilteredQuery AS (
                SELECT
                    *
                FROM MainQuery
                $FilterStatements
            ),
            FilteredResult AS (
                SELECT
                    count(*) As recordsFiltered
                FROM FilteredQuery          
            )

            SELECT
                *
            FROM FilteredQuery, TotalResult, FilteredResult
            $OrderByString
            LIMIT $Start, $Limit
        ";

$Users =  mysqli_query($Conn,$queryString);

$array = [];
$array["data"] = [];
$array["draw"] = $_POST['draw'];

while($data  = mysqli_fetch_array($Users)){
    $array["data"][] = array_map("utf8_encode", $data);
}

$array["recordsTotal"] = (count($array["data"]) > 0) ? $array["data"][0]['recordsTotal'] : 0;
$array["recordsFiltered"] = (count($array["data"]) > 0) ? $array["data"][0]['recordsFiltered'] : 0;

$Users->close();

$jsonstring = json_encode($array);
echo $jsonstring;