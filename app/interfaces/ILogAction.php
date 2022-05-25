<?php
namespace App\interfaces;

interface ILogAction {

	public function toWrite($user, $action, $details);


}