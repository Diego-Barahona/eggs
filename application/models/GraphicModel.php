<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GraphicModel extends CI_Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function getUtilsByPeriod($data){

           $periodo = $data['periodo'];
           $year = $data['year'];
           //query que me trae utilidades por año 
           $sql0= "SELECT YEAR(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
           FROM  utilidades u 
           JOIN  venta v ON v.codVenta = u.codVenta
           GROUP BY YEAR(v.fechaVenta)"; 
           $byYear = $this->db->query($sql0)->result();
            
           //query que me trae utilidades por meses  de un año particular

           $sql2= "SELECT MONTH(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
           FROM  utilidades u 
           JOIN  venta v ON v.codVenta = u.codVenta
           WHERE  YEAR(v.fechaVenta)= ? 
           GROUP BY MONTH(v.fechaVenta)"; 
           $byMonth = $this->db->query($sql2,$year)->result();


           

           if($periodo =="1"){ 
            
              $year = $data['year'] ;

              $sql1= " SELECT  u.utilidades , v.fechaVenta fecha, v.codVenta codigo
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE YEAR(v.fechaVenta) = ? "; 
              $dates = $this->db->query($sql1,array($year))->result();

              $sql = " SELECT   YEAR(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE YEAR(v.fechaVenta) = ? "; 
              $res = $this->db->query($sql,array($year))->result();
              $array =array( $res ,  $byYear ,$dates );
              return $array;
           }

           if($periodo == "2"){
             
              $year = $data['year'];
              $month = $data['month'];
             
              $sql3= " SELECT  u.utilidades , v.fechaVenta fecha, v.codVenta codigo
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta = u.codVenta
              WHERE  MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
              $dates = $this->db->query($sql3,array($month,$year))->result();

              $sql4 = " SELECT   MONTH(v.fechaVenta) as tiempo, SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
              $res = $this->db->query($sql4,array($month,$year))->result();
              $array =array( $res ,$byMonth ,$dates);
         
              return $array;
           }
        }



}