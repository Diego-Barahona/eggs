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

                $sql2="SELECT  SUM(totalVenta) as ventas
                FROM venta
                WHERE MONTH(fechaVenta)=?";
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

                return array( "utilidades"=> $utilidades 
                ,"ventas" => $ventas,"compras" => $compras, "gastos" => $gastos,
                "credito" => $credito  );
                
        }
}