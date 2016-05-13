<?php
	
class shiibashi{
	/*
	input matrix S, vector d,vector shop,vector shop
	*/
	private $supply;//supplyは行列（人数＊供給）
	private $demand;//demandはベクトル（需要）
	private $shop;//店舗ベクトル
	private $year;//ワーカーの勤続年数ベクトル
	function __construct(){
		$this->supply=array();
		$this->demand=array();
		$this->shop=array("A","B","C");
		$this->year=array();
	}
	
	public function setSupply($sup){
		$this->supply=$sup;		
	}
	public function getSupply(){
		return $this->supply;
	}
	public function setDemand($dem){
		$this->demand=$dem;
	}
	public function getDemand(){
		return $this->demand;
	}
	public function setShop($arr){
		$this->shop=$arr;
	}
	public function getShop(){
		return $this->shop;
	}
	public function setYear($arr){
		$this->year=$arr;
	}
	public function getYear(){
		return $this->year;
	}
	
	//solveする関数
	public function run(){
		//echo "00";
		$sol1=$this->solve_step1();
		//echo "11";
		$sol2=$this->solve_step2($sol1);
		return $sol2;
	}
	
	public function solve_step1(){
		//仕事が割り当てられたら1,そうでなければ0を返す
		//solution[i][j] i in person set, j in day set
		//
		
		$solution =array();//出力される解
		$solution=$this->supply;
		//echo count($solution)."  ".count($solution[0]);
		for($i=0;$i<count($solution);$i++){
			for($j=0;$j<count($solution[0]);$j++){
				$solution[$i][$j]=0;
				
			}
		}

		$supply_v=array();//日ごとの供給能力
		$day_ordered=array();//日のソート
		for($j=0;$j<count($this->demand);$j++){
				$supply_v[$j]=$this->sum_row($this->supply,$j);
				//echo $supply_v[$j]." <br>";
				if($supply_v[$j]<$this->demand[$j]){
					//供給が需要を満たせない日のシフトは確定
					$solution=$this->input_row($solution,$this->supply,$j);
				}
		}
		
		//dayのソートを行う
		$day_ordered=$this->sort_day($supply_v,$this->demand);

		$start_day=count($day_ordered);
		for($j=0;$j<count($day_ordered);$j++){
			if($supply_v[$day_ordered[$j]]>=$this->demand[$day_ordered[$j]]){
				$start_day=$j;
				break;
			}
		}
		
		for($j=$start_day;$j<count($day_ordered);$j++){
			//ソートされた日の順番にシフトを決める
				
			//仕事を割り振るワーカーの順番を決める
			$worker_ordered=$this->sort_worker($solution);
			$i=0;
			$k=0;
			//echo $this->demand[$day_ordered[$j]]." <br>";
			while($k<$this->demand[$day_ordered[$j]]){
					//demandの個数だけ割り振る
				
				if($this->supply[$worker_ordered[$i]][$day_ordered[$j]]==1){
					//person iが空いているかつ店の需要があるときに割り当て成立
					$solution[$worker_ordered[$i]][$day_ordered[$j]]=1;
					$k++;
				}
				$i++;
			}
			
		}
		
		return $solution;
		
	}
	
	public function solve_step2($sol1){
		//step1で得た解を各店舗に割り当てる
		
		$solution=$sol1;
		$rank=$this->rank_worker($sol1);
		
		$worker_shop=array();//[i][k] iがワーカー、kが店舗（shop数だけ）
		$worker_shop=$sol1;
		//echo "count(sol1) ".count($sol1)." <br>"; 
		for($i=0;$i<count($sol1);$i++){
			for($k=0;$k<count($this->shop);$k++){
				$worker_shop[$i][$k]=0;
			}
		}
		for($j=0;$j<count($this->demand);$j++){
			
			$supply_shop=array();
			$demand_shop=array();
			for($k=0;$k<count($this->shop);$k++){
				$supply_shop[$k]=0;
				$demand_shop[$k]=$this->demand[$j]/count($this->shop);
			}
			for($i=0;$i<count($rank);$i++){

				if($sol1[$rank[$i]][$j]==1){
					$ans=-1;
					$tmp=-1;
					for($k=0;$k<count($this->shop);$k++){
						
						if($supply_shop[$k]<$demand_shop[$k]){
							$tmp=$worker_shop[$rank[$i]][$k];
							$ans=$k;
						}
						
						if($supply_shop[$k]<$demand_shop[$k]&&$worker_shop[$rank[$i]][$k]>$tmp){
							$tmp=$worker_shop[$rank[$i]][$k];
							$ans=$k;
						}
					}
					
					if($ans!=-1){

						$sol1[$rank[$i]][$j]=$this->shop[$ans];
						$worker_shop[$rank[$i]][$ans]++;
						$supply_shop[$ans]++;
					}
				}
				 
			}
			
		}
		return $sol1;	
	}
	
	public function sum_row($arr,$k){
		//arr[][]のk列の和を返す
		$result=0;
		for($i=0;$i<count($arr);$i++){
			$result+=$arr[$i][$k];
		}
		return $result;
	}
	
	public function input_row($sol,$data,$k){
		//$solに$dataの$k列目を代入して返す
		for($i=0;$i<count($data);$i++){
			$sol[$i][$k]=$data[$i][$k];
		}
		return $sol;
	}
	
	public function sort_day($supply_v,$demand_v){
		//ソートされたday配列を返す
		$data=array();
		$solution=array();
	//	echo "count supply_v  ".count($supply_v)." <br>";
		$itr=0;
		//下間違いあり
		for($i=0;$i<count($supply_v);$i++){
			//if($supply_v[$i]>=$demand_v[$i]){
				$data[$itr]=$supply_v[$i]-$demand_v[$i];
				$itr++;
			//	echo "data[itr] ".$data[$itr-1]." <br>";
			//}
		}
	//	echo "array data <br>";
	//	var_dump($data);
		$result=asort($data,SORT_NUMERIC);
		for($i=0;$i<count($data);$i++){
			$solution[$i]=key($data);
			next($data);
		}
		
		return $solution;
	}
	
	public function sort_worker($Work){
		//$現在のシフト状況$Workを引数にdayの優先順位配列を返す
		$work_num=array();
		$solution=array();
		for($i=0;$i<count($Work);$i++){
			$work_num[$i]=array_sum($Work[$i]);
		}
		$result=asort($work_num,SORT_NUMERIC);
		for($i=0;$i<count($work_num);$i++){
			$solution[$i]=key($work_num);
			next($work_num);
		}
		return $solution; 
	}
	
	public function rank_worker($Work){
		//シフト状況$Workを引数にworkerのランク配列を返す
		$solution=array();
		$rank=array();
		//
		for($i=0;$i<count($this->year);$i++){
			$rank[$i]=$this->year[$i]*$this->year[$i]+array_sum($this->supply[$i]);
		}
		
		$result=arsort($rank,SORT_NUMERIC);
		for($i=0;$i<count($rank);$i++){
			$solution[$i]=key($rank);
			next($rank);
		}
		
		return $solution;
	}

	
	
}	
	



?>


