<?php

class db {
	protected static $pdo;
	
	private static function connect() {
		if (!isset(self::$pdo)) {
			self::$pdo = new \PDO('mysql:host='.DBHOST.';dbname='.DATABASE, DBUSER, DBPASS,
			array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			self::$pdo->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
		}
	}
	
	public static function paginate($table, $args = false, $qtd=10, $options=array(), $order=false) {
		if (!isset($_GET['pagina']) || !is_numeric($_GET['pagina'])) $_GET['pagina'] = 1;
		if (!is_numeric($qtd)) $qtd = 10;
		if (!$order) $order = 'id';
		
		$pagina = $_GET['pagina'] - 1;
		$paggg = $pagina * $qtd;
		$orderby = "`$order` LIMIT $paggg,$qtd";
		
		$data = self::get_by_conditions($table, $args, $orderby);
		$total = self::count($table, $args);
		$total = $total[0]['COUNT(*)'];
		$ret['data'] = $data;
		
		$qtd_exib1 = ($_GET['pagina'] * $qtd) - count($data);
		$qtd_exib2 = $_GET['pagina'] * $qtd;

		if ($qtd_exib1 < 1) $qtd_exib1 = 1;
		if ($qtd_exib1 > $total) $qtd_exib1 = $total;
		if ($qtd_exib2 > $total) $qtd_exib2 = $total;
		
		$label_text = '<nav aria-label="Pagination">';
		
		
		$label_position = 'bot';
		if (isset($options['label_position'])) { $label_position = $options['label_position']; }
		$pag_size = '';
		if (isset($options['size'])) { $pag_size = 'pagination-'.$options['size']; }

		$ret['pagination'] = '';
		
		if ($label_position == 'top') $ret['pagination'] .=  $label_text;
		$ret['pagination'] .= '<ul class="pagination justify-content-center mt-5">';
		
		$url_array = clear_url($_SERVER['REQUEST_URI']);
		$url = implode('/', $url_array);
		$total_de_paginas = ceil($total/$qtd);
		$max_paginas = 8;
		
		if ($total_de_paginas < $max_paginas+1) {
			
			for ($i = 1; $i <= $total_de_paginas; $i++) {
				if ($i == $_GET['pagina']) { $active = " active"; } else { $active = ""; }
				$ret['pagination'] .= '
					<li class="page-item '.$active.'"><a href="'.$url.'.php?pagina='.$i.'">'.$i.'</a></li>
				';
			}
			
		} else {
			
			$init = ceil($_GET['pagina'] - ($max_paginas/2));
			$end = ceil($_GET['pagina'] + ($max_paginas/2));
			
			$prev = $next = true;
			if ($init < 2) {
				$end = $end-$init;
				$init = 1; 
				$prev = false; 
			}
			if ($end > ($total_de_paginas - 1)) {
				$init = $init + ($total_de_paginas - $end);
				$end = $total_de_paginas;
				$next = false;
			}
		
			if ($prev) {
				$ret['pagination'] .= '
					<li class="page-item"><a title="Primeira" href="'.$url.'.php?pagina=1"><i class="fa fa-fw fa-angle-double-left"></i></a></li>
					<li class="page-item disabled"><a style="cursor:default;" onclick="return false;" href="#">...</a></li>
				';
			}
			for ($i = $init; $i <= $end; $i++) {
				if ($i == $_GET['pagina']) { $active = " active"; } else { $active = ""; }
				$ret['pagination'] .= '
					<li class="page-item '.$active.'"><a href="'.$url.'.php?pagina='.$i.'">'.$i.'</a></li>
				';
			}
			if ($next) {
				$ret['pagination'] .= '
					<li class="page-item disabled"><a style="cursor:default;" onclick="return false;" href="#">...</a></li>
					<li class="page-item"><a title="Última" href="'.$url.'.php?pagina='.$total_de_paginas.'"><i class="fa fa-fw fa-angle-double-right"></i></a></li>
				';
			}
		}

		$ret['pagination'] .= '</ul></nav>';
		if ($label_position == 'bot') $ret['pagination'] .=  $label_text;
		
		return $ret;
	}
	
	public static function insert($table, $args) {
		self::connect();
		
		$query = "INSERT INTO `$table` (`"
		.implode('`, `', array_keys($args)).
		"`) VALUES ("
		.implode(', ', array_map(
				function($q) {
					return '?';
				}, array_keys($args)
			)
		).
		")";

		$sql = self::$pdo->prepare($query);

		$i = 1;
		foreach ($args as $value) {
			$sql->bindValue($i, $value);
			$i++;
		}

		return $sql->execute();
	}
	
	public static function update($table, $args) {
		self::connect();
		
		if (isset($args['id'])) {
			$id = $args['id'];
			unset($args['id']);
		} else {
			$id = '0';
		}
		
		$query = "UPDATE `$table` SET "
		.implode(', ', array_map(
				function($k) {
					return "`$k` = ?";
				},
				array_keys($args)
			)
		)." WHERE `id` = ?";

		$sql = self::$pdo->prepare($query);
		
		$i = 1;
		foreach ($args as $value) {
			$sql->bindValue($i, $value);
			$i++;
		}

		$sql->bindValue($i, $id);
		
		return $sql->execute();
	}

	public static function delete($table, $args) {
		self::connect();
		
		$query = "DELETE FROM `$table` WHERE `id` = ?";
		
		$sql = self::$pdo->prepare($query);
		$sql->bindValue(1, $args);
		
		return $sql->execute();
	}
	
	public static function get_all( $table, $order_by = false, $ASCDESC = 'ASC' ) {
		self::connect();
		
		$query = "SELECT * FROM `$table` WHERE 1";
		
		if ($order_by) {
			$query.= " ORDER BY `".$order_by."` ".$ASCDESC;
		}
		
		$sql = self::$pdo->query($query);
		
		$ret = array();
		if ($sql) {
			while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$ret[] = $row;
			}
		}
		
		return $ret;
	}

	public static function get_limit($table, $limit, $order_by = false, $ASCDESC = 'ASC' ) {
		self::connect();

		$query = "SELECT * FROM `$table` WHERE 1 ";

		if ($order_by) {
			$query.= " ORDER BY `".$order_by."` ".$ASCDESC;
		}

		$query .= " LIMIT ".$limit;

		$sql = self::$pdo->query($query);

		$ret = array();
		if ($sql) {
			while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$ret[] = $row;
			}
		}

		return $ret;
	}
	
	public static function get_by_id($table, $args) {
		self::connect();
		
		$query = "SELECT * FROM `$table` WHERE `id` = ?";

		$sql = self::$pdo->prepare($query);

		$sql->bindValue(1, $args);

		if ($sql->execute()) {
			if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				return $row;
			}
		}

		return false;
	}
	
	public static function get_by_conditions($table, $args = false, $order_by = false) {
		self::connect();

		if( $args ) {
            $query = "SELECT * FROM `$table` WHERE ";
            $query .= implode(' AND ', array_map(
                    function ($q) {
                        if( substr( $q, 0, 3 ) == '@#&' ){
                            $Comp = substr( $q, 3 );
                            $qq = "`$Comp` <> ?";
                        }else{
                            $qq = "`$q` = ?";
                        }

                        return $qq;
                    }, array_keys($args)
                )
            );
        }else{
            $query = "SELECT * FROM `$table` ";
        }
		
		if ($order_by) {
			$query .= " ORDER BY ".$order_by;
		}

		$sql = self::$pdo->prepare($query);
		
		$i = 1;

        if( $args ) {
            foreach ($args as $value) {
                $sql->bindValue($i, $value);
                $i++;
            }
		}

		$ret = array();
		if ($sql->execute()) {
			while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$ret[] = $row;
			}
		}
					
		return $ret;
	}
	
	public static function get_first($table) {
		self::connect();
		
		$query = "SELECT * FROM `$table` WHERE 1 LIMIT 0,1";
		
		$sql = self::$pdo->query($query);
		
		if ($sql) {
			if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				return $row;
			}
		}
		
		return false;
	}
	
	public static function count($table, $args=array()) {
		self::connect();
		
		$query = "SELECT COUNT(*) FROM `$table`";
		
		if (!empty($args)) {
			$query .= " WHERE ".implode(' AND ', array_map(
					function($q) {
						return "`$q` = ?";
					}, array_keys($args)
				)
			);
		}
		
		$sql = self::$pdo->prepare($query);
		
		$i = 1;

        if (!empty($args)) {
            foreach ($args as $value) {
                $sql->bindValue($i, $value);
                $i++;
            }
		}

		$ret = array();
		if ($sql->execute()) {
			while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$ret[] = $row;
			}
		}
					
		return $ret;
	}

	public static function getData($table, $pag, $filter) {
		self::connect();
		
		$query = "SELECT * FROM `$table` ";
		
		if ($filter) {
			$query .= "WHERE `$filter` ";
		}
		
		if ($pag) {
			if ($pag = 1) {
				$query .= "LIMIT 0,10";
			} else {
				$pag = $pag-1;
				$pag = 10*$pag;
				$pag2 = $pag+10;
				$query .= "LIMIT $pag,$pag2";
			}
		}

		$sql = self::$pdo->query($query);
		
		$ret = array();
		
		if ($sql) {
			if ($row = mysql_fetch_assoc($sql)) {
				$ret[] = $row;
				
				while ($row = mysql_fetch_assoc($sql)) {
					$ret[] = $row;
				}
			}
		}
		
		return $ret;
	}
	
	public static function get_meta($table) {
		self::connect();
		
		$dbase = DATABASE;
		$query = "SELECT 
		`COLUMN_NAME`,
		`IS_NULLABLE`,
		`DATA_TYPE`,
		`COLUMN_COMMENT`,
		`CHARACTER_MAXIMUM_LENGTH`,
		`COLUMN_KEY`
		FROM 
		`INFORMATION_SCHEMA`.`COLUMNS` WHERE 
		`TABLE_SCHEMA`='$dbase' AND `TABLE_NAME`='$table'";
		
		/*$query = "SELECT * FROM 
		`INFORMATION_SCHEMA`.`COLUMNS` WHERE 
		`TABLE_NAME`='$table'";*/
		
		$sql = self::$pdo->query($query);
		
		$ret = array();
		if ($sql->execute()) {
			while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				$row['COLUMN_COMMENT'] = self::parse_properties($row['COLUMN_COMMENT']);
				$ret[] = $row;
			}
		}
		
		return $ret;
	}
	
	public static function parse_properties($comment) {
		$properties = array();
	
		if ($comment != '' && $comment != null) {
			$comment = explode(';', $comment);
			foreach ($comment as $value) {
				$name = explode('{', $value);
				$name = trim($name['0']);
		
				preg_match('/\{(.*?)\}/i', $value, $str);
				
				$settings = array();
				if (!empty($str)) {
					foreach (explode(',', $str['1']) as $value) {
						$aux = explode('=', $value);
						$settings[trim($aux['0'])] = trim($aux['1']);
					}
					
					$properties[$name] = $settings;
					
				} else {
					$properties[$name] = array();
				}
			}
		}
		return $properties;
	}
	
	public static function excQuery($query) {
		self::connect();
	}
}