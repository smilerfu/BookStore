<?php

// require_once '../include.php';
require_once '../configs/configs.php';

/**
 * 数据库连接操作
 *
 * @return resource
 */
function connect()
{
	$link = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库连接失败Error" . mysql_errno() . ":" . mysql_error());
	mysql_set_charset(DB_CHARSET);
	mysql_select_db(DB_DBNAME) or die("指定数据库连接失败");
	return $link;
}

/**
 * 数据库记录插入操作
 * insert into table(key1, key2, ...) values(value1, value2, ...)
 *
 * @param unknown $table        	
 * @param unknown $array        	
 * @return number
 */
function insert($table, $array)
{
	connect();
	$keys = join(",", array_keys($array));
	$values = "'" . join("','", array_values($array)) . "'";
	$sql = "insert into {$table}($keys) values($values)";
	mysql_query($sql);
	return mysql_insert_id();
}

/**
 * 记录了更新操作
 *
 * @param unknown $table
 *        	update table set key = value where id=1
 * @param unknown $array        	
 * @param string $where        	
 * @return number
 */
function update($table, $array, $where = null)
{
	connect();
	$str = "";
	//var_dump($array);
	foreach($array as $key=>$val)
	{
		if($str == "")
		{
			$sep = "";
		}
		else
		{
			$sep = ",";
		}
		$str = $str . $sep . $key . "='" . $val . "'";
	}
	$sql = "update {$table} set {$str}" . ($where == null ? null : " where " . $where);
	//echo $sql;
	mysql_query($sql);
	return mysql_affected_rows();
}

/**
 * 删除数据记录
 *
 * @param string $table        	
 * @param string $where        	
 * @return number
 */
function delete($table, $where = null)
{
	connect();
	$where = $where == null ? null : " where " . $where;
	$sql = "delete from {$table}{$where}";
	mysql_query($sql);
	return mysql_affected_rows();
}

/**
 * 得到结果集中的某条记录
 *
 * @param string $sql        	
 * @param string $result_type        	
 * @return multitype:
 */
function fetchOne($sql, $result_type = MYSQL_ASSOC)
{
	connect();
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result, $result_type);
// 	foreach($row as $key=>$value)
// 	{
// 		echo $key . "=>" . $value . "<br>";
// 	}
	return $row;
}

/**
 * 得到结果集中的所有记录
 *
 * @param string $sql        	
 * @param string $result_type        	
 * @return unknown
 */
function fetchAll($sql, $result_type = MYSQL_ASSOC)
{
	connect();
	$result = mysql_query($sql);
	$rows = array();
	while(@$row = mysql_fetch_array($result, $result_type))
	{
		$rows[] = $row;
	}
// 	foreach($rows as $key=>$value)
// 	{
// 		echo $key . "=>" . $value . "<br>";
// 	}
	return $rows;
}

/**
 * 得到结果集中的记录条数
 *
 * @param string $sql        	
 * @return number
 */
function getResultNum($sql)
{
	connect();
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}

