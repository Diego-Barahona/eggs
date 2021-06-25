<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CardModel extends CI_Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function getDataCards()
        {       
                
                $mes=date("m");

                $sql1="SELECT  SUM(utilidades) as utilidades
                FROM utilidades u
                JOIN venta v ON u.codVenta = v.codVenta
                WHERE MONTH(v.fechaVenta)=?";
                $utilidades= $this->db->query($sql1,array($mes))->result();

                $sql2="SELECT  SUM(v.totalVenta) as ventas
                FROM venta v
                JOIN ventacigarro vc ON v.codVenta = vc.codVenta
                WHERE MONTH(v.fechaVenta)=?";
                $ventas= $this->db->query($sql2,array($mes))->result();

                $sql3="SELECT  SUM(costoGasto) as compras
                FROM costos";
                $compras= $this->db->query($sql3)->result();

                $sql4="SELECT  SUM(costoMonetarioGeneral) as gastos
                FROM gastosgenerales";
                $gastos= $this->db->query($sql4)->result();
                
                $sql5="SELECT  SUM(credito) as credito
                FROM deuda";
                $credito= $this->db->query($sql5)->result();

                $sql6="SELECT  SUM(v.totalVenta) as ventash
                FROM venta v
                JOIN ventahuevo vh ON v.codVenta = vh.codVenta
                WHERE MONTH(v.fechaVenta)=? ";
                $ventash= $this->db->query($sql6,array($mes))->result();

                return array( "utilidades"=> $utilidades 
                ,"ventas" => $ventas,"compras" => $compras, "gastos" => $gastos,
                "credito" => $credito , "ventash" => $ventash);
                
        }
}