<?php

function mysqli_prepared_query($app, $link,$sql,$typeDef = FALSE,$params = FALSE){ 
	if($stmt = mysqli_prepare($link,$sql)){ 
		if(count($params) == count($params,1)){ 
			$params = array($params); 
			$multiQuery = FALSE; 
		} else { 
			$multiQuery = TRUE; 
		}
		
		if($typeDef){ 
			$bindParams = array();    
			$bindParamsReferences = array(); 
			$bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");         
			foreach($bindParams as $key => $value){ 
				$bindParamsReferences[$key] = &$bindParams[$key];  
			} 
			array_unshift($bindParamsReferences,$typeDef); 
			$bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
			$bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); 
		}
		
		$result = array(); 
		foreach($params as $queryKey => $query){ 
			foreach($bindParams as $paramKey => $value){ 
				$bindParams[$paramKey] = $query[$paramKey]; 
			} 
			$queryResult = array(); 
			if(mysqli_stmt_execute($stmt)){ 
				$resultMetaData = mysqli_stmt_result_metadata($stmt); 
				if($resultMetaData){                                                                               
					$stmtRow = array();   
					$rowReferences = array(); 
					while ($field = mysqli_fetch_field($resultMetaData)) { 
						$rowReferences[] = &$stmtRow[$field->name]; 
					}                                
					mysqli_free_result($resultMetaData); 
					$bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
					$bindResultMethod->invokeArgs($stmt, $rowReferences); 
					while(mysqli_stmt_fetch($stmt)){ 
						$row = array(); 
						foreach($stmtRow as $key => $value){ 
							$row[$key] = $value;           
						} 
						$queryResult[] = $row; 
					} 
					mysqli_stmt_free_result($stmt); 
				} else { 
					$queryResult[] = mysqli_stmt_affected_rows($stmt); 
				} 
			} else { 
				$queryResult[] = FALSE; 
			} 
			$result[$queryKey] = $queryResult; 
		} 
		mysqli_stmt_close($stmt);   
	} else { 
		
	    $app->logger->error("Error: Unable to connect to MySQL.");
	    $app->logger->error("Debugging errno: " . mysqli_errno($link) );
	    $app->logger->error("Debugging error: " . mysqli_error($link) );
	    exit();
	} 
	
	if($multiQuery){ 
		return $result; 
	} else {
		return $result[0]; 
	} 
} 
