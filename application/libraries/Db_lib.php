<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_lib 
{
	/*
	*	Fetch Single Record
	*/
	
	function fetchRecord($strTableName, $strWhere = NULL, $arrFields = NULL, $intDebug=0)
	{
		$CI =& get_instance();
		
		if ($arrFields==NULL)
			$strColsList = '*';
		else
			$strColsList = $arrFields ;
		
		$strSql = 'SELECT '.$strColsList.' FROM '.$strTableName;
		if( $strWhere != NULL )
			$strSql .= ' WHERE '.$strWhere;
	
		if($intDebug == 1)
			//echo $strSql;
		$CI->db->query("SET SQL_BIG_SELECTS=1");
		$query = $CI->db->query($strSql);
		
		if ($query->num_rows() > 0)
			return $arrResult = $query->row_array();

		return 0;
	}
	
	/*
	*	Fetch Multiple Records
	*/
	
	function fetchRecords($strTableName, $strWhere = NULL, $arrFields = NULL, $intDebug=0)
	{
		$CI =& get_instance();
		
		$sql = "SET group_concat_max_len = 10485760;";
		$CI->db->query($sql);
		
		if ($arrFields==NULL)
			$strColsList = '*';
		else
			$strColsList = $arrFields ;
		
		$strSql = 'SELECT '.$strColsList.' FROM '.$strTableName;
		if( $strWhere != NULL )
			$strSql .= ' WHERE '.$strWhere;
	
		if($intDebug == 1)
			echo $strSql;
		
		$CI->db->query("SET SQL_BIG_SELECTS=1");
		$query = $CI->db->query($strSql);
		
		if ($query->num_rows() > 0)
			return $arrResult = $query->result_array();
			
		return 0;
	}	
	
	/*
	*	Insert Record
	*/
	
	function insert($strTableName, $arrData, $intDebug=0 ) 
	{
		$CI =& get_instance();
		
		if(count($arrData)==0){
			return 0;
		}
		
		$arrInsert = $this->match($strTableName, $arrData);
		
		if(count($arrInsert)==0){
			return 0;
		}
		
		if($intDebug==1){
			echo $CI->db->insert_string($strTableName,$arrInsert);
			exit();
		}
		
		$CI->db->insert($strTableName,$arrInsert); 
		return $CI->db->insert_id();
	}
	
	/*
	*	Update Record
	*/
	
	function update( $strTableName, $arrData, $strWhere, $intDebug=0 ) 
	{
		$CI =& get_instance();
		
		if(count($arrData)==0){
			return 0;
		}
				
		$arrUpdate = $this->match($strTableName, $arrData);
		if(count($arrUpdate)==0){
			return 0;
		}
		
		/*--- Checking For Same Data ( existing record and data to be updated ) --- */
		$select = implode(",", array_keys($arrUpdate));
		$existData = $this->fetchRecord($strTableName, $strWhere, $select);
		if( $existData === $arrUpdate  )	// if same then no need to update it. Return updation success.
			return 1;
		/* ------------------------------------------------------------------- */
		
		if($intDebug==1){
			echo $CI->db->update_string($strTableName,$arrUpdate,$strWhere);
			exit();
		}
		
		$CI->db->update($strTableName,$arrUpdate,$strWhere); 
		if($CI->db->affected_rows()!=0){
			return 1;
		}		
		return 0;
	}
		
	/*
	*	Delete Record
	*/
	
	function delete($strTableName, $strWhere)
	{		
		$CI =& get_instance();
		
		$CI->db->where($strWhere);
		$CI->db->delete($strTableName);
		
		if($CI->db->affected_rows()!=0){
			return 1;
		}		
		return 0;	
	}
	
	/*
	*	Delete All Records
	*/
	
	function empty_table($strTableName)
	{		
		$CI =& get_instance();

		$CI->db->empty_table($strTableName);
		
		if($CI->db->affected_rows()!=0){
			return 1;
		}		
		return 0;	
	}

	/*
	*	Truncate Table
	*/
	
	function truncate($strTableName)
	{		
		$CI =& get_instance();
		$CI->db->truncate($strTableName); 
		return 1;
	}
	
	/*
	*	Match Data fields with table columns
	*/
	
	public function match($strTableName , $arrData)
	{
		$CI =& get_instance();
		
		$query = $CI->db->query('DESC '.$strTableName);
		
		$arrTableColumns = array();
		if ($query->num_rows() > 0) {
			foreach($query->result_array() as $row){
				$arrTableColumns[trim($row['Field'])]=trim($row['Field']);
			}
		}	
		
		$arrQdata = array();
		foreach( $arrData as $column=>$value ){
			foreach( $arrTableColumns as $tableKey => $tableValue){
				if( trim($column) == trim($tableKey)){
					$arrQdata[$column] = $value;
					break;
				}
			}
		}
		return $arrQdata;
	}
	public function Dateformater($date){
		if($date){
			$dateformate= date('d/m/Y',strtotime($date));
			return $dateformate;
		}
	}
	public function dateformatedatabase($date){
		if($date){
			$dateformate= date('Y-m-d',strtotime($date));
			return $dateformate;
		}
	}
	function getName($strTableName, $strWhere = NULL, $arrFields = NULL, $intDebug=0)
	{
		$CI =& get_instance();
		
		$sql = "SET group_concat_max_len = 10485760;";
		$CI->db->query($sql);
		
		if ($arrFields==NULL)
			$strColsList = '*';
		else
			$strColsList = $arrFields ;
		
		$strSql = 'SELECT '.$strColsList.' FROM '.$strTableName;
		if( $strWhere != NULL )
			$strSql .= ' WHERE '.$strWhere;
	
		if($intDebug == 1)
			echo $strSql;
		
		$CI->db->query("SET SQL_BIG_SELECTS=1");
		$query = $CI->db->query($strSql);
		
		if ($query->num_rows() > 0)
			$arrResult =  $query->row();
			return $name=$arrResult->$strColsList;
			
		return 0;
	}
}