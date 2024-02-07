<?php
namespace App\Models\Concerns\Activity;
class ColumnChange {
    public function __construct(public $column, public $from, public $to, public $type) {
        $this->column = $column;
        $this->from = $from;
        $this->to = $to;
        $this->type = $type;
    }
}