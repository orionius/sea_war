<?php
$num_ship = 0;
$dot_coordinates = array();
//$ship_xy= [];
$ship_coordinates = [[]];
$current_y;
$current_x;

class Matrix
{
    public const MATRIX = [
        [1, 1, 0, 0, 1],
        [0, 0, 0, 0, 1],
        [1, 0, 1, 0, 1],
        [0, 0, 1, 0, 0]
    ];
    public $size_y;
    public $size_x;

    public function size()
    {
        for ($i = 0; $i < count(self::MATRIX); $i++) {
            for ($j = 0; $j < count(self::MATRIX[$i]); $j++) {
            }
        }
        $this->size_y = $i;
        $this->size_x = $j;
        return ['x' => $j, 'y' => $i];
    }
}

class Find extends Matrix
{

    public function horizontally($y)
    {
        $i = 0;
        for ($x = 0; $x < $this->size()[x]; $x++) {
            $data = self::MATRIX[$y][$x];
            if ($data == 1) {
                $ship_xy[] = ['y' => $y, 'x' => $x];
                if ((self::MATRIX[$y][$x + 1]) <= 0) {
                    if ($i <= 1) {
                        array_pop($ship_xy);
                        $ship_xy = array_filter($ship_xy);
                    }
                    break;
                }
            }
        }
                return $ship_xy; // current position
    }

    public function vertically($x)
    {
        $i = 0;
        for ($y = 0; $y < $this->size()[y]; $y++) {
            $data = self::MATRIX[$y][$x];
            if ($data == 1) {
                $i++;
                $ship_xy[] = ['y' => $y, 'x' => $x];
                if ((self::MATRIX[$y + 1][$x]) <= 0) {
                    if ($i <= 1) {
                        echo $i;
                        array_pop($ship_xy);
                        $ship_xy = array_filter($ship_xy, "count");
                    }
                    break;
                }
            }
        }
        return $ship_xy; // current position
    }
    public function oneDot()
    {
        $dot = 0;
        $ship_xy = [];
        for ($y = 0; $y < $this->size()[y]; $y++) {
            for ($x = 0; $x < $this->size()[x]; $x++) {
                if (self::MATRIX[$y][$x]) {
                    if (self::MATRIX[$y][$x + 1]) $dot++;
                    if (self::MATRIX[$y][$x - 1]) $dot++;
                    if (self::MATRIX[$y + 1][$x]) $dot++;
                    if (self::MATRIX[$y - 1][$x]) $dot++;
//                    echo "ffffffffffffff" . " y= " . $y . " x=" . $x . "----".$dot;
                    if ($dot == 0) {
                        $ship_xy[] = ['y' => $y, 'x' => $x];
                    }
                    $dot = 0;
                }
            }
        }
        //    var_dump($ship_xy);
        return $ship_xy;
    }
}
class Functions {
    public function dd(){
        echo '<pre>';
        array_map(function($x) { var_dump($x); }, func_get_args());
        die;
    }
}
/*================  body =======================*/
$matrix = new Matrix();
$find = new Find();

// ships for horizontally
for ($y = 0; $y < $matrix->size()[y]; $y++) {
    if (count($find->horizontally($y)) > 0) {
        $ship_coordinates[] = $find->horizontally($y);
    }
}

// ships for vertically
for ($x = 0; $x < $matrix->size()[x]; $x++) {
    if (count($find->vertically($x)) > 0) {
        $ship_coordinates[] = $find->vertically($x);
    }
}

// one dot
$ship_coordinates[] = $find->oneDot();

// result
$function = new Functions();
//$function->dd($ship_coordinates);

echo json_encode($ship_coordinates);