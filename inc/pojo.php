<?php

/*
 * Copyright (c) 2007, Matias Muhonen <mmu@iki.fi>
 * 
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * Neither the name of the <ORGANIZATION> nor the names of its contributors may be
 * used to endorse or promote products derived from this software without specific
 * prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class Project {
	var $id;
	var $name;

	function get_id() {
		return $this->id;
	}

	function set_id($id) {
		$this->id = $id;
	}

	function get_name() {
		return $this->name;
	}

	function set_name($name) {
		$this->name = $name;
	}
}

class WorklogEntry {
	var $id;
	var $user;
	var $project;
	var $work_type;
	var $year;
	var $week;
	var $work_description;
	var $time_worked;

	function get_id() {
		return $this->id;
	}

	function set_id($id) {
		$this->id = $id;
	}

	function get_user() {
		return $this->user;
	}

	function set_user($user) {
		$this->user = $user;
	}

	function get_project() {
		return $this->project;
	}

	function set_project($project) {
		$this->project = $project;
	}

	function get_work_type() {
		return $this->work_type;
	}

	function set_work_type($work_type) {
		$this->work_type = $work_type;
	}

	function get_year() {
		return $this->year;
	}

	function set_year($year) {
		$this->year = $year;
	}

	function get_week() {
		return $this->week;
	}

	function set_week($week) {
		$this->week = $week;
	}

	function get_work_description() {
		return $this->work_description;
	}

	function set_work_description($work_description) {
		$this->work_description = $work_description;
	}

	function get_time_worked() {
		return $this->time_worked;
	}

	function set_time_worked($time_worked) {
		$this->time_worked = $time_worked;
	}
}

class User {
	var $id;
	var $username;
	var $firstname;
	var $lastname;

	function get_id() {
		return $this->id;
	}

	function get_username() {
		return $this->username;
	}

	function get_firstname() {
		return $this->firstname;
	}

	function get_lastname() {
		return $this->lastname;
	}

	function set_id($id) {
		$this->id = $id;
	}

	function set_username($username) {
		$this->username = $username;
	}

	function set_firstname($firstname) {
		$this->firstname = $firstname;
	}

	function set_lastname($lastname) {
		$this->lastname = $lastname;
	}
}

class WorkType {
	function get_id() {
		return $this->id;
	}

	function set_id($id) {
		$this->id = $id;
	}

	function get_code() {
		return $this->code;
	}

	function set_code($code) {
		$this->code = $code;
	}

	function get_name() {
		return $this->name;
	}

	function set_name($name) {
		$this->name = $name;
	}	
}

class TimeTrackingTable {
	var $data;
	var $width;
	var $height;

	function TimeTrackingTable() {
		$this->width = 0;
		$this->height = 0;
	}

	function get_data($row, $col) {
		return $this->data[$row][$col];
	}

	function set_data($row, $col, $item) {
		$this->data[$row][$col] = $item;
	}

	function set_size($no_rows, $no_cols) {
		$this->data = array();
		$this->width = $no_cols;
		$this->height = $no_rows;
		for ($r=0; $r < $no_rows; $r++) {
			for ($c=0; $c < $no_cols; $c++) {
				$this->data[$r][$c] = 0;
			}
		}
	}

	function get_width() {
		return $this->width;
	}

	function get_height() {
		return $this->height;
	}
}

class Week {
	var $week;
	var $year;

	function Week() {
	}

	function get_week() {
		return $this->week;
	}

	function get_year() {
		return $this->year;
	}

	function set_week($week) {
		$this->week = $week;
	}

	function set_year($year) {
		$this->year = $year;
	}

	function get_hash() {
		return $year . "-" . $week;
	}
}

?>
